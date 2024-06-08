<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $carts = json_decode(Cookie::get('cart-items'));
        // dd($carts);
        return view(
            'frontend.cart.show',
            [
                'carts' => $carts
            ]
        );
    }
    public function addToCart(Request $request, String $id)
    {
        $request->validate([
            'color' => 'required',
            'size' => 'required'
        ]);
        $currentValue = Cookie::get('cart-items');
        $data = json_decode($currentValue);
        $data[] = [
            'product_id' => $id,
            'quantity' => $request->quantity,
            'color' => $request->color,
            'size' => $request->size
        ];
        $serializedData = json_encode($data);
        $cookie = Cookie::make('cart-items', $serializedData, 10080);
        return redirect()->back()->withCookie($cookie)->with("success", "Sản phẩm đã được thêm vào giỏ hàng");
    }
    public function updateQuantity(Request $request)
    {
        $carts = json_decode(Cookie::get('cart-items'));
        foreach ($carts as $cart) {
            if ($cart->product_id == $request->product_id && $cart->color == $request->color && $cart->size == $request->size) {
                $cart->quantity = $request->quantity;
            }
        }
        $serializedData = json_encode($carts);
        $cookie = Cookie::make('cart-items', $serializedData, 10080);
        return response('Update-cart-item-quantity')->cookie($cookie);
    }
    public function addToCheckout(Request $request){
        $carts = [];
        $carts[] = [
            'product_id' => $request->id,
            'quantity' => $request->quantity,
            'color' => $request->color,
            'size' => $request->size
        ];
        $dataEncode = json_encode($carts);
        $cookie = Cookie::make('buy_nows', $dataEncode, 10);
        return redirect('/checkout')->withCookie($cookie)->with("success", "Vui lòng điền đầy đủ thông tin");
    }
    public function destroy(Request $request)
    {
        $carts = json_decode(Cookie::get('cart-items'));
        $key = null;
        foreach ($carts as $index => $cart) {
            if ($cart->product_id == $request->product_id && $cart->color == $request->color && $cart->size == $request->size) {
                $key = $index;
                break;
            }
        }
        if ($key !== null) {
            unset($carts[$key]);
        }
        $serializedData = json_encode($carts);
        $cookie = Cookie::make('cart-items', $serializedData, 10080);
        return redirect()->back()->withCookie($cookie)->with('success', "Xóa sản phẩm khỏi giỏ hàng thành công");
    }
}
