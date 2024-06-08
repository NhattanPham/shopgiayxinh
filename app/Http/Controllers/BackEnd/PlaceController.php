<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function getProvince(){
        $province = Province::all();
        return response()->json($province);
    }
    public function getDistrict($id){
        $district = District::where('_province_id',$id)->get();
        return response()->json($district);
    }
    public function getWard($id){
        $ward = Ward::where('_district_id',$id)->get();
        return response()->json($ward);
    }
}
