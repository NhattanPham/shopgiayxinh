<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductShowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showProductWithCategory(Request $request,$slug){
        $category = Categories::where('slug','like',$slug)->first();
        // dd($category);
        $order = request()->input('orderBy')?request()->input('orderBy'):'created DESC';
        $listCategoryId = Categories::where('parent_id',$category->id)->pluck('id');
        $listCategoryId[] = $category->id;
        return view('frontend.product.showWithCategory',[
            'slug'=>$slug,
            'category'=> $category,
            'products'=>Product::whereIn('cate_id', $listCategoryId)->orderByRaw($order)->paginate(15)->withQueryString(),
            'categories'=>Categories::where('parent_id',$category->id)->get()
        ]);
    }
    public function showProductDetail($cate_slug,$slug){
        return view('frontend.product.showDetail',[
            'product'=>Product::where('slug',$slug)->first()
        ]);
    }
}
