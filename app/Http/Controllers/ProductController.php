<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index',['products'=>Product::latest()->paginate(3)]);
    }

        public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        //validate data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1000000'
        ]);

        //upload image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('products'), $imageName);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $imageName;

        $product->save();

        return back()->withSuccess('Product created !!');
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        return view('products.edit',['product'=> $product]);
    }   

    public function update(Request $request, $id)
    {
        //validate data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1000000'
        ]);

        $product = Product::where('id', $id)->first();

        if (isset($request->image)) {
            //upload image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('products'), $imageName);
            $product->image = $imageName;
        }

        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();

        return back()->withSuccess('Product updated !!');
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        $product->delete();
        return back()->withSuccess('Product deleted !!');
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        return view('products.show',['product'=> $product]);
    }

    public function search(Request $request)
    {
        $search = $request->search ? $request->search :'';

        if($search)
        {
            $product = Product::where(function ($query) use ($search) {
                $query->where('name','like','%'. $search .'%')
                ->orWhere('description','like','%'. $search .'%');
            })
            ->paginate(3);
        }
        else
        {
            $product = Product::all();
        }

        return view('products.index',['product'=> $product]);
    }
}
