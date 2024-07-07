<?php

// declare(strict_types=1);

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPriceController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomainOrSubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

// Route::middleware([
//     'web',
//     InitializeTenancyByDomainOrSubdomain::class,
//     PreventAccessFromCentralDomains::class,
// ])->group(function () {
    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'tenant'])->name('home');

    Route::get('/', function () {
        return redirect('/home');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('layouts.main');
        })->name('dashboard');
        Route::resource('vendors', VendorController::class);
        Route::resource('products', ProductController::class);
        Route::resource('variants', VariantController::class);
        Route::resource('productprices', ProductPriceController::class);

        Route::post('vendors/restore/{id}',[VendorController::class,'restore'])->name('vendors.restore');
        Route::post('products/restore/{id}',[ProductController::class,'restore'])->name('products.restore');
        Route::post('variants/restore/{id}',[VariantController::class,'restore'])->name('variants.restore');
    });
// });
