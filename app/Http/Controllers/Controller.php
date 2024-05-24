<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public function dump_json(){
        $json = json_decode('app\Http\Resources\ceny_mieszkan.json');
        echo $json;
    }
}
