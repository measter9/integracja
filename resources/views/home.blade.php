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

                        <form action="{{ route('chart') }}" method="GET" id="chartForm">
                            @csrf

                            <label for="city">Wybierz miasto: </label>
                            <select name="city" id="city">
                                @php
                                    $cities = ["-- Nie wybrano --", "Białystok", "Bydgoszcz", "Gdańsk", "Gdynia", "Katowice", "Kielce", "Kraków", "Lublin", "Łódź", "Olsztyn", "Opole", "Poznań", "Rzeszów", "Szczecin", "Warszawa", "Wrocław", "Zielona Góra", "6 miast bez Warszawy", "7 miast", "9 miast", "10 miast", "Gdynia*"];
                                @endphp
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                            <br>

                            <label for="category">Wybierz kategorie: </label>
                            <select name="category" id="category">
                                @php
                                    $categories = ["-- Nie wybrano --", "Rynek pierwotny(oferta)", "Rynek pierwotny(tranzakcja)", "Rynek wtórny (oferta)", "Rynek wtórny (tranzakcja)"];
                                @endphp
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            <br>

                            <label for="date">Wybierz datę: </label>
                            <input type="date" name="from" id="from" value="{{ old('from') }}" required min="2006-01-01" max="2024-12-31">
                            <input type="date" name="to" id="to" value="{{ old('to') }}" required min="2006-01-01" max="2024-12-31">
                            <br>

                            <label for="stopTypes">Wybierz rodzaj stop procentowych:</label>
                            <select name="stopTypes" id="stopTypes">
                                @php
                                    $stopTypes = ["-- Nie wybrano --", "ref", "lom", "dep", "red", "dys"];
                                @endphp
                                @foreach ($stopTypes as $stopType)
                                    <option value="{{ $stopType }}" {{ old('stopTypes') == $stopType ? 'selected' : '' }}>{{ $stopType }}</option>
                                @endforeach
                            </select>
                            <br>

                            <input type="submit" value="Zapisz">
                        </form>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('chartForm').addEventListener('submit', function(event) {
                let city = document.getElementById('city').value;
                let category = document.getElementById('category').value;
                let stopTypes = document.getElementById('stopTypes').value;
                let fromDate = document.getElementById('from').value;
                let toDate = document.getElementById('to').value;

                var message = "";

                if (city === "-- Nie wybrano --") {
                    event.preventDefault();
                    message += "Proszę wybrać miasto.\n";
                }

                if (category === "-- Nie wybrano --") {
                    event.preventDefault();
                    message += "Proszę wybrać kategorię.\n";
                }

                if (fromDate === '' || toDate === '') {
                    event.preventDefault();
                    message += "Proszę wybrać datę.\n";
                } else {
                    let fromYear = new Date(fromDate).getFullYear();
                    let toYear = new Date(toDate).getFullYear();

                    if (fromYear < 2006 || fromYear > 2024 || toYear < 2006 || toYear > 2024) {
                        event.preventDefault();
                        message += "Rok daty powinien być z zakresu od 2006 do 2024.\n";
                    }

                    if (fromYear >= toYear) {
                        event.preventDefault();
                        message += "Proszę wybrać właściwy rok (np. od 2004 do 2024).\n"
                    }
                }

                if (stopTypes === "-- Nie wybrano --") {
                    event.preventDefault();
                    message += "Proszę wybrać rodzaj stop procentowych.\n";
                }


                console.log(message)

            });
        });
    </script>
@endpush
