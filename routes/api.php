<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatigoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('catigory', CatigoryController::class);
// Catigorys
Route::get('catigory', [CatigoryController::class, 'index']);
// Route::post('catigory/create',[CatigoryController::class, 'create']);
Route::post('catigory/store', [CatigoryController::class, 'store']);
Route::put('catigory/edit/{id}', [CatigoryController::class, 'edit']);
Route::delete('catigory/delete/{id}', [CatigoryController::class, 'delete']);
Route::get('catigory/search/keyword={query}', [CatigoryController::class, 'search']);
// Posts
Route::get('post', [PostController::class, 'index']);
Route::post('post/create/id_user={iduser}/id_catigory={catigory_id}', [PostController::class, 'create']);
Route::post('post/store', [PostController::class, 'store']);
Route::put('post/update/{id}', [PostController::class, 'update']);
Route::put('post/likse/{postId}/{userId}', [PostController::class, 'updateLikes']);
Route::delete('post/delete/{id}', [PostController::class, 'delete']);
Route::get('post/data/{id}', [PostController::class, 'getpost']);
Route::get('post/catigory/idcatigory={id}/{wilaya}', [PostController::class, 'getallpostgatigory']);
Route::get('post/postsuser/{user_id}', [PostController::class, 'postsuser']);

// commnet
Route::get('commnet', [CommentController::class, 'index']);
Route::post('commnet/{iduser}/{idpost}', [CommentController::class, 'create']);
Route::put('commnet/edit/{id}', [CommentController::class, 'edit']);
Route::delete('commnet/delete/{id}', [CommentController::class, 'delete']);
Route::get('post/commnet/{postId}', [CommentController::class, 'getall']);

// api auth
Route::post('users/createUser', [AuthController::class, 'createUser']);
Route::post('users/loginUser', [AuthController::class, 'loginUser']);
Route::get('users/userdata/{id}', [AuthController::class, 'userdata']);
Route::post('mail', [TestController::class, 'index']);
Route::post('users/editUserPassword', [AuthController::class, 'editUserPassword']);
