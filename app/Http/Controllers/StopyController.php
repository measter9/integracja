<?php

namespace App\Http\Controllers;

use App\Models\stopy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class StopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function current(){
        return Stopy::all()->last();
    }
    public function on(String $data){
//        $from = date_create_from_format('YYYY-mm-dd','1980-01-01');
//        $to = date_create_from_format("YYYY-mm-dd",$data);
        $from = "1980-01-01";


        return Stopy::all()
            ->whereBetween('data', [$from, $data])->last();
    }
}
