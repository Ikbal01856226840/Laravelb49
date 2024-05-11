<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Category;

class CategoryController extends Controller
{
    public function categoryList(){
        $title = 'Category List';

        $user_id = auth()->user()->id;

        $categories = Category::where('user_id', '=', $user_id)->get();

        return view('categories', ['categories'=>$categories, 'title'=>$title]);
    }

    public function createCategory(){
        $title = 'Create Category';

        return view('create_category', ['title'=>$title]);
    }

    public function saveCategory(Request $request){

        $category = new Category();

        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->user_id = auth()->user()->id;
        $category->save();

        Session::put('success_message', 'Successfully Saved!');

        return redirect()->back();

    }

    public function editCategory($id){
        $title = 'Edit Category';

        $category_info = Category::find($id);

        return view('edit_category', ['category_info'=>$category_info, 'title'=>$title]);

    }

    public function updateCategory(Request $request, $id){
        $category = Category::find($id);
        
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();

        Session::put('success_message', 'Successfully Updated!');

        return redirect()->back();
    }
}
