<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
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
Route::post('/signup', [AuthController::class, 'signup']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->post('/files', [FileController::class, 'store']);

Route::middleware('auth:api')->get('/files/all', [FileController::class, 'get']);

Route::middleware('auth:api')->delete('/files/{id}', [FileController::class, 'destroy']);

Route::middleware('auth:api')->delete('/files', [FileController::class, 'destroy_all']);

Route::middleware('auth:api')->post('/files/{id}', [FileController::class, 'update']);