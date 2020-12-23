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
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->get('/hello', function (Request $request) {
//     return response()->json([
//         'message' => 'Hello!'
//     ]);
// });

Route::middleware('guest')->group(function() {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
  Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
  Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware(['auth:sanctum', 'signed'])->get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');