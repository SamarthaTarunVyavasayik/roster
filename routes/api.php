<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


/**
 * Self details
 * @authenticated
 *
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

