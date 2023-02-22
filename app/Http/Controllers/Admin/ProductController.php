<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSizePrice;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use File;



class ProductController extends Controller
{
 
    public function index()
    {
        $userrole = auth()->user()->role;
        if($userrole == 'admin'){
            date_default_timezone_set('Asia/Manila');
            
            $products = Product::latest()->get();
            $categories = Category::latest()->get();
            $sizes = Size::latest()->get();

            return view('admin.products', compact('products', 'categories', 'sizes'));
        }
        return abort('403');
    }
   
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required'],
            'image' =>  ['required' , 'mimes:png,jpg,jpeg,svg,bmp,ico', 'max:2040'],
            'stock' => ['required','integer','min:1'],
            'unit_price' => ['required','integer','min:1'],
            'retailed_price'    => ['required','integer','min:1'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }
        $imgs = $request->file('image');
        $extension = $imgs->getClientOriginalExtension(); 
        $file_name_to_save = time()."_".".".$extension;
        $imgs->move('assets/img/products/', $file_name_to_save);

        $product = Product::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category'),
            'description' => $request->input('description'),
            'image' => $file_name_to_save,
            'stock' => $request->input('stock'),
            'unit_price' => $request->input('unit_price'),
            'retailed_price' => $request->input('retailed_price'),
        ]);


        return response()->json(['success' => 'Product Added Successfully.']);
    }

   
    public function edit(Product $product)
    {
        return response()->json([
            'result' =>   $product,
        ]);
    }

    public function updateproduct(Request $request, Product $product)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required'],
            'image' =>  ['mimes:png,jpg,jpeg,svg,bmp,ico', 'max:2040'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        if ($request->file('image')) {
            File::delete(public_path('assets/img/products/'.$product->image));
            $imgs = $request->file('image');
            $extension = $imgs->getClientOriginalExtension(); 
            $file_name_to_save = time()."_".".".$extension;
            $imgs->move('assets/img/products/', $file_name_to_save);

            $product->image = $file_name_to_save;
        }
       
        
        

        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->retailed_price = $request->retailed_price;
  
        $product->save();

        return response()->json(['success' => 'Product Updated Successfully.']);
    }
  
  
    public function destroy(Product $product)
    {
        File::delete(public_path('assets/img/products/'.$product->image));
        $product->delete();
        return response()->json(['success' =>  'Product Removed Successfully.']);
    }
}
