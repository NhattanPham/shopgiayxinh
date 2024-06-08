<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.blog.showBlog',['blogs'=>Post::all()]);
    }
    public function showDetail(string $slug){
        // dd(Post::where('slug',$slug)->get());
        return view('frontend.blog.showBlogDetail',['blog'=>Post::where('slug',$slug)->first()]);
    }
}
