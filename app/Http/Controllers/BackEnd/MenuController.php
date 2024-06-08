<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{

    public $arrId = array();

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
        $limited = option('limit_menu');
        $menu = Menu::where('name', 'LIKE', "%{$search}%")->paginate($limited)->withQueryString();
        return view('backend.menu.list', [
            'menu' => $menu
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.menu.form');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::find($id);
        $menuItems = MenuItem::where('menu_id', $id)->where('parent_id', 0)->orderBy('ordering')->get();
        // dd($menuItems);
        return view('backend.menu.form', [
            'menu' => $menu,
            'menuItems' => $menuItems
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'nameM' => ['required']
        ],[
            'nameM.required' => 'Tên menu không được để trống'
        ]);
        if ($id > 0) {
            $menu = Menu::find($id);
            $message = "Cập nhật menu thành công";
        } else {
            $menu = new Menu();
            $menu->created = NOW();
            $message = "Thêm menu thành công";
        }
        // dd($request->input('list_data'));
        $menu->name = $request->nameM;
        $menu->slug = Str::of($request->nameM)->slug('-');
        $menu_items = json_decode($request->input('list_data'));
        $menu->save();
        // dd($menu_items);
        $this->updateMenuItem($menu_items, $menu->id, 0);
        MenuItem::where('menu_id', $menu->id)->whereNotIn('id', $this->arrId)->delete();
        if ($request->input('action') == 'save') {
            return redirect('admin/menu')->with("success", $message);
        } else if ($request->input("action") == "update") {
            return back()->with("success", $message);
        }
    }

    /**
     * Update the list menu item.
     */
    public function updateMenuItem($menu_items, $menu_id, $parent_id = 0)
    {
        // dd($menu_items);
        foreach ($menu_items as $key => $value) {
            if ($value->id != 'new') {
                $menu_item = MenuItem::find($value->id);
            } else {
                $menu_item = new MenuItem();
                $menu_item->menu_id = $menu_id;
                $menu_item->type = $value->type;
                $menu_item->type_id = $value->type_id;
            }
            $menu_item->name = $value->name;
            $menu_item->parent_id = $parent_id;
            $menu_item->url = $value->url;
            $menu_item->class = $value->class;
            $menu_item->rel = $value->rel;
            $menu_item->ordering = $key + 1;
            $menu_item->save();
            $this->arrId[] = $menu_item->id;
            if (isset($value->children)) {
                $this->updateMenuItem($value->children, $menu_id, $menu_item->id);
            }
        }
    }

    /**
     * Make action and return status
     */
    public function action(Request $request)
    {
        $status = '';
        $ids = $request->input('ids');
        // dd($ids);
        switch ($request->input('action')) {
            case 'delete':
                foreach ($ids as $id) {
                    $menu = Menu::find($id);
                    MenuItem::where('menu_id', $menu->id)->delete();
                    $menu->delete();
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
