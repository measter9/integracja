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
    public function in_category($city,$category){
        $arr = Prices::all()->where('miasto', 'like',$city)->where('kategoria','like',$category)->toArray();
        return response()->json(array_values($arr));

    }
    public function inCategoryBetween($city, $category, $from, $to)
    {
        $ret = array();
        $q = new StopyController();
        $json = json_decode($this->in_category($city,$category)->content());
        foreach ($json as $item){
            $date = strtotime( $q->kwartalToData($item->kwartal));
            if ( $date > strtotime($from) && $date < strtotime($to) ){
                array_push($ret,$item);
            }
        }
        return response()->json(array_values($ret));
    }
    public function getCities()
    {
        return Prices::distinct()->get(['miasto']);
    }
    public function getCategories()
    {
        return  Prices::distinct()->get(['kategoria']);

    }
}
