<?php
use App\Http\Controllers\API\OnlinePaymentController;
use App\Http\Controllers\API\ClientController;

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

Route::post('/clients', 'App\Http\Controllers\API\ClientController@store');

// Route::post('/clients/subscriptions', 'App\Http\Controllers\API\SubscriptionController@store');
Route::post('/online-payments', [OnlinePaymentController::class, 'store']);

