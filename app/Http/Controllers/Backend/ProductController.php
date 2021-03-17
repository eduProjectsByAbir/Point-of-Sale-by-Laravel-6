<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Supplier;
use App\Model\Unit;
use App\Model\Category;
use Auth;

class ProductController extends Controller
{
     public function view()
    {
        $allData = Product::all();
        return view('backend.product.view-product', compact('allData'));
    }

    public function add()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
        $units = Unit::select('id', 'name')->get();
        return view('backend.product.add-product', compact('suppliers', 'categories', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = new Product();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('categories.view')->with('success', 'Category added successful!');
    }

    public function edit($id)
    {
        $editData = Category::find($id);
        return view('backend.category.edit-category', compact('editData'));
    }

    public function update($id, Request $request)
    {
        $data = Category::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('categories.view')->with('success', 'Category info updated!');
    }

    public function delete($id)
    {
        $data = Category::find($id);
        $data->delete();
        return redirect()->route('categories.view')->with('warning', 'Category Deleted!');
    }

}
