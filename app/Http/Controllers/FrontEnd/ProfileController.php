<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('frontend.user.profile');
    }
    public function purchase()
    {
        // dd(Product::select('thumbnail')->where('id',41)->get());
        if(!Auth::check()){
            return redirect('/login');
        }
        return view('frontend.user/purchase', [
            'orders' => Order::where('customer_id', Auth::user()->id)->get()
        ]);
    }
}
