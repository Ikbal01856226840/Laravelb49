<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Product;
use App\Category;

class ProductController extends Controller
{
    public function productList(){
        $title = 'Product List';

        $user_id = auth()->user()->id;

        $products = Product::where('products.user_id', '=', $user_id)
                    ->leftJoin('category', 'category.id', '=', 'products.category_id')
                    ->select('products.id', 'products.name', 'products.description', 'products.category_id', 'products.price', 'products.status', 'products.user_id', 'category.name AS category_name')
                    ->get();

        return view('products', ['products'=>$products, 'title'=>$title]);
    }

    public function createProduct(){
        $title = 'Create Product';

        $user_id = auth()->user()->id;

        $categories = Category::where('user_id', '=', $user_id)->get();

        return view('create_product', ['categories' => $categories, 'title'=>$title]);
    }

    public function saveProduct(Request $request){
        $product = new Product();

        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->user_id = auth()->user()->id;
        $product->save();

        Session::put('success_message', 'Successfully Saved!');

        return redirect()->back();
    }

    public function editProduct($id){
        $title = 'Edit Product';

        $user_id = auth()->user()->id;

        $product = Product::find($id);
        $categories = Category::where('user_id', '=', $user_id)->get();

        return view('edit_product', ['product' => $product, 'categories' => $categories, 'title'=>$title]);
    }

    public function updateProduct(Request $request, $id){
        $regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";

        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => array('required','regex:'.$regex),
            'status' => 'required',
        ]);

        $product = Product::find($id);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->save();

        Session::put('success_message', 'Successfully Updated!');

        return redirect()->back();
    }
}
