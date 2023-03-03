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
        if($userrole != 'customer'){
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
            'size' => ['required'],

            'image1' =>  ['required' , 'mimes:png,jpg,jpeg,svg,bmp,ico'],
            'image2' =>  ['required', 'mimes:png,jpg,jpeg,svg,bmp,ico'],
            'image3' =>  ['required', 'mimes:png,jpg,jpeg,svg,bmp,ico'],
            'image4' =>  ['required', 'mimes:png,jpg,jpeg,svg,bmp,ico'],
            'image5' =>  ['required', 'mimes:png,jpg,jpeg,svg,bmp,ico'],

            'stock' => ['required','integer','min:1'],
            'unit_price' => ['required','integer','min:1'],
            'retailed_price'    => ['required','integer','min:1'],
            'discount'    => ['required','integer','min:0'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        $imgs1 = $request->file('image1');
        $extension1 = $imgs1->getClientOriginalExtension(); 
        $file_name_to_save1 = time()."_1".".".$extension1;
        $imgs1->move('assets/img/products/', $file_name_to_save1);

        $imgs2 = $request->file('image2');
        $extension2 = $imgs2->getClientOriginalExtension(); 
        $file_name_to_save2 = time()."_2".".".$extension2;
        $imgs2->move('assets/img/products/', $file_name_to_save2);

        $imgs3 = $request->file('image3');
        $extension3 = $imgs3->getClientOriginalExtension(); 
        $file_name_to_save3 = time()."_3".".".$extension3;
        $imgs3->move('assets/img/products/', $file_name_to_save3);

        $imgs4 = $request->file('image4');
        $extension4 = $imgs4->getClientOriginalExtension(); 
        $file_name_to_save4 = time()."_4".".".$extension4;
        $imgs4->move('assets/img/products/', $file_name_to_save4);

        $imgs5 = $request->file('image5');
        $extension5 = $imgs5->getClientOriginalExtension(); 
        $file_name_to_save5 = time()."_5".".".$extension5;
        $imgs5->move('assets/img/products/', $file_name_to_save5);


        $product = Product::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category'),
            'size_id' => $request->input('size'),
            'description' => $request->input('description'),
            
            'image1' => $file_name_to_save1,
            'image2' => $file_name_to_save2,
            'image3' => $file_name_to_save3,
            'image4' => $file_name_to_save4,
            'image5' => $file_name_to_save5,


            'stock' => $request->input('stock'),
            'unit_price' => $request->input('unit_price'),
            'retailed_price' => $request->input('retailed_price'),
            'discount' => $request->input('discount'),
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
            'size' => ['required'],

            'image1' =>  ['mimes:png,jpg,jpeg,svg,bmp,ico'],
            'image2' =>  ['mimes:png,jpg,jpeg,svg,bmp,ico'],
            'image3' =>  ['mimes:png,jpg,jpeg,svg,bmp,ico'],
            'image4' =>  ['mimes:png,jpg,jpeg,svg,bmp,ico'],
            'image5' =>  ['mimes:png,jpg,jpeg,svg,bmp,ico'],

            'stock' => ['required','integer','min:1'],
            'unit_price' => ['required','integer','min:1'],
            'retailed_price'    => ['required','integer','min:1'],
            'discount'    => ['required','integer','min:0'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }
       
        if ($request->file('image1')) {
            File::delete(public_path('assets/img/products/'.$product->image1));
            $imgs1 = $request->file('image1');
            $extension1 = $imgs1->getClientOriginalExtension(); 
            $file_name_to_save1 = time()."_1".".".$extension1;
            $imgs1->move('assets/img/products/', $file_name_to_save1);

            $product->image1 = $file_name_to_save1;
        }

        if ($request->file('image2')) {
            File::delete(public_path('assets/img/products/'.$product->image2));
            $imgs2 = $request->file('image2');
            $extension2 = $imgs2->getClientOriginalExtension(); 
            $file_name_to_save2 = time()."_2".".".$extension2;
            $imgs2->move('assets/img/products/', $file_name_to_save2);

            $product->image2 = $file_name_to_save2;
        }

        if ($request->file('image3')) {
            File::delete(public_path('assets/img/products/'.$product->image3));
            $imgs3 = $request->file('image3');
            $extension3 = $imgs3->getClientOriginalExtension(); 
            $file_name_to_save3 = time()."_3".".".$extension3;
            $imgs3->move('assets/img/products/', $file_name_to_save3);

            $product->image3 = $file_name_to_save3;
        }

        if ($request->file('image4')) {
            File::delete(public_path('assets/img/products/'.$product->image4));
            $imgs4 = $request->file('image4');
            $extension4 = $imgs4->getClientOriginalExtension(); 
            $file_name_to_save4 = time()."_4".".".$extension4;
            $imgs4->move('assets/img/products/', $file_name_to_save4);

            $product->image4 = $file_name_to_save4;
        }

        if ($request->file('image5')) {
            File::delete(public_path('assets/img/products/'.$product->image5));
            $imgs5 = $request->file('image5');
            $extension5 = $imgs5->getClientOriginalExtension(); 
            $file_name_to_save5 = time()."_5".".".$extension5;
            $imgs5->move('assets/img/products/', $file_name_to_save5);

            $product->image5 = $file_name_to_save5;
        }
        
        

        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->size_id = $request->size;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->retailed_price = $request->retailed_price;
        $product->discount = $request->discount;
  
        $product->save();

        return response()->json(['success' => 'Product Updated Successfully.']);
    }
  
  
    public function destroy(Product $product)
    {
        File::delete(public_path('assets/img/products/'.$product->image1));
        File::delete(public_path('assets/img/products/'.$product->image2));
        File::delete(public_path('assets/img/products/'.$product->image3));
        File::delete(public_path('assets/img/products/'.$product->image4));
        File::delete(public_path('assets/img/products/'.$product->image5));
        $product->delete();
        return response()->json(['success' =>  'Product Removed Successfully.']);
    }
}
