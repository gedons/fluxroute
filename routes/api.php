<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //routes
    Route::resource('/shipment', \App\Http\Controllers\PackageController::class);
    Route::resource('/driver', \App\Http\Controllers\DriverController::class);
    Route::resource('/alluser', \App\Http\Controllers\UserController::class);
    Route::resource('/adminpackage', \App\Http\Controllers\AdminPackageController::class);
    Route::put('/adminpackage/{product}/update-status', [App\Http\Controllers\AdminPackageController::class, 'updateDeliveryStatus']);    
    
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/CreateAccount', [AuthController::class, 'CreateAccount']);
