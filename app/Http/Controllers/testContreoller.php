<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use SimpleXMLElement;

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
    public function downloadTest()
    {
        $miasto = $_GET['city'];
        $category = $_GET['category'];
        $from = $_GET['from'];
        $to = $_GET['to'];

        $ret['prices'] = ( (new PricesController())->inCategoryBetween($miasto,$category,$from,$to))->original;
        $ret['rates'] = array_values((new StopyController())->between($from,$to)->toArray());


//        return response($ret);
        return response($ret, 200,[
            'Content-Disposition' => 'attachment; filename="collection.json"']
            );
    }

    public function downloadTestXml()
    {
        try {
            $miasto = $_GET['city'];
            $category = $_GET['category'];
            $from = $_GET['from'];
            $to = $_GET['to'];
        }catch (\Throwable $e){
            return $e->getMessage();
        }

        $xml = new SimpleXMLElement('<xml/>');
        $xml->addAttribute("date_from",$from);
        $xml->addAttribute("date_to",$to);
        $prices = $xml->addChild('prices');
        $prices->addAttribute("miasto",$miasto);
        $xml->addChild('rates');
        $xml->rates->addAttribute("miasto",$miasto);

        $prices = ( (new PricesController())->inCategoryBetween($miasto,$category,$from,$to))->original;
        $rates =  json_decode( (new StopyController())->between($from,$to));

        foreach ($prices as $price) {
            $current = $xml->prices->addChild("price");
                $current->addAttribute("kwartal",$price->kwartal);
                $cena = $current->addChild("cena",$price->cena);
//                $cena->addAttribute("cena",$price->cena);
        }

        foreach ($rates as $rate){
            $current = $xml->rates->addChild("rate");
            foreach ($rate as $key => $value) {
                if($key != "id")
                $current->addChild($key,$value);

            }

        }

//        return $xml->asXML();
        return response($xml->asXML(), 200,[
                'Content-Disposition' => 'attachment; filename="collection.xml"']
        );

    }
}
