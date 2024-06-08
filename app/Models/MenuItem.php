<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = "pkav_menu_items";
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function children(){
        return $this->hasMany(MenuItem::class,'parent_id')->orderBy('ordering');
    }
}
