<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function categoryIndex()
    {

        $categories = ProductCategory::all();
        return view('admin.product.categoryIndex', compact('categories'));
    }

    public function categoryStore(Request $request)
    {


        $request->validate([
            'category_name' => 'required|max:255',

        ]);
        if ($request->category_name) {
            $category = new ProductCategory();
            $category->name = $request->category_name;
            $category->save();
            return redirect()->route('admin.categories')->with('success', 'Product Category Created Successfully');
        } else {
            return redirect()->route('admin.categories')->with('error', 'Product Category can not be created');
        }
    }

    public function productIndex()
    {
        $categories = ProductCategory::all();
        $products = Product::with('getCategory')->get();
        // dd($products);
        return view('admin.product.productIndex', compact('products', 'categories'));
    }


    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|max:255',
            'rate' => 'required|max:255',
            'status' => 'required|max:255'

        ]);
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->rate = $request->rate;
        $product->status = $request->status;
        $product->save();
        return redirect()->route('admin.products')->with('success', 'Product Created Successfully');
    }

    public function productUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|max:255',
            'rate' => 'required|max:255',
            'status' => 'required|max:255'

        ]);

        $product = Product::find($request->id);

        $product->name = $request['name'];

        $product->category_id = $request['category_id'];
        $product->rate = $request['rate'];
        $product->status = $request['status'];
        Product::where('id', $request->id)->update(array('name' =>  $product->name, 'category_id' =>   $product->category_id, 'rate' => $product->rate, 'status' => $product->status));
        return redirect()->route('admin.products')->with('success', "Product updated successfully.");
    }

    public function delete(Request $request)
    {
        Product::find($request->id)->delete();
        return redirect()->route('admin.products')->with('warning', "Product deleted successfully.");
    }
}
