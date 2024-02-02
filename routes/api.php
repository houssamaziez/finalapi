<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatigoryController;
use App\Http\Controllers\TestController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Route::resource('catigory', CatigoryController::class);

Route::get('catigory',[CatigoryController::class, 'index']);
Route::post('catigory/createUser',[CatigoryController::class, 'createUser']);
Route::post('catigory/create',[CatigoryController::class, 'create']);
Route::put('catigory/edit/{id}',[CatigoryController::class, 'edit']);
Route::delete('catigory/delete/{id}',[CatigoryController::class, 'delete']);





// api auth
Route::post('users/createUser', [AuthController::class,'createUser']);
Route::post('users/loginUser', [AuthController::class,'loginUser']);
Route::get('users/userdata/{id}', [AuthController::class,'userdata']);
Route::post('mail', [TestController::class, 'index']);
Route::post('users/editUserPassword/{id}', [AuthController::class,'editUserPassword']);
