<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.home',[
            'products'=>Product::all(),
            'sliders'=>Slider::orderBy('ordering')->get(),
            'categories'=>Categories::where('parent_id',0)->where('extension','like','product')->get()
        ]);
    }

}
