<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WishlistController extends Controller
{
    public function index()
    {
        $wishListItems = unserialize(Cookie::get('wishlist-items'));
        // dd($wishListItems);
        return view(
            'frontend.wishlist.show',
            [
                'products' => $wishListItems?Product::whereIn('id', $wishListItems)->get():null
            ]
        );
    }
    public function addToWishlist(String $id)
    {
        $currentValue = Cookie::get('wishlist-items');
        $data = unserialize($currentValue);
        if (!$data) {
            $data[] = $id;
        } else {
            if(in_array($id, $data)){
                return redirect()->back()->with('success',"Sản phẩm đã tồn tại trong danh sách yêu thích");
            }else{
                $data[] = $id;
            }
        }
        $serializedData = serialize($data);
        $cookie = Cookie::make('wishlist-items', $serializedData, 10080);
        // response()->cookie($cookie);
        return redirect()->back()->withCookie($cookie);
    }
}
