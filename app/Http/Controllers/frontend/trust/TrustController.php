<?php

namespace App\Http\Controllers\frontend\trust;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\frontend\trust\Trust;
use Illuminate\Support\Facades\Http;
use App\Models\frontend\category\Category;

class TrustController extends Controller
{
    public function index()
    {
        $transactions = Trust::all();
        return view('frontend.trust.trustIndex', compact('transactions'));
    }

    // عرض نموذج إضافة عنصر جديد
    public function create()
    {
        $categories = Category::where('user_id', auth()->user()->id)->get();

        // إرسال طلب إلى API للحصول على بيانات العملات
        $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/USD');
        $data = $response->json();
        $transactions = Trust::all();

        // استخراج العملات من البيانات
        $currencies = $data['conversion_rates'];
        return view('frontend.trust.trustCreate', compact('currencies','transactions'));
    }

    // تخزين عنصر جديد في قاعدة البيانات
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'buy_amount' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'author' => 'nullable|string',
        ]);
        $categories = Category::where('user_id', auth()->user()->id)->get();

        // إرسال طلب إلى API للحصول على بيانات العملات
        $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/USD');
        $data = $response->json();
        $transactions = Trust::all();

        // استخراج العملات من البيانات
        $currencies = $data['conversion_rates'];
        Trust::create($validated);

        return view('frontend.trust.trustCreate',compact('currencies','transactions'));
    }

    // عرض نموذج تعديل العنصر
    public function edit($id)
    {
        $trust = Trust::findOrFail($id);
        return view('frontend.trust.edit', compact('trust'));
    }

    // تحديث العنصر
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'buy_amount' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'author' => 'nullable|string',
        ]);

        $trust = Trust::findOrFail($id);
        $trust->update($validated);

        return redirect()->route('frontend.trust.trustIndex')->with('success', 'Trust updated successfully!');
    }

    // مسح العنصر
    public function destroy($id)
    {
        $trust = Trust::findOrFail($id);
        $trust->delete();

        return redirect()->route('frontend.trust.trustIndex')->with('success', 'Trust deleted successfully!');
    }
}
