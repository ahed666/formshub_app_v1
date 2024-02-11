<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v01\DeviceApiController;
use App\Http\Controllers\api\v01\DeviceCodeApiController;

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

Route::post('/v01/device-code', [DeviceCodeApiController::class, 'store']);

Route::post('/v01/device', [DeviceApiController::class, 'store']);
Route::get('/v01/device/logout/{deviceId}', [DeviceApiController::class, 'destroy']);

Route::middleware('auth:sanctum')->group( function(){
    Route::get('/v01/authentication', function () {
        return response([], 204);
    });
});

// Route::middleware('auth:sanctum')->get('/user', function (Rquest $request) {
//     return $request->user();
// });
