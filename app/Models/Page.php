<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $table = "pkav_pages";
    protected $primaryKey = 'id';
    public $timestamps = false;
}
