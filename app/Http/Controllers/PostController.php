<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PostController extends Controller
{
    public function postsuser($user_id)
    {
        $posts = Post::where('user_id', $user_id)->get();
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
}    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $validator =
        Validator::make($request->all(), [
            'title'=>"required",
            'details'=>"required",
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
$data=[
"stutes"=>401,
"message"=> $validator->errors()

]   ;


return response()->json($data);
}else{

         $post= new Post;
         $post->title=  $request->title;
         $post->user_id= $id;

        //  $post->likes=[2323];
         $post->details=   $request->details;
         if($request->hasFile('image')){
            $image= $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
          //   Image::make($image)->resize(300, 300)->save( public_path('/images/' . $filename ) );
  $request->image->move('images', $filename);
            $post->image="images/".'catigory'. $filename;
            $post->save();
          };
         $post->save();
         $data=[
            "stutes"=>200,
            "post"=> $post
            ] ;
return response()->json($data);

}

    }


    function updateLikes($postId, $userId) {

           // Retrieve the post by its ID
    $post = Post::find($postId);

    if (!$post) {
        // Handle the case when the post is not found
        return response()->json(['status' => 404, 'message' => 'Post not found'], 404);
    }

    // Decode the likes JSON string to an array
    $likes = json_decode($post->likes, true);

    if (!$likes) {
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
                'title'=>"required",
                'details'=>"required",
            ]);
            if ($validator->fails()) {
    $data=[
    "stutes"=>401,
    "message"=> $validator->errors()

    ]   ;


    return response()->json($data);
    }else{
        $post = Post::find($id);

        if (!$post) {
            $data = [
                "status" => 404,
                "message" => "Post not found",
            ];

            return response()->json($data);
        }

        $post->details = $request->details;
        $post->details = $request->title;
        $post->save();

        $data = [
            "status" => 200,
            "message" => "Post title updated successfully",
            "post" => $post,
        ];

        return response()->json($data);
    }



                } catch (\Throwable $th) {
                    $data = [
                        "status" => 401,
                        "message" => "Post not found",
                    ];

                    return response()->json($data);        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

}
