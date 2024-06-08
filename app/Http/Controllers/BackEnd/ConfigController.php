<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Options;
use Illuminate\Http\Request;
use PhpOption\Option;

class ConfigController extends Controller
{
    public function index()
    {
        return view('backend.option.list', [
            'nameCompany' => Options::where('option_name', 'nameCompany')->first(),
            'phone' => Options::where('option_name', 'phone')->first(),
            'address' => Options::where('option_name', 'address')->first(),
            'email' => Options::where('option_name', 'email')->first(),
            'website' => Options::where('option_name', 'website')->first(),
            'hotline' => Options::where('option_name', 'hotline')->first(),
        ]);
    }
    public function limited($number, $limitedpage)
    {
        $option = Options::where('option_name', $limitedpage)->first();
        if ($option) {
            $option->option_value = $number;
        } else {
            $option = new Options;
            $option->option_name = $limitedpage;
            $option->option_value = $number;
            $option->autoload = '1';
        }

        $option->save();

        return back();
    }
}
