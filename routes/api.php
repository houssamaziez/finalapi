<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatigoryController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Route::resource('catigory', CatigoryController::class);
// Catigorys
Route::get('catigory',[CatigoryController::class, 'index']);
Route::post('catigory/create',[CatigoryController::class, 'create']);
Route::post('catigory/store',[CatigoryController::class, 'store']);
Route::put('catigory/edit/{id}',[CatigoryController::class, 'edit']);
Route::delete('catigory/delete/{id}',[CatigoryController::class, 'delete']);

// Posts
Route::get('post',[PostController::class,'index']);
Route::post('post/create/{id}',[PostController::class, 'create']);
Route::post('post/store',[PostController::class, 'store']);
Route::put('post/edit/{id}',[PostController::class, 'edit']);
Route::delete('post/delete/{id}',[PostController::class, 'delete']);
Route::get('post/data/{id}',[PostController::class, 'getpost']);





// api auth
Route::post('users/createUser', [AuthController::class,'createUser']);
Route::post('users/loginUser', [AuthController::class,'loginUser']);
Route::get('users/userdata/{id}', [AuthController::class,'userdata']);
Route::post('mail', [TestController::class, 'index']);
Route::post('users/editUserPassword', [AuthController::class,'editUserPassword']);
