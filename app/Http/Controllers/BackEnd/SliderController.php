<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.sliders.list',[
            'sliders' => Slider::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.sliders.form');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        return view('backend.sliders.form',[
            'slider' => Slider::find($id)
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
            'description' => ['required'],
            'image' => [($id == 0) ? 'required' : '']
        ],[
            'title.required' => 'Tiêu đề không được trống',
            'description.required'=> 'Nội dung không được trống',
            'image.required' => 'Chưa chọn hình đại diện',
        ]);
        if($id > 0){
            $slider = Slider::find($id);
            $image_link = $slider->image;
            $message = 'Cập nhật thành công';
        }else{
            $slider = new Slider();
            $slider->ordering = Slider::max('ordering') + 1;
            $message = 'Thêm thành công';
        }
        if ($request->has('image')) {
            if (File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }
            $couter = 1;
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $imageNameWithoutExtension = pathinfo($imageName, PATHINFO_FILENAME);
            $imageNameToStore = $imageName;

            while (file_exists(public_path('uploads/sliders/' . $imageNameToStore))) {
                $imageNameToStore = $imageNameWithoutExtension . '-' . $couter . '.' . $extension;
                $couter++;
            }
            $image->move(public_path('uploads/sliders/'),$imageNameToStore);
            $image_link = 'uploads/sliders/' .$imageNameToStore;
        }
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->image = $image_link;
        $slider->link = $request->link;
        $slider->target = $request->target;
        
        $slider->save();
        if($request->input('action') == 'save'){
            return redirect('admin/sliders')->with("success", $message);
        }else if($request->input("action") == "update"){
            return back()->with("success", $message);
        }
    }
     /**
     * Fast update in index page
     */
    public function updateIndex(Request $request){
        // dd($request->all());
        $sliders = Slider::all();
        foreach ($sliders as $slider) {
            $slider->title = $request->input('title_'.$slider->id);
            $slider->link = $request->input('url_'.$slider->id);
            $slider->ordering = $request->input('order_'.$slider->id);
            $slider->save();
        }
        return back()->with('success','Cập nhật thành công');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider =  Slider::find($id);
        if (File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }
        $slider->delete();
        return back()->with('success','Xóa thành công');
    }
}
