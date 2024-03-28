<?php

namespace App\Http\Controllers;

use App\Models\Catigory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;

class CatigoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catigory = Catigory::all();
        $data = [
            'stetus' => 200,
            'Catigory' => $catigory,
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            } else {
                $catigory = new Catigory;
                $catigory->name = $request->name;

                //   add image
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $filename = time().'.'.$image->getClientOriginalExtension();
                    //   Image::make($image)->resize(300, 300)->save( public_path('/images/' . $filename ) );
                    $request->image->move('images', $filename);
                    $catigory->image = 'images/'.$filename;
                    $catigory->save();
                }
                $catigory->save();
                $data = [
                    'stetus' => 200,
                    'Catigory' => $catigory,
                ];

                return response()->json($data, 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

public function edit(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
    ]);

    if ($validator->fails()) {
        $data = ['status' => 422,
            'message' => $validator->messages(),
        ];

        return response()->json($data, 422);
    } else {
        $catigory = Catigory::find($id);
        $catigory->name = $request->name;
        $catigory->save();
        $data = ['status' => 200,
            'message' => 'data is updata'];

        return response()->json($data, 200);
    }
}

public function delete($id)
{
    $catigory = Catigory::find($id);
    $catigory->delete();
    $data = ['status' => 200,
        'message' => 'catigory is delete'];

    return response()->json($data, 200);
}

    public function search($query)
    {
        // Check if the query is "all"
        if ($query == 'all') {
            // Return all records
            $results = Catigory::all();
        } else {
            // Perform the search using your model
            $results = Catigory::where('name', 'LIKE', "%$query%")->get(); // Replace column_to_search with the actual column name you want to search
        }

        return $results;
    }

// public function createUser(Request $request)
// {
//     try {
//         //Validated
//         $validateUser = Validator::make($request->all(),
//         [
//             'name' => 'required',
//             'email' => 'required|email|unique:users,email',
//             'password' => 'required'
//         ]);

//         if($validateUser->fails()){
//             return response()->json([
//                 'status' => false,
//                 'message' => 'validation error',
//                 'errors' => $validateUser->errors()
//             ], 401);
//         }

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password)
//         ]);

//         return response()->json([
//             'status' => true,
//             'message' => 'User Created Successfully',
//             'token' => $user->createToken("API TOKEN")->plainTextToken
//         ], 200);

//     } catch (\Throwable $th) {
//         return response()->json([
//             'status' => false,
//             'message' => $th->getMessage()
//         ], 500);
//     }
// }
}
