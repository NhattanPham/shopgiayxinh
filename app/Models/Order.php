<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "pkav_orders";
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function getOrderItem($order_id){
        return OrderItem::where('order_id',$order_id)->get();
    }
}
