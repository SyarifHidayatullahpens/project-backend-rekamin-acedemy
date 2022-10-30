<?php

namespace App\Http\Controllers;

use App\Models\{Post,Category,User};
use Illuminate\Http\Request;
use Storage;
use Auth;
use UploadedFile;

class PostController extends Controller
{
    
    public function index()
    {
        $posts = Post::latest()->get();
        $category = Category::select('id','name')->get();

        return response()->json([
            'posts'      => $posts,
            'category'   => $category,
            'success'   => true
        ],200);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|max:200|min:5|unique:posts,title',
            'content'       => 'required',
            'image'         => 'mimes:png,svg,jpg,jpeg|max:2048|nullable',
            'category_id'   => 'required',
            'user_id'       => 'required'
        ]);

        if($request->file('image')){
            $file = $request->file('image');
            $file_name = time() . str_replace(" ", "", substr($file->getClientOriginalName(), 0, 20));
            $file->storeAs('public/posts', $file_name);
            $data['image'] = $file_name;
        }

        $posts = Post::create($validated);

        if($posts){
            return response()->json([
                'data'      => $posts,
                'message'   => "Post berhasil ditambahkan",
                'success'   => true
            ],200);
        } else {
            return response()->json([
                'data'      => $posts,
                'message'   => "Post gagal ditambahkan",
                'success'   => false
            ],409);
        }
    }

   public function edit($id) 
   {
        $data       = Post::findOrFail($id);
        $category   = Category::select('id','name')->get();
        $user       = User::select('id','username')->whereNotIn('id',[1])->get(); 
        
        return response()->json([
            'success'       => true,
            'post'          => $data,
            'category'      => $category,
            'user'          => $user
        ],200);
   }

    public function show(Post $post)
    {

        return response()->json([
            'success'       => true,
            'post'          => $post,
        ],200);
    }


    public function update(Request $request, $id)
    {
        // dd($post);
        $request->validate([
            'title'         => 'required|min:5|max:200|unique:posts,title,'.$id,
            'content'       => 'required',
            'image'         => 'mimes:png,svg,jpg,jpeg|max:2048|nullable',
            'user_id'       => 'required',
            'category_id'   => 'required',
            'user_id'       =>  'required'
        ]);
        
        $validated = $request->all();

        $post = Post::find($id);
        $old_img = $post->image;

        if($request->image){
            $file = $request->file('image');
            $file_name = time() . str_replace("","",substr($file->getClientoriginalName(),0,20));
            $file->storeAs('public/posts',$file_name);
            if(Storage::exists($old_img)){   
                Storage::delete($old_img);
            }
            $validated['image'] = $file_name;
            $temp_img = $post->image;
        }

        $post->update([
            'title'         => $validated['title'],
            'content'       => $validated['content'],
            'image'         => $request->image ? $validated['image'] : $post->image ,
            'user_id'       => $request['user_id'],
            'category_id'   => $validated['category_id']
        ]);

        if($post){
            if($request->file('image')){
                Storage::delete('public/images/posts/'.$temp_img);
                $file->storeAs('public/images/posts/'.$file_name);
            }
            return response()->json([
                'data'      => $post,
                'message'   => "Post berhasil diperbaharui",
                'success'   => true
            ],200);
        } else {
            return response()->json([
                'data'      => $post,
                'message'   => "Post gagal diperbaharui",
                'success'   => false
            ],409);
        }
    }

    public function destroy(Post $post)
    {
        // $post = Post::findOrFail($id);
        
        if(Storage::exists($post->image)){
            Storage::delete($post->image);
        }
        
        $post->delete();
        if($post){    
            return response()->json([
                'message'   => "Post $post->title berhasil dihapus!",
                'success'   => true,
            ],200);
        } else {
            return response()->json([
                'message'   => 'Post gagal dihapus!',
                'success'   => false
            ],409);
        }
    }

    public function getCategories(Request $request) {
        $search = $request->search;

        if($search == ''){
            $category = Category::select('id','name')->latest()->get();
        }else {
            $category = Category::select('id','name')->where('name','like','%' .$search. '%')->latest()->get();
        }

        $response = array();
        foreach($category as $data) {
            $response[] = array(
                "id" => $data->id,
                "text" => $data->name
            );
        }
        return response()->json($response);
    }

    public function getUsers(Request $request) {
        $search = $request->search;

        if($search == ''){
            $user = User::select('id','username')->whereNotIn('id',[1])->latest()->get();
        }else {
            $user = User::select('id','username')->where('username','like','%' .$search. '%')->whereNotIn('id',[1])->latest()->get();
        }
        // dd($user);
        $response = array();
        foreach($user as $data) {
            $response[] = array(
                "id" => $data->id,
                "text" => $data->username
            );
        }
        return response()->json($response);
    }
}
