<?php

namespace App\Http\Controllers\frontend\currency;

use Illuminate\Http\Request;
use App\Services\CurrencyConverter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\frontend\category\Category;
use App\Models\frontend\currency\Currency;
use App\Models\frontend\transaction\Transaction;

class CurrencyController extends Controller
{
    // إنشاء
    public function create()
    {
        $categories = Category::where('user_id', auth()->user()->id)->get();

        // إرسال طلب إلى API للحصول على بيانات العملات
        $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/USD');
        $data = $response->json();

        // استخراج العملات من البيانات
        $currencies = $data['conversion_rates'];

        // تمرير البيانات إلى الـ view
        return view('frontend.currency.create', compact('categories', 'currencies'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'manual_exchange_rate' => 'nullable|numeric',
            'recipient_amount' => 'nullable|numeric',
            'recipient_currency' => 'nullable|numeric',
            'MRU' => 'nullable|string|max:255',
        ]);

        $user = auth()->user(); // جلب المستخدم الحالي
        $userCurrency = $user->currency; // العملة الخاصة بالمستخدم

        // تحقق من وجود سعر الصرف اليدوي أو استخدم سعر الصرف من الـ API
        $exchangeRate = $data['manual_exchange_rate'] ?? $this->getConversionRate($userCurrency, $data['currency']);

        // حساب المبلغ المحول باستخدام السعر المختار
        $convertedAmount = $this->convertCurrencyAmount($data['currency'], $userCurrency, $data['amount'], $data['manual_exchange_rate'] ?? null);

        // تحقق من توفر الكاش بعد التحويل
        if ($convertedAmount > $user->cash) {
            return back()->withErrors(['amount' => 'Insufficient cash to create this currency.']);
        }

        // خصم المبلغ من الكاش بناءً على سعر الصرف
        $user->cash -= $convertedAmount;
        $user->save();

        // إضافة المبلغ المحول إلى العملة الجديدة في قاعدة البيانات
        $data['user_id'] = $user->id;
        $data['recipient_currency'] = $convertedAmount; // تخزين القيمة المحوّلة

        $currency = Currency::create($data);

        // إضافة معاملة جديدة لتخزين العملية
        Transaction::create([
            'user_id' => $user->id,
            'currency_id' => $currency->id,
            'from_currency' => $userCurrency, // العملة الخاصة بالمستخدم
            'to_currency' => $data['currency'], // العملة الجديدة
            'amount_from' => 0, // المبلغ من العملة القديمة (ليس هناك مبلغ قديم في حالة الإنشاء)
            'amount_to' => $data['amount'], // المبلغ الجديد
            'conversion_rate' => $exchangeRate, // استخدام السعر المختار
            'transaction_date' => now(),
        ]);

        return redirect()->route('home.page')->with('success', 'Currency created and transaction recorded!');
    }




public function edit($currencyId)
{
    $transactions = Transaction::where('currency_id', $currencyId)
        ->orderBy('transaction_date', 'desc')
        ->get();
    $currency = Currency::findOrFail($currencyId);
    $categories = Category::where('user_id', auth()->user()->id)->get();

    // إرسال بيانات API
    $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/USD');
    $data = $response->json();

    // الحصول على أسعار العملات
    $currencies = $data['conversion_rates'];

    return view('frontend.currency.edit', compact('currency', 'categories', 'currencies', 'transactions'));
}

    private function getConversionRate($fromCurrency, $toCurrency)
{
    $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/' . $fromCurrency);
    $data = $response->json();

    if ($data && isset($data['conversion_rates'][$toCurrency])) {
        return $data['conversion_rates'][$toCurrency];
    }

    return 1;
}
private function convertCurrencyAmount($fromCurrency, $toCurrency, $amount, $manualExchangeRate = null)
{
    // إذا كان هناك سعر صرف يدوي، استخدمه
    if ($manualExchangeRate) {
        return round($amount / $manualExchangeRate, 2); // استخدام السعر اليدوي
    }

    // إذا لم يكن هناك سعر يدوي، استخدم سعر الصرف من الـ API
    $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/' . $fromCurrency);
    $data = $response->json();

    if ($response->ok() && isset($data['conversion_rates'][$toCurrency])) {
        $rate = $data['conversion_rates'][$toCurrency];
        return round($amount * $rate, 2); // التقريب إلى رقمين عشريين
    }

    throw new \Exception("Conversion rate not found for $fromCurrency to $toCurrency.");
}



// في الدالة الخاصة بالـ Transactions
public function update(Request $request, $currencyId)
{
    $currency = Currency::findOrFail($currencyId);

    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'currency' => 'required|string|max:255',
        'amount' => 'required|numeric',
    ]);

    $user = auth()->user();
    $userCurrency = $user->currency; // العملة الحالية للمستخدم

    $newAmount = $data['amount'];
    $oldAmount = $currency->amount;

    // تحويل المبلغ القديم من العملة الحالية للمستخدم إلى العملة الحالية
    $oldConvertedAmount = $this->convertCurrencyAmount($currency->currency, $userCurrency, $oldAmount);

    // تحويل المبلغ الجديد من العملة الجديدة إلى العملة الحالية للمستخدم
    $newConvertedAmount = $this->convertCurrencyAmount($data['currency'], $userCurrency, $newAmount);

    // الحصول على سعر التحويل القديم والجديد
    $oldRate = $this->getConversionRate($userCurrency, $currency->currency);
    $newRate = $this->getConversionRate($userCurrency, $data['currency']);

    // حساب الفرق بين الأسعار القديمة والجديدة
    $rateDifference = $newRate - $oldRate;

    // حساب الربح أو الخسارة بناءً على الفرق
    $percentageChange = ($rateDifference / $oldRate) * 100;

    // التحقق من الكاش وخصم/إضافة الفرق
    if ($newConvertedAmount > $oldConvertedAmount) {
        $difference = $newConvertedAmount - $oldConvertedAmount;
        if ($difference > $user->cash) {
            return back()->withErrors(['amount' => 'Insufficient cash for this update.']);
        }
        $user->cash -= $difference;
    } elseif ($newConvertedAmount < $oldConvertedAmount) {
        $difference = $oldConvertedAmount - $newConvertedAmount;
        $user->cash += $difference;
    }

    $user->save();

    // تسجيل العملية إذا كان هناك تغيير
    if ($newConvertedAmount != $oldConvertedAmount || $rateDifference != 0) {
        Transaction::create([
            'user_id' => $user->id,
            'currency_id' => $currency->id,
            'from_currency' => $userCurrency,
            'to_currency' => $data['currency'],
            'amount_from' => $oldAmount,
            'amount_to' => $newAmount,
            'conversion_rate' => $newRate,
            'transaction_date' => now(),
            'transaction_type' => $rateDifference > 0 ? 'purchase' : 'sale', // تحديد نوع المعاملة
            'profit_loss_percentage' => $percentageChange, // إضافة الربح أو الخسارة
        ]);
    }

    // تحديث بيانات العملة
    $currency->update($data);

    return redirect()->route('home.page')->with('success', 'Currency updated!');
}






    // حذف
    public function delete($currencyId)
    {
        $currency = Currency::findOrFail($currencyId);

        // إعادة المبلغ المحفوظ إلى الكاش
        $user = auth()->user();
        $user->cash += $currency->amount;
        $user->save();

        $currency->delete();

        return redirect()->route('home.page')->with('success', 'Currency deleted!');
    }
}