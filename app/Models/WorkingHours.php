<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    use HasFactory;
    protected $guarded = [];

    static function getString($workingHourId)
    {
        $c = WorkingHours::where('id',$workingHourId)->count();
        if ($c != 0)
        {
            $w = WorkingHours::where('id',$workingHourId)->get();
            return $w[0]['hours'];
        }
        else{
            return "";
        }
    }
}
