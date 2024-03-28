<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function postsuser($user_id)
    {
        $posts = Post::where('user_id', $user_id)
                  ->orderBy('created_at', 'desc')
                  ->get();

        return  $posts;
    }

    public function getpost($id)
    {
        try {
            $post = Post::findOrFail($id);
            $postData = $post->attributesToArray();

            return response()->json([
                'status' => true,
                'post' => $post,
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

public function delete($post_id)
{
    $post = Post::where('id', $post_id)->first();
    $post->delete();
    $data = ['status' => 200,
        'message' => 'post is delete'];

    return response()->json($data, 200);
}

    public function create(Request $request, $iduser, $catigory_id)
    {
        $validator =
        Validator::make($request->all(), [
            'title' => 'required',
            'wilaya' => 'required',
            'price' => 'required',
            'details' => 'required',
            'details' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            $data = [
                'stutes' => 401,
                'message' => $validator->errors(),

            ];

            return response()->json($data);
        } else {
            $post = new Post;
            $post->title = $request->title;
            $post->wilaya = $request->wilaya;
            $post->price = $request->price;
            $post->user_id = $iduser;
            $post->catigory_id = $catigory_id;

            //  $post->likes=[2323];
            $post->details = $request->details;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                //   Image::make($image)->resize(300, 300)->save( public_path('/images/' . $filename ) );
                $request->image->move('images', $filename);
                $post->image = 'images/'.$filename;
                $post->save();
            }
            $post->save();
            $data = [
                'stutes' => 200,
                'post' => $post,
            ];

            return response()->json($data);
        }
    }

    public function updateLikes($postId, $userId)
    {
        // Retrieve the post by its ID
        $post = Post::find($postId);

        if (! $post) {
            // Handle the case when the post is not found
            return response()->json(['status' => 404, 'message' => 'Post not found'], 404);
        }

        // Decode the likes JSON string to an array
        $likes = json_decode($post->likes, true);

        if (! $likes) {
            $likes = [];
        }

        // Check if the user ID is already in the likes array
        $index = array_search($userId, $likes);

        if ($index === false) {
            // If not found, add the user ID to the likes array
            $likes[] = $userId;
            $post->likes = json_encode($likes);
            $post->save();

            return response()->json(['status' => 200, 'message' => 'User added to likes'], 200);
        } else {
            // If found, remove the user ID from the likes array
            array_splice($likes, $index, 1);
            $post->likes = json_encode($likes);
            $post->save();

            return response()->json(['status' => 200, 'message' => 'User removed from likes'], 200);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator =
            Validator::make($request->all(), [
                'title' => 'required',
                'details' => 'required',
            ]);
            if ($validator->fails()) {
                $data = [
                    'stutes' => 401,
                    'message' => $validator->errors(),

                ];

                return response()->json($data);
            } else {
                $post = Post::find($id);

                if (! $post) {
                    $data = [
                        'status' => 404,
                        'message' => 'Post not found',
                    ];

                    return response()->json($data);
                }

                $post->details = $request->details;
                $post->details = $request->title;
                $post->save();

                $data = [
                    'status' => 200,
                    'message' => 'Post title updated successfully',
                    'post' => $post,
                ];

                return response()->json($data);
            }
        } catch (\Throwable $th) {
            $data = [
                'status' => 401,
                'message' => 'Post not found',
            ];

            return response()->json($data);
        }
    }

     public function getallpostgatigory($id, $wilaya)
     {
         if ($wilaya == 'All') {
             $posts = Post::where('catigory_id', $id)->
                   orderBy('created_at', 'desc')
                 ->get();
         } else {
             $posts = Post::where('catigory_id', $id)->
                    where('wilaya', $wilaya)
                   ->orderBy('created_at', 'desc')
                 ->get();
         }

         return  $posts;
     }

        public function getpostgatigoryprofile($id, $wilaya, $idpost)
        {
            if ($wilaya == 'All') {
                $posts = Post::where('catigory_id', $id)->
                       where('id', '!=', $idpost)->
                        orderBy('created_at', 'desc')
                     ->get();
            } else {
                $posts = Post::where('catigory_id', $id)->
                          where('wilaya', $wilaya)->
                          where('id', '!=', $idpost)->
                          orderBy('created_at', 'desc')
                       ->get();
            }

            return  $posts;
        }

    public function search($query)
    {
        // Check if the query is "all"
        if ($query == 'all') {
            // Return all records
            $results = Post::all();
        } else {
            // Perform the search using your model
            $results = Post::where('title', 'LIKE', "%$query%")->get(); // Replace column_to_search with the actual column name you want to search
        }

        return $results;
    }
}
