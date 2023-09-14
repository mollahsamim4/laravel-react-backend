<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {



        $posts = PostResource::collection(Post::with(['user', 'categories'])->get());
        return $posts;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');

        try {

            $post = Post::create([
                'title' => $input['title'],
                'body' => $input['body'],
                'user_id' => Auth::user()->id
            ]);
            $post->categories()->attach($input['category']);



            return response()->json([
                'post' => $post,
                'message' => 'Post created successfully...',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->except('_token');
        $posts = Post::find($id)->update($input);
        if ($posts) {
            $post = Post::find($id);
            $post->categories()->sync($input['category']);
        }


        return $posts;
        try {
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, $category)
    {


        $post = Post::find($id);

        if ($post) {
            $post->delete();
            $post->categories()->detach([6]);
        }
        return response()->json([
            'message' => 'Delete success'
        ]);
        try {
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPostsByCustomNumber($number, $lastId)
    {
        $posts = PostResource::collection(Post::where('id', '>', $lastId)->limit($number)->get());
        return $posts;
    }

    public function test()
    {
        $posts = PostResource::collection(Post::with(['user', 'categories'])->get());
        return $posts;
    }
}
