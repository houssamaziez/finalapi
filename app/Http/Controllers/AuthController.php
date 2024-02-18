<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function userdata($id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Get all attributes of the user
            $userData = $user->attributesToArray();

            return response()->json([
                'status' => true,
                'message' => 'User create In Successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'user' => $user,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case when the user is not found
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'role' => 'required',
                    'wilaya' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'wilaya' => $request->wilaya,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User create   Successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            if (! Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User create   Successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function editUserPassword(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'password' => 'required', 'email' => 'required',  ]);
        if ($validateUser->fails()) {
            $data = ['status' => false,
                'message' => $validateUser->messages(),
            ];

            return response()->json($data, 422);
        } else {
            // $user= User::find($id);
            $user = User::where('email', $request->email)->first();

            $user->password = Hash::make($request->password);
            $user->save();
            $data = ['status' => true,
                'message' => 'password user is updata'];

            return response()->json($data, 200);
        }
    }
}
