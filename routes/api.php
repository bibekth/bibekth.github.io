<?php

// declare(strict_types=1);

use App\Http\Controllers\API\ActivityController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\CustomerCreditController;
use App\Http\Controllers\API\DraftController;
use App\Http\Controllers\API\ManageShopController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductPriceController;
use App\Http\Controllers\API\UserController;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomainOrSubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware([
//     InitializeTenancyByDomainOrSubdomain::class,
//     PreventAccessFromCentralDomains::class,
// ])->group(function () {
    Route::get('/', function () {
        return  'hello tenant';
    });

    // Route::apiResource('users', UserController::class);

    Route::post('loginvendor', [UserController::class, 'loginVendor'])->name('login.vendor');
    Route::post('logincustomer', [UserController::class, 'loginCustomer'])->name('login.customer');
    Route::post('tryotp', [UserController::class, 'otpValidate'])->name('try.otp');
    Route::post('login', [UserController::class, 'login'])->name('api.login');
    Route::post('signup',[UserController::class,'signUp'])->name('api.signup');

    Route::group(['middleware' => 'token.api'], function () {
        Route::post('set-mpin', [UserController::class, 'setMpin'])->name('set.mpin');
        Route::post('set-password', [UserController::class, 'setPassword'])->name('set.password');
        Route::apiResource('customer', CustomerController::class);
        Route::apiResource('product', ProductController::class);
        Route::apiResource('productprice', ProductPriceController::class);
        Route::apiResource('shop', ManageShopController::class);
        Route::apiResource('draft', DraftController::class);
        Route::apiResource('customercredit', CustomerCreditController::class);
        Route::apiResource('payment', PaymentController::class);
        Route::apiResource('activity', ActivityController::class);

        Route::post('clear-draft', [DraftController::class,'clearDraft'])->name('draft.clear');
        Route::post('set-product-price', [ProductPriceController::class, 'setProductPrice'])->name('set.product.price');
    });
// });
