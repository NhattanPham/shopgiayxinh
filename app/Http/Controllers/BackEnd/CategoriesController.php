<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $extension)
    {
        // Action
        if ($request->input('task') == 'changeAction') {
            $status = $this->action($request);
            return back()->with('success', $status);
        }
        $search = $request->input('search');
        $limited = option('limit_categories') != null ? option('limit_categories') : 20;
        // Get list categories with search
        if ($search != null) {
            $categories = Categories::where('name', 'LIKE', "%{$search}%")
                ->where('extension', '=', $extension)
                ->paginate($limited)->withQueryString();
        } else {
            // Get list categories without search
            $list_categories = Categories::getTree($extension, 0);
            // Pagination for list array
            $page = LengthAwarePaginator::resolveCurrentPage();
            $items = collect($list_categories);
            $data = new LengthAwarePaginator($items->forPage($page, $limited), $items->count(), $limited, $page);
            // Add path for url pagination
            $categories = $data->withPath('/admin/categories/' . $extension);
        }
        return view('backend.categories.list', [
            'categories' => $categories,
            'extension' => $extension,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $extension)
    {
        $categories = Categories::getTree($extension, 0);
        return view('backend.categories.form', [
            'extension' => $extension,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $extension, string $id)
    {
        $categories = Categories::getTree($extension, 0);
        return view('backend.categories.form', [
            'category' => Categories::find($id),
            'extension' => $extension,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $extension)
    {
        $id = $request->id;
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'thumbnail' => [($id == 0) ? 'required' : '']
        ],[
            'name.required' => 'Tên danh mục không được trống',
            'description.required'=> 'Nội dung không được trống',
            'thumbnail.required' => 'Chưa chọn hình đại diện',
        ]);
        if ($id > 0) {
            $category =  Categories::find($id);
            $thumbnail_link = $category->thumbnail;
            $message = "Cập nhật danh mục thành công";
        } else {
            $category = new Categories();
            $message = "Thêm danh mục thành công";
        }
        if ($request->has('thumbnail')) {
            // dd($request->file('thumbnail'));
            if (File::exists(public_path($category->thumbnail))) {
                File::delete(public_path($category->thumbnail));
            }
            $couter = 1;
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = $thumbnail->getClientOriginalName();
            $thumbnailExtension = $thumbnail->getClientOriginalExtension();
            $thumbnailNameWithoutExtension = pathinfo($thumbnailName, PATHINFO_FILENAME);
            $thumbnailToStore = $thumbnailName;

            while (file_exists(public_path('uploads/categories/' . $thumbnailToStore))) {
                $thumbnailToStore = $thumbnailNameWithoutExtension . '-' . $couter . '.' . $thumbnailExtension;
                $couter++;
            }
            $thumbnail->move(public_path('uploads/categories/'), $thumbnailToStore);
            $thumbnail_link = 'uploads/categories/' . $thumbnailToStore;
        }
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->slug = Str::of($request->name)->slug('-');
        $category->introtext = $request->introtext;
        $category->description = $request->description;
        $category->thumbnail = $thumbnail_link;
        $category->extension = $extension;
        $category->hits = 0;
        $category->ordering = 0;
        $category->created = NOW();
        $category->created_by = 0;
        $category->modified = NOW();
        $category->modified_by = 0;
        $category->check_out = 0;
        $category->check_out_time = NOW();
        $category->stated = $request->stated;
        $category->meta_title = $request->meta_title;
        $category->meta_keyword = $request->meta_keyword;
        $category->meta_description = $request->meta_description;
        $category->meta_index = $request->meta_index;
        $category->meta_follow = $request->meta_follow;
        $category->canonical_url = $request->canonical_url;

        $category->save();
        if ($request->input('action') == 'save') {
            return redirect('admin/categories/' . $extension)->with("success", $message);
        } else if ($request->input("action") == "update") {
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
            case 'published':
                Categories::whereIn('id', $ids)->update(['stated' => 1]);
                $status = "Xuất bản danh mục thành công";
                break;
            case 'unpublished':
                Categories::whereIn('id', $ids)->update(['stated' => 0]);
                $status = "Khóa danh mục thành công";
                break;
            case 'delete':
                $categories = Categories::whereIn('id', $ids)->get();
                foreach ($categories as $category) {
                    if (File::exists(public_path($category->thumbnail))) {
                        File::delete(public_path($category->thumbnail));
                    }
                    $category->delete();
                }
                $status = "Xóa thành công";
                break;
            default:
                break;
        }
        return $status;
    }
    /**
     * published or unpublished user
     */
    public function published($extension,$id){
        $category = Categories::find($id);
        // dd($category);
        $category->stated = ($category->stated == 1)? 0 : 1 ;
        $category->save();
        return back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
