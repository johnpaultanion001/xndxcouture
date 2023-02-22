<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

class CustomerListController extends Controller
{
    public function index()
    {
        $userrole = auth()->user()->role;
        if($userrole == 'admin'){
            $customers = User::where('role', 'customer')->latest()->get();
            return view('admin.customerlist', compact('customers'));
        }
        return abort('403');
    }
    

    public function edit(User $user)
    {
        if (request()->ajax()) {
            return response()->json(['result' => $user]);
        }
    }

    public function update(Request $request, User $user)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required'],
            'contact_number' => ['required', 'string', 'min:8','max:11'],
            
        ]);
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        User::find($user->id)->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'contact_number' => $request->input('contact_number'),
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    
      
    }

    public function defaultPassowrd(User $user)
    {
        User::find($user->id)->update([
            'password' => '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896' , //password,
        ]);
        return response()->json(['success' => 'Updated Successfully.']);
    }

    public function status(User $user){

        if($user->isApproved == "0"){
            User::find($user->id)->update([
                'isApproved'    => '1',
            ]);
        }

        if($user->isApproved == "1"){
            User::find($user->id)->update([
                'isApproved'    => '0',
            ]);
        }

        return response()->json(['success' => 'Updated Successfully.']);

    }


    // ADMIN FUNCTION

    public function admin_index(){
        $userrole = auth()->user()->role;
        if($userrole == 'admin'){
            $admins = User::where('role', 'admin')->latest()->get();
            return view('admin.adminlist', compact('admins'));
        }
        return abort('403');
    }

    public function admin_store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['string', 'required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'sign_in_password' => ['required',new MatchOldPassword],
        ]);
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role'     => 'admin',
            'isApproved' => 1,
        ]);

        return response()->json(['success' => 'Created Successfully.']);
    
      
    }

    public function admin_update(Request $request , User $admin){
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'name' => ['string', 'required', 'max:255'],
            'sign_in_password' => ['required',new MatchOldPassword],
        ]);
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        User::find($admin->id)->update([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    
    }
}
