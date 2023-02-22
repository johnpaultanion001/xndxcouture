<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Carbon\Carbon;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userrole = auth()->user()->role;
        if($userrole == 'admin'){

            $products = Product::latest()->get();
            $products_today = Product::whereDay('created_at', '=', date('d'))->get();

            $customers = User::where('role', 'customer')->get();
            $customers_today = User::where('role', 'customer')->whereDay('created_at', '=', date('d'))->get();

            $orders = Order::latest()->get();
            $orders_today = Order::whereDay('created_at', '=', date('d'))->get();

            $sales = OrderProduct::where('isCheckout', '1')->where('status','APPROVED')->sum('amount');
            $sales_today = OrderProduct::where('isCheckout', '1')->where('status','APPROVED')->whereDay('created_at', '=', date('d'))->sum('amount');
        
        
        $data = OrderProduct::select(
            \DB::raw("SUM(amount) as amount"),
            \DB::raw("SUM(qty) as sold"),
            \DB::raw("product_id as product"))
            ->where('isCheckout', true)
            ->where('status', 'APPROVED')
            ->groupBy('product')
            ->orderBy('product', 'ASC')
            ->get();
        $result_sales = [];
        $result_sold = [];

        foreach($data as $row) {
            $product_name = Product::where('id', $row->product)->first();
            $result_sales['label'][] = $product_name->name;
            $result_sales['data'][] =  $row->amount;
        }

        foreach($data as $row) {
            $product_name = Product::where('id', $row->product)->first();
            $result_sold['label'][] = $product_name->name;
            $result_sold['data'][] =  $row->sold;
        }

        $sales_results = json_encode($result_sales);
        $sold_results = json_encode($result_sold);



            return view('admin.home', compact('products','products_today','customers','customers_today', 'orders','orders_today','sales','sales_today','sales_results','sold_results'));
        }
        return abort('403');
    }
}
