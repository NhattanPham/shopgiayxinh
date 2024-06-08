<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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
        $limited = option('limit_orders');
        $orders = Order::where('code_order','LIKE',"%{$search}%")->paginate($limited)->withQueryString();
        return view(
            'backend.orders.list',
            [
                'orders' => $orders,
            ]
        );
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = [];
        if($request->has('list-product')){
            $data = json_decode($request->input('list-product'));
        }
        return view('backend.orders.form', [
            'products' => Product::all(),
            'listProduct' => $data
        ]);
    }

    public function detail(string $id){
        return view('backend.orders.detail',[
            'order' => Order::find($id),
            'listProduct' => OrderItem::where('order_id',$id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,string $id)
    {
        $order = Order::find($id);
        $province = Province::all();
        $district = District::where('_province_id',$order->province_id)->get();
        $ward = Ward::where('_district_id',$order->district_id)->get();
        return view('backend.orders.form', [
            'order' => $order,
            'listProduct' => OrderItem::where('order_id',$id)->get(),
            // 'products' => Product::alprovince(),
            'province' => $province,
            'district' => $district,
            'ward' => $ward
            

        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->customer-request);
        $order = ($request->order_id > 0) ? Order::find($request->order_id) : new Order();
        $request->validate([
            'buyer' => ['required'],
            'phone' => ['required'],
            'email' => ['required'],
            'province' => ['required'],
            'district' => ['required'],
            'ward' => ['required'],
            'address' => ['required'],
            'list_order_item' => ['required'],
        ],[
            'buyer.required' => 'Người mua không được trống',
            'phone.required' => 'Số điện thoại không được trống',
            'email.required' => 'Email không được trống',
            'province.required' => 'Tỉnh/Thành phố không được trống',
            'district.required' => 'Quận/Huyện không được trống',
            'ward.required' => 'Phường/Xã không được trống',
            'address.required' => 'Địa chỉ cụ thể không được trống',
            'list_order_item.required' => 'Danh sách sản phẩm không được trống',


        ]);

        $order->code_order = ($request->order_id > 0) ? $order->code_order : 'ABCD';
        $order->customer_id = Auth::check()?Auth::user()->id:0;
        $order->payment = $request->payment;
        $order->stated = $request->stated;
        $order->buyer = $request->buyer;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->province_id = $request->province;
        $order->district_id = $request->district;
        $order->ward_id = $request->ward;
        $order->notes = $request->notes;
        $order->request = $request->customer_request;
        $order->created = NOW();
        $order->created_by = Auth::check()?Auth::user()->id:0;
        // dd($order);
        $order->save();
        $order_item_list = json_decode($request->list_order_item);
        $arrOrderItemId = [];
        foreach ($order_item_list as $item) {
            $order_item = new OrderItem();
            if($item->id>0){
                $order_item = OrderItem::find($item->id);
                $order_item->product_qty = $item->product_qty;
                $order_item->product_color = $item->product_color;
                $order_item->product_size = $item->product_size;

            }else{
                $product = Product::find($item->product_id);
                $order_item->order_id = $order->id;
                $order_item->product_id = $item->product_id;
                $order_item->product_name = $product->name;
                $order_item->product_color = $item->product_color;
                $order_item->product_size = $item->product_size;
                $order_item->product_price = $product->sale_price;
                $order_item->product_qty = $item->product_qty;
                $order_item->product_color = $item->product_color;
                $order_item->product_size = $item->product_size;
            }
            $order_item->save();
            $arrOrderItemId[] = $order_item->id;
        }
        OrderItem::where('order_id',$order->id)->whereNotIn('id',$arrOrderItemId)->delete();
        return redirect()->back()->with('success',($request->order_id > 0) ? 'Cập nhật đơn thành công' : 'Tạo đơn hàng thành công');
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
                    $order = Order::find($id);
                    OrderItem::where('order_id', $order->id)->delete();
                    $order->delete();
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
    public function destroy(Request $request)
    {
    }
}
