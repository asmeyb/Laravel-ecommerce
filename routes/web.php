<?php

use App\Livewire\Customer\Dashboard;
use App\Livewire\Customer\OrderDetails;
use App\Livewire\Orders;
use App\Livewire\ProductListing;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('products', ProductListing::class)->name('products.index');

// Protected Custom Routes
Route::middleware(['auth:customer'])
    ->group(function () {
        Route::get('/my-account', Dashboard::class)->name('customer.dashboard');
        Route::get('/my-account/orders', Orders::class)->name('customer.orders');
        Route::get('/my-account/orders/{id}', OrderDetails::class)->name('customer.orders.show');
        Route::get('/my-account/profile', Orders::class)->name('customer.profile');
        Route::get('/my-account/profile', Orders::class)->name('customer.profile');
        
        Route::post('/logout', function () {
            auth('customer')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect('/');
        })->name('logout');
});
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
