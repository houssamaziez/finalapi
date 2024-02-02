<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\TestMail;

class TestController extends Controller
{
    public function index(Request $request)
    {


        $subject = 'Test Subject';
        $body = 'Test Message';

        Mail::to($request->mail)->send(new TestMail($subject, $request->id));
        $data = [
            "status"=>200,
            "message"=>"send email"
        ];
        return response()->json($data, 200);
    }

}
