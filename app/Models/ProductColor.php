<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;
    protected $table = "pkav_product_colors";
    protected $primaryKey = 'color_id';
    public $timestamps = false;
}
