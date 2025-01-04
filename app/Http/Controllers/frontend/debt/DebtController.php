<?php

namespace App\Http\Controllers\frontend\debt;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\frontend\currency\Currency;
use Illuminate\Support\Facades\Http;
use App\Models\frontend\debt\ExternalDebt;
use App\Models\frontend\debt\InternalDebt;

class DebtController extends Controller
{
    // External Debt (كما هو موجود)
    public function externalDebt()
    {
        $externalDebts = ExternalDebt::with('user')->get();
        return view('frontend.debt.external-debt.index', compact('externalDebts'));
    }

    public function externalCreate()
    {
        $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/USD');
        $data = $response->json();
        $minus = Currency::all();
        // استخراج العملات من البيانات
        $currencies = $data['conversion_rates'];
        $users = User::all();
        return view('frontend.debt.external-debt.create', compact('users','currencies','minus'));
    }

    public function externalStore(Request $request) {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'recipient' => 'required|string|max:255',
            'reason' => 'required|string',
            'manual_deduction' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
            'deduction_source' => 'required|in:cash,currency',
            'currency_id' => 'nullable|exists:currencies,id', // تأكد من التحقق من عملة الـ currency_id
        ]);

        $user = auth()->user();
        $userCurrency = $user->currency; // العملة الخاصة بالمستخدم
        $manualDeduction = $validated['manual_deduction'] ?? null; // إذا تم إدخال سعر يدوي
        $amount = $validated['amount'];
        $currency = $validated['currency'];

        // إذا لم يتم إدخال سعر يدوي، استخدام سعر الصرف العادي
        $conversionRate = $manualDeduction ?? $this->ExternalGetConversionRate($currency, $userCurrency);

        // تحويل المبلغ إلى العملة الخاصة بالمستخدم
        $convertedAmount = $this->ExternalConvertCurrencyAmount($currency, $userCurrency, $amount, $manualDeduction);

        // التحقق من المصدر والخصم
        if ($validated['deduction_source'] === 'cash') {
            if ($convertedAmount > $user->cash) {
                return back()->withErrors(['amount' => 'Insufficient cash to create this debt.']);
            }
            $user->cash -= $convertedAmount; // خصم المبلغ المحول
            $user->save();
        } elseif ($validated['deduction_source'] === 'currency' && $validated['currency_id']) {
            // إذا تم اختيار "الخصم من العملة"
            $currencyRecord = Currency::findOrFail($validated['currency_id']);
            if ($convertedAmount > $currencyRecord->amount) {
                return back()->withErrors(['amount' => 'Insufficient currency amount to create this debt.']);
            }
            $currencyRecord->amount -= $convertedAmount; // خصم المبلغ المحول
            $currencyRecord->save();
        } else {
            return back()->withErrors(['deduction_source' => 'Invalid deduction source.']);
        }

        // إنشاء سجل الدين الخارجي
        $debtData = [
            'user_id' => $validated['user_id'],
            'amount' => $amount,
            'recipient' => $validated['recipient'],
            'reason' => $validated['reason'],
            'manual_deduction' => $manualDeduction,
            'currency' => $currency,
            'converted_amount' => $convertedAmount, // حفظ المبلغ بعد التحويل
            'conversion_rate' => $conversionRate, // حفظ سعر الصرف
        ];

        ExternalDebt::create($debtData);

        return redirect()->route('external.debt')->with('success', 'External debt record created successfully.');
    }



    private function ExternalConvertCurrencyAmount($fromCurrency, $toCurrency, $amount, $manualExchangeRate = null) {
        // إذا تم إدخال سعر يدوي
        if ($manualExchangeRate) {
            return round($amount / $manualExchangeRate, 2); // استخدام السعر اليدوي
        }

        // إذا لم يتم إدخال سعر يدوي، استخدام API للحصول على سعر الصرف العادي
        $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/' . $fromCurrency);
        $data = $response->json();

        if ($response->ok() && isset($data['conversion_rates'][$toCurrency])) {
            $rate = $data['conversion_rates'][$toCurrency];
            return round($amount * $rate, 2); // التقريب إلى رقمين عشريين
        }

        throw new \Exception("Conversion rate not found for $fromCurrency to $toCurrency.");
    }


    private function ExternalGetConversionRate($fromCurrency, $toCurrency) {
        $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/' . $fromCurrency);
        $data = $response->json();
        if ($data && isset($data['conversion_rates'][$toCurrency])) {
            return $data['conversion_rates'][$toCurrency];
        }
        throw new \Exception("Conversion rate not found for $fromCurrency to $toCurrency.");
    }



    // Internal Debt (التعديل ليكون مشابه للـ ExternalDebt)
    public function internalDebt()
    {
        $internalDebts = InternalDebt::with('user')->get();
        return view('frontend.debt.internal-debt.index', compact('internalDebts'));
    }

    public function internalCreate()
    {
        $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/USD');
        $data = $response->json();
        $minus = Currency::all();

        $currencies = $data['conversion_rates'];
        $users = User::all();
        return view('frontend.debt.internal-debt.create', compact('users','currencies','minus'));
    }

    public function internalStore(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
            'recipient' => 'required|string|max:255',
            'reason' => 'required|string',
            'manual_deduction' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
        ]);

        $user = auth()->user(); // جلب المستخدم الحالي
        $userCurrency = $user->currency;

        $manualDeduction = $validated['manual_deduction'] ?? 0;
        $currency = $validated['currency'];
        $exchangeRate = $this->ExternalGetConversionRate($userCurrency, $currency);

        $convertedAmount = $this->ExternalConvertCurrencyAmount($currency, $userCurrency, $validated['amount'], $manualDeduction);

        if ($convertedAmount > $user->cash) {
            return back()->withErrors(['amount' => 'Insufficient cash to create this currency.']);
        }

        // خصم المبلغ من الكاش
        $user->cash -= $convertedAmount;
        $user->save();

        // إنشاء سجل الدين الداخلي
        $debtData = [
            'user_id' => $validated['user_id'],
            'amount' => $validated['amount'],
            'recipient' => $validated['recipient'],
            'reason' => $validated['reason'],
            'manual_deduction' => $manualDeduction,
        ];

        InternalDebt::create($debtData);

        return redirect()->route('internal.debt')->with('success', 'Internal debt record created successfully.');
    }

    public function internalEdit($id)
    {
        $debt = InternalDebt::findOrFail($id);
        $users = User::all();
        return view('frontend.debt.internal-debt.edit', compact('debt', 'users'));
    }

    public function internalUpdate(Request $request, $id)
    {
        // التحقق من صحة المدخلات
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
            'recipient' => 'required|string|max:255',
            'reason' => 'required|string',
            'manual_deduction' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
        ]);

        // العثور على السجل الحالي باستخدام ID
        $debt = InternalDebt::findOrFail($id);

        // جلب المستخدم الحالي
        $user = auth()->user();

        // الحصول على المبلغ اليدوي إذا تم تحديده
        $manualDeduction = $validated['manual_deduction'] ?? 0;
        $currency = $validated['currency'];

        // الحصول على سعر الصرف وتحويل المبلغ
        $exchangeRate = $this->ExternalGetConversionRate($user->currency, $currency);

        // تحويل المبلغ باستخدام سعر الصرف
        $convertedAmount = $this->ExternalConvertCurrencyAmount($currency, $user->currency, $validated['amount'], $manualDeduction);

        // التحقق من كفاية المبلغ
        if ($convertedAmount > $user->cash) {
            return back()->withErrors(['amount' => 'Insufficient cash to create this currency.']);
        }

        // خصم المبلغ من الكاش
        $user->cash -= $convertedAmount;
        $user->save();

        // تحديث سجل الدين الداخلي
        $debt->update([
            'user_id' => $validated['user_id'],
            'amount' => $validated['amount'],
            'recipient' => $validated['recipient'],
            'reason' => $validated['reason'],
            'manual_deduction' => $manualDeduction,
        ]);

        return redirect()->route('internal.debt')->with('success', 'Internal debt record updated successfully.');
    }

    public function internalDelete($id)
    {
        $debt = InternalDebt::findOrFail($id);
        $debt->delete();

        return redirect()->route('internal.debt')->with('success', 'Internal debt record deleted successfully.');
    }
}