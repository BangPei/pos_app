<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $categories = Category::all();
        if ($request->ajax()) {
            return datatables()->of($categories)->make(true);
        }
        return view('master/category', ["title" => "Category", "menu" => "Master"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = $request->validate([
            'name' => 'required',
            'description' => '',
            'created_by_id' => '',
            'edit_by_id' => '',
        ]);
        $category['created_by_id'] = auth()->user()->id;
        $category['edit_by_id'] = auth()->user()->id;
        Category::Create($category);
        session()->flash('message', 'Berhasil menambahkan kategori ' . $category['name']);
        return Redirect::to('category');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category = $request->validate([
            'name' => 'required',
            'description' => '',
        ]);
        $category['id'] = $request->input('id');
        $category['edit_by_id'] = auth()->user()->id;
        Category::where('id', $category['id'])->update([
            'name' => $category['name'],
            'description' => $category['description'],
            'edit_by_id' => $category['edit_by_id'],
        ]);
        session()->flash('message', 'Berhasil merubah kategori ' . $category['name']);
        return Redirect::to('category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category['is_active'] = $category['is_active'] == 1 ? 0 : 1;
        Category::where('id', $category->id)->update([
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->is_active,
            'created_by_id' => $category->created_by_id,
            'edit_by_id' => auth()->user()->id,
        ]);
        return Redirect::to('category');
    }
}
