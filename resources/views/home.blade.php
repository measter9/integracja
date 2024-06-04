@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                        <form action="{{ route('chart') }}" method="GET">
                            <label for="city">Wybierz miasto: </label>
                            <select name="city" id="city">
                                <?php
                                function generateCities() {
                                    $cities = ["-- Nie wybrano --", "Białystok", "Bydgoszcz", "Gdańsk", "Gdynia", "Katowice", "Kielce", "Kraków", "Lublin", "Łódź", "Olsztyn", "Opole", "Poznań", "Rzeszów", "Szczecin", "Warszawa", "Wrocław", "Zielona Góra", "6 miast bez Warszawy", "7 miast", "9 miast", "10 miast", "Gdynia*"];

                                    $options = '';
                                    foreach ($cities as $city) {
                                        $options .= '<option value="'. $city .'">'. $city .'</option>';
                                    }

                                    return $options;
                                }

                                $selectedCity = $_POST['city'] ?? '';

                                if ($selectedCity === '-- Nie wybrano --') {
                                    echo "Error!";
                                } else {
                                    echo generateCities();
                                }
                                ?>
                            </select>
                            <br>
                            <label for="category">Wybierz kategorie: </label>
                            <select name="category" id="category">
                                <?php
                                function generateCategories() {
                                    $categories = ["Rynek pierwotny(oferta)", "Rynek pierwotny(tranzakcja)", "Rynek wtórny (oferta)", "Rynek wtórny (tranzakcja)"];

                                    $options = '';
                                    foreach ($categories as $category) {
                                        $options .= '<option value="'. $category .'">'. $category .'</option>';
                                    }

                                    return $options;
                                }

                                echo generateCategories();
                                ?>
                            </select>
                            <br>

                            <label for="date">Wybierz datę: </label>
                            <input type="date" name="from">
                            <input type="date" name="to">

                            <br>

                            <label for="stopTypes">Wybierz rodzaj stop procentowych:</label>
                            <select>
                                <?php
                                function generateStopTypes() {
                                    $stopTypes = ["ref", "lom", "dep", "red", "dys"];

                                    $options = '';
                                    foreach ($stopTypes as $stopType) {
                                        $options .= '<option value="'. $stopType .'">'. $stopType .'</option>';
                                    }

                                    return $options;
                                }

                                echo generateStopTypes();
                                ?>
                            </select>
                            <br>


                            <input type="submit" value="Zapisz">
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
