<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class TestController extends Controller
{
    public function index(Request $request)
    {
        // التحقق مما إذا كان البريد الإلكتروني موجود في قاعدة البيانات
        $existingEmail = User::where('email', $request->mail)->first();

        if (! $existingEmail) {
            // إذا كان البريد الإلكتروني غير موجود، يمكنك إرجاع رسالة خطأ أو اتخاذ إجراء آخر
            $data = [
                'status' => false,
                'message' => 'Email not found in the database',
            ];

            return response()->json($data, 400);
        } else {
            $subject = 'Test Subject';
            $body = 'Test Message';

            Mail::to($request->mail)->send(new TestMail($subject, $request->id));
            $data = [
                'status' => true,
                'message' => 'send email',
            ];

            return response()->json($data, 200);
        }
    }
}
