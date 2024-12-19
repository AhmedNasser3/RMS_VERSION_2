<?php

namespace App\Http\Controllers\frontend\currency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\frontend\category\Category;
use App\Models\frontend\currency\Currency;

class CurrencyController extends Controller
{
    public function create() {
        $categories = Category::where('user_id', auth()->user()->id)->get();
        return view('frontend.currency.create', compact('categories'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        $data['user_id'] = auth()->user()->id;
        Currency::create($data);

        return redirect()->route('home.page')->with('success', 'Currency created!');
    }

    public function edit($currencyId) {
        $currency = Currency::findOrFail($currencyId);
        $categories = Category::where('user_id', auth()->user()->id)->get();
        return view('frontend.currency.edit', compact('currency', 'categories'));
    }

    public function update(Request $request, $currencyId) {
        $currency = Currency::findOrFail($currencyId);

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        $data['user_id'] = auth()->user()->id;
        $currency->update($data);

        return redirect()->route('home.page')->with('success', 'Currency updated!');
    }

    public function delete($currencyId) {
        Currency::findOrFail($currencyId)->delete();
        return redirect()->route('home.page')->with('success', 'Currency deleted!');
    }
}