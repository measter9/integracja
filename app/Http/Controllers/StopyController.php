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

    public function kwartalToData($kwartal)
    {
        $arr = explode(" ",$kwartal);
        $ret = $arr[1];
        switch ($arr[0]){
            case "I":
                $ret .= "-01-01";
                break;
            case "II":
                $ret .= "-04-01";
                break;
            case "III":
                $ret .= "-07-01";
                break;
            case "IV":
                $ret .= "-10-01";
                break;
        }
        return $ret;
    }

    public function all()
    {
        return Stopy::all()->whereBetween('data',["2006-01-01","2024-01-01"]);
    }
    public function on(String $data){
//        $from = date_create_from_format('YYYY-mm-dd','1980-01-01');
//        $to = date_create_from_format("YYYY-mm-dd",$data);
        $from = "1980-01-01";


        return Stopy::all()
            ->whereBetween('data', [$from, $data])->last();
    }
    public function between($form, $to){
        return Stopy::all()->whereBetween('data', [$form, $to]);
    }

    public function getRatesTypes()
    {
        return ["ref","lom","dep","red","dys"];
    }

}
