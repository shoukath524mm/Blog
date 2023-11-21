<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BlogPostRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Models\Post;
use Validator;



class BlogPostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        if($posts) {
            return $this->sendResponse($posts, 'Posts Listed successfully.');
        } else {
            return $this->sendError('No Posts Found.');
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostRequest $request)
    {

        $validated = $request->validated();

        if (!$validated) {

            return $this->sendError('Validation Error.', $validator->errors(), 422);

        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
        ]);


        if($post) {
            return $this->sendResponse($post, 'Post Created successfully.');
        } else {
            return $this->sendError('Post Creation Failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->sendResponse($post, 'Post showed successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostUpdateRequest $request, Post $post)
    {

        $validated = $request->validated();

        if (!$validated) {
           return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $post->update($request->all());

        return $this->sendResponse($post, 'Post Updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {      
        $post->delete();

        return $this->sendResponse([], 'Post Deleted successfully.');


    }
}
