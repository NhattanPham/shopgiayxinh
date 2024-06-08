<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
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
        $limited = option('limit_products');
        $products = Product::where('name', 'LIKE', "%{$search}%")->paginate($limited)->withQueryString();
        return view('backend.products.list',[
            'products' =>  $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::getTree('product', 0);
        return view('backend.products.form', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Categories::getTree('product', 0);
        return view('backend.products.form', [
            'categories' => $categories,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        // dd(json_decode($request->input('listImage')));
        // dd(explode(",", $request->input('colors')));
        $id = $request->id;
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'colors' => ['required'],
            'sizes' => ['required'],
            'listimage' => ['required'],
            'thumbnail' => [($id == 0) ? 'required' : '']
        ],[
            'name.required' => 'Tên danh mục không được trống',
            'description.required'=> 'Nội dung chi tiết sản phẩm không được trống',
            'thumbnail.required' => 'Chưa chọn hình đại diện',
            'listimage.required' => 'Hình sản phẩm không được trống',
            'colors.required' => 'Chưa thêm màu cho sản phẩm',
            'sizes.required' => 'Chưa thêm size cho sản phẩm',
            
        ]);
        if ($id > 0) {
            $product = Product::find($id);
            $thumbmail_link = $product->thumbnail;
            $message = "Cập nhật sản phẩm thành công";
        } else {
            $product = new Product();
            $message = "Thêm sản phẩm thành công";
        }
        if ($request->has('thumbnail')) {
            // dd($request->file('thumbnail'));
            if (File::exists(public_path($product->thumbnail))) {
                File::delete(public_path($product->thumbnail));
            }
            $couter = 1;
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = $thumbnail->getClientOriginalName();
            $thumbnailExtension = $thumbnail->getClientOriginalExtension();
            $thumbnailNameWithoutExtension = pathinfo($thumbnailName, PATHINFO_FILENAME);
            $thumbnailToStore = $thumbnailName;

            while (file_exists(public_path('uploads/products/' . $thumbnailToStore))) {
                $thumbnailToStore = $thumbnailNameWithoutExtension . '-' . $couter . '.' . $thumbnailExtension;
                $couter++;
            }
            $thumbnail->move(public_path('uploads/products/'), $thumbnailToStore);
            $thumbmail_link = 'uploads/products/' . $thumbnailToStore;
        }
        // Save Images
        $listImage = json_decode($request->input('listimage'));
        $listImageNames = [];
        // if ($request->has('images')) {
        foreach ($listImage as $imageItem) {
            if ($imageItem->isadd == true && $request->has('images')) {
                foreach ($request->file('images') as $imageInput) {
                    if ($imageInput->getClientOriginalName() == $imageItem->name && $imageInput->getSize() == $imageItem->size) {
                        $imageName = $imageInput->getClientOriginalName();
                        $extension = $imageInput->getClientOriginalExtension();
                        $imageNameWithoutExtension = pathinfo($imageName, PATHINFO_FILENAME);
                        $imageToStore = $imageName;
                        $couter = 1;
                        while (file_exists(public_path('uploads/products/images/' . $imageToStore))) {
                            $imageToStore = $imageNameWithoutExtension . '-' . $couter . '.' . $extension;
                            $couter++;
                        }
                        if (!file_exists(public_path('uploads/products/images/' . $imageToStore))) {
                            $listImageNames[] = $imageToStore;
                            $imageInput->move(public_path('uploads/products/images'), $imageToStore);
                        }
                    }
                }
            } else {
                $listImageNames[] = $imageItem->name;
            }
        }
        // Delete image if not exists in $listImageNames
        if ($id > 0) {
            foreach (json_decode($product->product_images) as $image) {
                if (!in_array($image, $listImageNames)) {
                    if (File::exists(public_path('uploads/products/images/' . $image))) {
                        File::delete(public_path('uploads/products/images/' . $image));
                    }
                }
            }
        }
        $product->name = $request->name;
        $product->cate_id = $request->parent_id;
        $product->sku = 0;
        $product->slug = Str::of($request->name)->slug('-');
        $product->description = $request->description;
        $product->introtext = $request->introtext;
        $product->thumbnail = $thumbmail_link;
        $product->product_price = $request->product_price;
        $product->sale_price = $request->sale_price;
        $product->created =  ($id > 0) ? $product->created : NOW();
        $product->product_colors = json_encode(explode(",", $request->input('colors')));
        $product->product_sizes = json_encode(explode(",", $request->input('sizes')));
        $product->product_images = json_encode($listImageNames);
        $product->special = 0;
        $product->meta_title = $request->meta_title;
        $product->meta_keyword = $request->meta_keyword;
        $product->meta_description = $request->meta_description;
        $product->meta_index = $request->meta_index;
        $product->meta_follow = $request->meta_follow;
        $product->canonical_url = $request->canonical_url;
        $product->save();
        if ($request->input('action') == 'save') {
            return redirect('admin/products')->with("success", $message);
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
            case 'delete':
                $products = Product::whereIn('id', $ids)->get();
                foreach ($products as $product) {
                    if (File::exists(public_path($product->thumbnail))) {
                        File::delete(public_path($product->thumbnail));
                    }
                    $product->delete();
                }
                $status = "Xóa thành công";
                break;
            default:
                break;
        }
        return $status;
    }

    /**
     * 
     */
    public function getList(Request $request)
    {
        $search = $request->input('search');
        $productList = Product::where('name','LIKE',"%{$search}%")->paginate(5);
        return response()->json($productList)->withCallback();
    }
}
