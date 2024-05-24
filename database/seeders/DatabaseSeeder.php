<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Prices;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\table;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $file = Storage::disk('local')->get('./public/ceny_mieszkan.json');
        $json = json_decode($file);
        $currentDate = "0000";


        foreach ($json as $kategoria => $row) {
            foreach ($row as $v1) {
                foreach ($v1 as $miasto => $kwota) {  //rozpawkowanie JSON na potrzebne pola
                    if ($miasto == 'Kwartał'){      // pole miasto czasami zawiera informacje o kwartale
                        $currentDate = $kwota;      // w tym przypadku kwota zawiera dany kwartał
                        // chcemy żeby każdy rekord w bazie danych posiadał informacje o kwartale wiec zapisujemy ja
                    }else{
                        if (!DB::table('price')     //sprawdzamy czy rekord sie nie powtarza
                            ->where('kategoria', $kategoria)
                            ->where('kwartal',$currentDate)
                            ->where('miasto',$miasto)
                            ->where('cena',$kwota)->exists())
                        {
                            DB::table('price')->insert([    // jesli rekord jest unikalny to zapisjemy go
                                'kategoria' => $kategoria,
                                'kwartal' => $currentDate,
                                'miasto' => $miasto,
                                'cena' => $kwota
                            ]);

                        }


                    }
                }
            }
        }


        $file = Storage::disk('local')->get('./public/stopy_procentowe_archiwum.xml');
        $xml = simplexml_load_string($file);
//dd($xml);
        foreach ($xml->pozycje as $element ) {
            foreach ($element->pozycja as $item) {
                $itemsToSave[trim($item['id'])] =  floatval(str_replace(",",".",$item['oprocentowanie']));
                var_dump($itemsToSave);
            }
            if(!DB::table('stopy')
                ->where('data',$element['obowiazuje_od'])
                ->exists()
            )

            DB::table('stopy')->insert([
                'data' => $element['obowiazuje_od'],
                'ref' => (array_key_exists('ref',$itemsToSave)) ? $itemsToSave['ref'] : null,
                'lom' => (array_key_exists('lom',$itemsToSave)) ? $itemsToSave['lom'] : null,
                'dep' => (array_key_exists('dep',$itemsToSave)) ? $itemsToSave['dep']: null,
                'red' => (array_key_exists('red',$itemsToSave)) ? $itemsToSave['red']: null,
                'dys' => (array_key_exists('dys',$itemsToSave)) ? $itemsToSave['dys']: null,
            ]);
            $itemsToSave = [];
        }




    }
}
