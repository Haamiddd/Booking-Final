<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;


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


Route::middleware('auth:sanctum')->group(function () {
    // Route to fetch all users
    Route::get('/admin/users', [AdminController::class, 'getAllUsers']);

    // Route to update a user's details
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser']);

    // Route to delete a user
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);
});


Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
