<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Action
        if ($request->input('task') == 'changeAction') {
            $status = $this->action($request);
            return back()->with('success',$status);
        }
        $search = $request->input('search');
        $limited = option('limit_pages');
        $pages = Page::where('title','LIKE',"%{$search}%")->paginate($limited)->withQueryString();
        return view('backend.pages.list',[
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.form');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.pages.form',[
            'page'=>Page::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'title' => ['required'],
            'content' => ['required'],
        ],
        [
            'title.required' => 'Tiêu đề không được trống',
            'content.required'=> 'Nội dung không được trống'
        ]);
        if($id>0){
            $page =  Page::find($id);
            $message = 'Cập nhật trang thành công';
            $page->modified = NOW();
        }else{
            $page = new Page();
            $message = 'Thêm trang thàng công';
            $page->created = NOW();
        }
        // $page = ($id>0) ? Page::find($id) : new Page();
        $page->title = $request->title;
        $page->slug = Str::of($request->title)->slug('-');
        $page->content = $request->content;
        
        $page->save();
        if($request->input('action') == 'save'){
            return redirect('admin/pages')->with("success", $message);
        }else if($request->input("action") == "update"){
            return back()->with("success", $message);
        }
    }
  /**
     * Make action and return status
     */
    public function action(Request $request){
        $status ='';
        $ids = $request->input('ids');
        switch ($request->input('action')) {
            case 'delete':
                Page::whereIn('id', $ids)->delete();
                $status = "Xóa thành công";
                break;
            default:
                break;
        }
        return $status;
    }
}
