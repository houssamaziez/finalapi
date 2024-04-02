<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotiController extends Controller
{
    public function push(Request $request, $postId, $idusersend)
    {
        $validator =
            Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
            ]);
        if ($validator->fails()) {
            $data = [
                'stutes' => 401,
                'message' => $validator->errors(),

            ];

            return response()->json($data);
        } else {
            $user = User::find($postId);
            $usersendrequest = User::find($idusersend);
            $SERVER_API_KEY = 'AAAAxcRob6s:APA91bFo2PVSl89sOz4jPEtm84Nc5T3hq4BmMoeUOX44HdVjPyPmeHsX-0PGUyfIsQPY88HQ_WOJfWUU_lJXUJ9S4zTtxu_JUqBnEw7xOv5cyUC2sBkFWWS2aJJUcwDC8v_QV-cRpSmB';

            $token_1 = $user->tokennotification;

            $data = [

                'registration_ids' => [
                    $token_1,
                ],

                'notification' => [

                    'title' => $request->title,

                    'body' => $usersendrequest->name.' '.$request->description,

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
        }
    }
}
