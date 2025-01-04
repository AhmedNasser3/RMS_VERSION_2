<?php

namespace App\Http\Controllers\frontend\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function edit($id)
    {
        // جلب بيانات المستخدم
        $user = User::findOrFail($id);

        // إرسال طلب إلى API للحصول على بيانات العملات
        $response = Http::get('https://v6.exchangerate-api.com/v6/be85c7dbedd0e0efc6e79af7/latest/USD'); // استبدل YOUR_API_KEY بمفتاح API الخاص بك
        $data = $response->json();

        // استخراج العملات من البيانات
        $currencies = $data['conversion_rates'];

        // تمرير البيانات إلى الـ view
        return view('frontend.cash.index', compact('user','currencies'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cash' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('home.page', $user->id)->with('success', 'User updated successfully.');
    }
}