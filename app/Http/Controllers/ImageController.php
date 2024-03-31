<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Requset $requist)
    {
        //
    }

    public function createim(Request $request)
    {
        $imageList = [];

        if ($request->hasFile('images')) {
            for ($i = 0; $i < count($request->file('images')); $i++) {
                $filename = time().'.'.$request->file('images')[$i]->getClientOriginalExtension();
                $newName = uniqid('', true).$filename;
                $request->file('images')[$i]->move('imagess', $newName);
                $imageList[] = $newName;
            }
        }

        // Convert array to JSON string
        $imageListJson = json_encode($imageList);

        return $imageListJson;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    public function createmitiimage(Request $request, $iduser, $catigory_id)
    {
        $validator =
        Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            $data = [
                'stutes' => 401,
                'message' => $validator->errors(),

            ];

            return response()->json($data);
        } else {
            $fileimages = [];

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $filename = time().'.'.$image->getClientOriginalExtension();
                    //   Image::make($image)->resize(300, 300)->save( public_path('/images/' . $filename ) );
                    $request->image->move('images', $filename);
                    $post->image = 'images/'.$filename;
                    $post->save();
                    $fileimages[] = $post->image;
                }
            }

            return response()->json($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
