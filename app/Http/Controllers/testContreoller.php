<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class testContreoller extends Controller
{
    public function json(){
        $file = Storage::disk('local')->get('./public/ceny_mieszkan.json');
        $json = json_decode($file);
        $currentDate = "0000";
        foreach ($json as $kategoria => $row) {
            foreach ($row as $v1) {
                foreach ($v1 as $miasto => $kwota) {
                    if ($miasto == 'Kwartał'){
                        $currentDate = $kwota;
                    }else{
                    echo $kategoria . " | ";
                    echo $currentDate. " | ";
                    echo $miasto . "  | ";
                    echo $kwota."";
                    echo "</br>";
                    }
                }
            }
        }
        //echo dd($json);
        return ;
    }


    public function xml()
    {
        $file = Storage::disk('local')->get('./public/stopy_procentowe_archiwum.xml');
        $xml = simplexml_load_string($file);
//dd($xml);
        foreach ($xml->pozycje as $element ) {
            echo $element['obowiazuje_od'];
            foreach ($element->pozycja as $item) {
                echo "</br>";
                echo $item['id']." ".floatval(str_replace(",",".",$item['oprocentowanie']));
            }
            echo "<br/>";
        }


    }
}
