<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\LenderController;
use App\Http\Middleware\EnsureUserIsBorrower;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});


Route::middleware(['auth',EnsureUserIsBorrower::class])->group(function () {
    Route::view('dashboard', 'dashboard')
    ->name('dashboard');
    Route::prefix('borrower')->group(function(){
        Route::get('/create', [BorrowerController::class, 'create'])->name('borrower.create');
        Route::get('/list', [BorrowerController::class, 'index'])->name('borrower.list');
        Route::get('/show/{loan}', [BorrowerController::class, 'show'])->name('borrower.show');
        Route::post('/store', [BorrowerController::class, 'store'])->name('borrower.store');
        Route::get('/verification/{id}', [BorrowerController::class, 'verify'])->name('borrower.verification');
        Route::post('/verification', [BorrowerController::class, 'submitVerification'])->name('borrower.verification.submit');
        Route::get('/repayment', [BorrowerController::class, 'index'])->name('borrower.repayment');
    });
    Route::prefix('lender')->group(function(){
        Route::get('/create/{id}', [LenderController::class, 'create'])->name('lender.create');
        Route::post('/store', [LenderController::class, 'store'])->name('lender.store');
    });
    Route::patch('/offers/{offer}/approve', [BorrowerController::class, 'update'])
        ->name('offers.approve');
});
require __DIR__.'/auth.php';
