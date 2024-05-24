<?php

namespace App\Http\Controllers;

use App\Models\Prices;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    /**
     * Display a listing of the resource.
    **/

    public function in($city){
        $arr = Prices::all()->where('miasto', 'like',$city)->toArray();
        return response()->json(array_values($arr));
    }
}
