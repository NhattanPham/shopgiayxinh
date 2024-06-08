<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->input('task') == 'changeAction') {
            $status = $this->action($request);
            return back()->with('success', $status);
        }
        $search = $request->input('search');
        $limited = option('limit_posts');
        $posts = Post::where('title', 'LIKE', "%{$search}%")->paginate($limited)->withQueryString();
        return view('backend.posts.list', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.posts.form', [
            'cates' => Categories::where('extension', 'like', 'post')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.posts.form', [
            'post' => Post::find($id),
            'cates' => Categories::where('extension', 'like', 'post')->get(),
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
            'cate_id' => ['required'],
            'content' => ['required'],
            'thumbnail' => [($id == 0) ? 'required' : '']
        ],
        [
            'title.required' => 'Tiêu đề không được trống',
            'cate_id.required' => 'Chưa chọn nhóm bài viết',
            'content.required'=> 'Nội dung không được trống',
            'thumbnail.required' => 'Chưa chọn hình đại diện',
        ]);
        if($id>0){
            $post =  Post::find($id);
            $thumbnail_link = $post->thumbnail;
            $message = 'Cập nhật bài viết thành công';
            $post->modified = NOW();
        }else{
            $post = new Post();
            $message = 'Thêm bài viết thàng công';
            $post->created = NOW();
        }
        if ($request->has('thumbnail')) {
            // dd($request->file('thumbnail'));
            if (File::exists(public_path($post->thumbnail))) {
                File::delete(public_path($post->thumbnail));
            }
            $couter = 1;
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = $thumbnail->getClientOriginalName();
            $thumbnailExtension = $thumbnail->getClientOriginalExtension();
            $thumbnailNameWithoutExtension = pathinfo($thumbnailName, PATHINFO_FILENAME);
            $thumbnailToStore = $thumbnailName;

            while (file_exists(public_path('uploads/posts/' . $thumbnailToStore))) {
                $thumbnailToStore = $thumbnailNameWithoutExtension . '-' . $couter . '.' . $thumbnailExtension;
                $couter++;
            }
            $thumbnail->move(public_path('uploads/posts/'), $thumbnailToStore);
            $thumbnail_link = 'uploads/posts/' . $thumbnailToStore;
        }
        $post->cate_id = $request->cate_id;
        $post->title = $request->title;
        $post->slug = Str::of($request->title)->slug('-');
        $post->introtext = $request->introtext;
        $post->content = $request->content;
        $post->thumbnail = $thumbnail_link;
        $post->meta_title = $request->meta_title;
        $post->meta_keyword = $request->meta_keyword;
        $post->meta_description = $request->meta_description;
        $post->meta_index = $request->meta_index;
        $post->meta_follow = $request->meta_follow;
        $post->canonical_url = $request->canonical_url;

        $post->save();
        if($request->input('action') == 'save'){
            return redirect('admin/posts')->with("success", $message);
        }else if($request->input("action") == "update"){
            return back()->with("success", $message);
        }
    }
    /**
     * Make action and return status
     */
    public function action(Request $request)
    {
        $status = '';
        $ids = $request->input('ids');
        switch ($request->input('action')) {
            case 'delete':
                $posts = Post::whereIn('id', $ids)->get();
                foreach ($posts as $post) {
                    if (File::exists(public_path($post->thumbnail))) {
                        File::delete(public_path($post->thumbnail));
                    }
                    $post->delete();
                }
                $status = "Xóa thành công";
                break;
            default:
                break;
        }
        return $status;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
