<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;

    protected $table = 'pkav_options';

    protected $primaryKey = 'option_id';
    
    public $timestamps = false;
}
