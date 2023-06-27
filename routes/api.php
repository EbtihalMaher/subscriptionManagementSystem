<?php
use App\Http\Controllers\API\OnlinePaymentController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\ActivationCodeController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\PromoCodeController;
use App\Http\Controllers\API\SubscriptionController;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api_key'], function () {
    Route::get('/clients',  [ClientController::class, 'index']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    Route::post('/clients',  [ClientController::class, 'store']);

    Route::post('/online-payments', [OnlinePaymentController::class, 'store']);

    Route::get('/activation-codes/group/{groupId}', [ActivationCodeController::class, 'showGroupActivationCode']);
    Route::get('/activation-codes/group/{groupId}/{activationCodeId}', [ActivationCodeController::class, 'showActivationCode']);

    Route::get('/packages', [PackageController::class, 'index']);
    Route::get('/packages/{id}', [PackageController::class, 'show']);

    Route::get('/promo-codes/{name}', [PromoCodeController::class, 'show']);

    Route::post('/subscriptions/decrease-limit', [SubscriptionController::class, 'decreaseLimit']);

    Route::post('/clients/subscriptions', [SubscriptionController::class, 'store']);
    Route::get('/clients/{clientId}/profile/refresh', [ClientController::class, 'refreshProfile']);

});


