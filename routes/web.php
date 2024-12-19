<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\frontend\home\HomeController;
use App\Http\Controllers\frontend\category\CategoryController;
use App\Http\Controllers\frontend\currency\CurrencyController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// ============================== Category Controller ==============================
Route::controller(CategoryController::class)->prefix('category')->group(function(){
    Route::get('/create','create')->name('category.create');
    Route::post('/store','store')->name('category.store');
    Route::get('/{categoryId}/edit', 'edit')->name('category.edit');
    Route::post('/{categoryId}/update', 'update')->name('category.update');
    Route::get('/{categoryId}/delete', 'delete')->name('category.delete');
});
// ============================== Currency Controller ==============================
Route::controller(CurrencyController::class)->prefix('currency')->group(function(){
    Route::get('/create', 'create')->name('currency.create');
    Route::post('/store', 'store')->name('currency.store');
    Route::get('/{currencyId}/edit', 'edit')->name('currency.edit');
    Route::post('/{currencyId}/update', 'update')->name('currency.update');
    Route::get('/{currencyId}/delete', 'delete')->name('currency.delete');
});



Route::get('/', [HomeController::class, 'index'])->name('home.page');
require __DIR__.'/auth.php';