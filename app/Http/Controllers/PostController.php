<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

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
