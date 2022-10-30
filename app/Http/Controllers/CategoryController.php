<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{

    public function index()
    {
        $data = Category::latest()->get();

        return response()->json([
            'success'   => true,
            'data'     => $data
        ]);
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'          => 'required|string|max:20|min:4|unique:categories,name,'
        ],
        [
            'name.required'       => 'Kategori harus diisi!',
            'name.min'            => 'Kategori minimal 4 karaktrer!',
            'name.max'            => 'Kategori maximal 20 karaktrer!',
            'name.unique'         => 'Kategori sudah ada!',
        ]);

        $category = Category::create([
            'name'      => $validateData['name'],
            'user_id'   => Auth::user()->id,
        ]);

        return response()->json([
            'success'       => true,
            'message'       => "$category->name berhasil ditambahkan",
        ],200);
    }


    public function show(Category $category)
    {
       $data = Post::find($category)->with('category','user');

        return response()->json([
            'data' => $data
        ]);
    }


    public function edit(category $category)
    {
        return response()->json($category);
    }


    public function update(Request $request, Category $category)
    {
        $validateData = $request->validate([
            'name'          => 'required|string|max:20|min:4|unique:categories,name,'.$category->id,
        ],
        [
            'name.required'       => 'Kategori harus diisi!',
            'name.min'            => 'Kategori minimal 4 karaktrer!',
            'name.max'            => 'Kategori maximal 20 karaktrer!',
            'name.unique'         => 'Kategori sudah ada!',
        ]);

        $category->update([
            'user_id'   => Auth::user()->id,
            'name'      => $validateData['name']
        ]);

        if($category) {
            return response()->json([
                'success'       => true,
                'message'       => "$category->name berhasil diupdate",
            ],200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => "$category->name gagal diupdate",
            ],409);
        }
    }


    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => "$category->name berhasil dihapus",
        ],200);
    }

    public function category($name) {
        $category = Category::where('name',$name)->first();
        dd($category);
        return response()->json([
            'success'   => true,
            'category'  => $category
        ],200);
    }
}
