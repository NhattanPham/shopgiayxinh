<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class CheckoutController extends Controller
{
    public function index()
    {
        // dd(URL::previous());
        $carts = [];
        $isInCart = 1;
        if(URL::previous() == url('cart')){
            $carts = json_decode(Cookie::get('cart-items'));
        }
        else{
            $carts = json_decode(Cookie::get('buy_nows'));
            $isInCart = 0;
        }
        return view(
            'frontend.checkout.show',
            [
                'carts' => $carts,
                'isInCart' => $isInCart
            ]
        );
    }
    public function checkout(Request $request){
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'province'=>'required',
            'district' => 'required',
            'ward' => 'required'
        ]);
        $currentTime = Carbon::now();
        $order = new Order();
        $order->code_order = 'ABCD';
        $order->customer_id = Auth::check()?Auth::user()->id:0;
        $order->buyer = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->province_id = $request->province;
        $order->district_id = $request->district;
        $order->ward_id = $request->ward;
        $order->created = $currentTime;
        $order->created_by = Auth::check()?Auth::user()->id:0;
        $order->save();
        if($request->isInCart == 1){
            $carts = json_decode(Cookie::get('cart-items'));
            foreach ($carts as $item) {
                $product = Product::find($item->product_id);
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $item->product_id;
                $order_item->product_name = $product->name;
                $order_item->product_color = $item->color;
                $order_item->product_size = $item->size;
                $order_item->product_price = $product->sale_price;
                $order_item->product_qty = $item->quantity;
                $order_item->save();
                return redirect('/')->withCookie(Cookie::forget('cart-items'));
            }
        }else{
            $carts = json_decode(Cookie::get('buy_nows'));
            foreach ($carts as $item) {
                $product = Product::find($item->product_id);
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $item->product_id;
                $order_item->product_name = $product->name;
                $order_item->product_color = $item->color;
                $order_item->product_size = $item->size;
                $order_item->product_price = $product->sale_price;
                $order_item->product_qty = $item->quantity;
                $order_item->save();
                return redirect('/')->withCookie(Cookie::forget('buy_nows'));
            }
        }
        
        

    }
}
