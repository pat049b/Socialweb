<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Session;
use App\Post;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->email!="admin@admin.com")
        {
            return redirect()->route('dashboard');
        }
        else {
            $categories = Category::all();
            return view('categories.index')->withCategories($categories);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|max:255'
        ));
        $category = new Category;
        $category ->name =$request->name;
        $category->save();
        Session::flash('success', 'New Category has been created');

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showAllPosts($category_id)
    {
        $category=Category::where('id', $category_id)->first();
        $posts= Post::where('category_id', $category->id)->get();
        $categories=Category::all();
        return view('categories.category', ['posts' =>$posts, 'category'=>$category, 'categories'=>$categories]);

    }
    public function getDeleteCategory($category_id)
    {
        $category= Category::where('id', $category_id)->first();

        if(Auth::user()->email != "admin@admin.com"){
            return redirect()->back();
        }
        $category->delete();
        $posts= Post::where('category_id', $category_id)->delete();
        return redirect()->route('categories.index')->with(['message'=>'Successfully deleted category.']);
    }
}
