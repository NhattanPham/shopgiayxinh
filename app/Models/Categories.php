<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = 'pkav_categories';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected static $categoriesTree = array();
    // public $level=0;

    public static function getTree($extension = '', $parent_id = 0){
        Categories::$categoriesTree = array();
        if(!empty($extension)){
            self::subTree($extension, $parent_id);
        }
        return Categories::$categoriesTree;
    }
    public static function subTree($extension = '', $parent_id = 0){
        $categories = Categories::where('parent_id', $parent_id)
								->where('extension', $extension)
								->orderBy('id')
								->get();
        if(count($categories) > 0){
            foreach($categories as $category) {
				Categories::$categoriesTree[] = $category;
				if($category->id > 0) {
					self::subTree($extension, $category->id);
				}
			}
        }
        return Categories::$categoriesTree;
    }
    public static function levelCategory($parent_id = 0, $level = 0) {
        // dd($parent_id);
		if($parent_id == 0) {
			return $level;
		}
		return self::levelCategory(Categories::find($parent_id)->parent_id, $level + 1);
	}
}
