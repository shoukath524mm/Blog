<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BlogPostRequest;
use App\Models\Post;
use Validator;



class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        if($posts) {
            $response = [
                'success' => true,
                'data'    => $posts,
                'message' => 'Posts Listed successfully',
                ];  
        } else {
            $response = [
                'success' => false,
                'data'    => [],
                'error' => 'No Posts Found',
                ]; 
        }

        return response()->json($response, 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'title' => 'required|string|max:250',
                'content' => 'required|string',
                'author' => 'required|string|max:250',
            ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['message'] = $validator->messages();
            return  response()->json($response, 422);
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
        ]);

        if($post) {
            $response = [
                'success' => true,
                'data'    => $post,
                'message' => 'Post Created successfully',
                ];  
        } else {
            $response = [
                'success' => false,
                'data'    => [],
                'error' => 'Post Creation Failed',
                ]; 
        }

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $response = [
            'success' => true,
            'data'    => $post,
            'message' => 'Post showed successfully',
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $validator = Validator::make($request->all(),[
                'title' => 'required|string|max:250',
                'content' => 'required|string',
                'author' => 'required|string|max:250',
            ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['message'] = $validator->messages();
            return  response()->json($response, 422);
        }

        $post->update($request->all());

        $response = [
            'success' => true,
            'data'    => $post,
            'error' => 'Post Updated successfully',
        ]; 

        return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {      
        $post->delete();

        $response = [
            'success' => true,
            'message' => 'Post Deleted successfully',
        ];  

        return response()->json($response, 200);

    }
}