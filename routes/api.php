<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;

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

Route::post('/user/create', [\App\Http\Controllers\UserController::class, 'registration']);
Route::get('/user/auth/email/{user:email}/password/{passwordKey?}', [\App\Http\Controllers\UserController::class, 'auth']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user/logout/{userId}', [\App\Http\Controllers\UserController::class, 'logout']);
});
