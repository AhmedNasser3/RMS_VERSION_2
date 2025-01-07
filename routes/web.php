<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\frontend\debt\DebtController;
use App\Http\Controllers\frontend\home\HomeController;
use App\Http\Controllers\frontend\user\UserController;
use App\Http\Controllers\frontend\trust\TrustController;
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
// ============================== User Controller ==============================
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
// ============================== Debt Controller ==============================
Route::controller(DebtController::class)->prefix('debt')->group(function () {
    // External Debt Routes
    Route::get('external', 'ExternalDebt')->name('external.debt'); // عرض الديون الخارجية
    Route::get('external/create', 'ExternalCreate')->name('external.debt.create'); // صفحة إنشاء الديون الخارجية
    Route::post('external/store', 'ExternalStore')->name('external.debt.store'); // حفظ الديون الخارجية
    Route::get('external/{id}/edit', 'ExternalEdit')->name('external.debt.edit'); // صفحة تعديل الديون الخارجية
    Route::put('external/{id}/update', 'ExternalUpdate')->name('external.debt.update'); // تحديث الديون الخارجية
    Route::delete('external/{id}/delete', 'ExternalDelete')->name('external.debt.delete'); // حذف الديون الخارجية
    // Internal Debt Routes
    Route::get('internal', 'InternalDebt')->name('internal.debt'); // عرض الديون الداخلية
    Route::get('internal/create', 'InternalCreate')->name('internal.debt.create'); // صفحة إنشاء الديون الداخلية
    Route::post('internal/store', 'InternalStore')->name('internal.debt.store'); // حفظ الديون الداخلية
    Route::get('internal/{id}/edit', 'InternalEdit')->name('internal.debt.edit'); // صفحة تعديل الديون الداخلية
    Route::put('internal/{id}/update', 'InternalUpdate')->name('internal.debt.update'); // تحديث الديون الداخلية
    Route::delete('internal/{id}/delete', 'InternalDelete')->name('internal.debt.delete'); // حذف الديون الداخلية
});
Route::controller(TrustController::class)->prefix('trusts')->group(function () {
    Route::get('/show', 'index')->name('trusts.index');
    Route::get('/create',  'create')->name('trusts.create');
    Route::post('/store',  'store')->name('trusts.store');
});
Route::resource('coins', CoinController::class);

Route::get('/', [HomeController::class, 'index'])->name('home.page');
require __DIR__.'/auth.php';