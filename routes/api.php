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
Route::post('post/likse/{postId}/{userId}', [PostController::class, 'updateLikes']);
Route::post('post/islikse/{postId}/{userId}', [PostController::class, 'isUserLikedPost']);
Route::delete('post/delete/{id}', [PostController::class, 'delete']);
Route::get('post/data/{id}', [PostController::class, 'getpost']);
Route::get('post/catigory/idcatigory={id}/{wilaya}', [PostController::class, 'getallpostgatigory']);
Route::get('post/catigory/idcatigory={id}/{wilaya}/postid={idpost}', [PostController::class, 'getpostgatigoryprofile']);
Route::get('post/postsuser/{user_id}', [PostController::class, 'postsuser']);
Route::get('post/search/keyword={query}', [PostController::class, 'search']);
Route::post('post/imageUpload', [PostController::class, 'creates']);
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

Route::post('/notification', function (Request $requist) {
    $SERVER_API_KEY = 'AAAAxcRob6s:APA91bFo2PVSl89sOz4jPEtm84Nc5T3hq4BmMoeUOX44HdVjPyPmeHsX-0PGUyfIsQPY88HQ_WOJfWUU_lJXUJ9S4zTtxu_JUqBnEw7xOv5cyUC2sBkFWWS2aJJUcwDC8v_QV-cRpSmB';

    $token_1 = 'dWyWVtN0Rf6GAMmbXqy9k8:APA91bFz00O_wiQkcXVs092wT4K6uQSxScYVIgiF9fH7Ws6cy-i6OGAKJ2hcSLziachIob_TGGqknY95DaLzvxLogXvpcXluUkJaPMXKFsH8rIF2DI3UIBpvKVTiW5du5ESyZE7qX3u7';

    $data = [

        'registration_ids' => [
            $token_1,
        ],

        'notification' => [

            'title' => $requist->title,

            'body' => $requist->description,

            'sound' => 'default', // required for sound on ios

        ],

    ];

    $dataString = json_encode($data);

    $headers = [

        'Authorization: key='.$SERVER_API_KEY,

        'Content-Type: application/json',

    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);

    dd($response);
});
