<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CommentController extends Controller
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
    public function create(Request $request, $iduser,$idpost)
    {
        try {
            $validator =
            Validator::make($request->all(), [
                'comment'=>"required",
             ]);
            if ($validator->fails()) {
    $data=[
    "stutes"=>401,
    "message"=> $validator->errors()

    ];
    return response()->json($data);

}else{
        $comments=new Comment;
$comments->comment= $request->comment;
$comments->user_id= $iduser;
$comments->post_id= $idpost;
$comments->save();
$data=[
    "stutes"=>200,
    "post"=> $comments
    ] ;
return response()->json($data);
    }

} catch (\Throwable $th) {
    $data=[
        "stutes"=>401,
        "message"=> "error"

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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
    public function getallofuser($postId)
    {
        $comments = Comment::where('post_id', $postId)->get();
        return  $comments;
    }
}
