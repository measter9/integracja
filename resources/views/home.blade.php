@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center; font-weight: bold; font-size: larger;">
                        {{ __('Zestawienie Danych na Temat Wysokości Stóp Procentowych i Cen Mieszkań') }}
                    </div>

                    <div class="card-body">
                        <p>Witamy na naszej stronie, gdzie znajdziesz kompleksowe zestawienia danych na temat wysokości stóp procentowych oraz cen mieszkań w Polsce z ostatnich 10 lat. Nasza platforma umożliwia szczegółową analizę rynku nieruchomości, uwzględniając różne regiony oraz typy mieszkań.</p>
                        <div class="text-center"> <!-- Używamy klasy text-center -->
                            <img src="https://www.kokpitzarzadzania.pl/wp-content/uploads/2023/03/wykresy-w-wizualizacji-danych.jpg" alt="Główny wykres" class="img-fluid rounded mx-auto d-block"> <!-- Używamy klasy mx-auto -->
                        </div>
                        <br>

                        <div>
                            <h5 style="font-weight: bold; text-align: center">Funkcjonalności</h5>
                            <ul>
                                <li style="margin-bottom: 1%;"><b>Rejestracja i Logowanie:</b> Zarejestruj się, aby uzyskać pełny dostęp do naszych narzędzi analitycznych. Już masz konto? Zaloguj się, aby kontynuować.</li>
                                <li style="margin-bottom: 1%;"><b>Wybór Miasta:</b> Skorzystaj z formularza, aby wybrać interesujące Cię miasto.</li>
                                <li style="margin-bottom: 1%;"><b>Kategoria Rynku:</b> Wybierz, czy interesuje Cię rynek pierwotny czy wtórny.</li>
                                <li style="margin-bottom: 1%;"><b>Okres Analizy:</b> Określ przedział czasowy, który chcesz analizować.</li>
                                <li style="margin-bottom: 1%;"><b>Rodzaj Stóp Procentowych:</b> Wybierz rodzaj stóp procentowych, które chcesz uwzględnić w swojej analizie.</li>
                                <li style="margin-bottom: 1%;"><b>Generowanie wykresu:</b> Wygeneruj wykres bazujący na wybranych danych.</li>
                                <li style="margin-bottom: 1%;"><b>Zapisz jako JPEG/PNG:</b> Zapisz wygenerowany wykres jako obrazek.</li>
                                <li style="margin-bottom: 1%;"><b>Eksport jako JSON:</b> Wyeksportuj wybrane dane w formacie JSON.</li>
                                <li style="margin-bottom: 1%;"><b>Eksport jako XML:</b> Wyeksportuj wybrane dane w formacie XML.</li>
                            </ul>
                            <br>
                        </div>

                        <div class="alert alert-info text-center mt-3" role="alert">
                            <small>
                                <b>Uwaga:</b> Niezalogowani użytkownicy mogą wypełnić formularz, ale nie mogą generować wykresy.
                            </small>
                        </div>
                        <form action="{{ route('chart') }}" method="GET" id="chartForm">
                            @csrf

                            <h5 style="font-weight: bold; text-align: center">Wypełnij formularz</h5>
                            <div class="mb-3">
                                <label for="city" class="form-label">Wybierz miasto:</label>
                                <select name="city" id="city" class="form-select">
                                    @php
                                        $cities = ["-- Nie wybrano --", "Białystok", "Bydgoszcz", "Gdańsk", "Gdynia", "Katowice", "Kielce", "Kraków", "Lublin", "Łódź", "Olsztyn", "Opole", "Poznań", "Rzeszów", "Szczecin", "Warszawa", "Wrocław", "Zielona Góra", "6 miast bez Warszawy", "7 miast", "9 miast", "10 miast", "Gdynia*"];
                                    @endphp
                                    @foreach ($cities as $city)
                                        <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="from" class="form-label">Od:</label>
                                    <input type="date" name="from" id="from" value="{{ old('from') }}" required class="form-control" min="2006-01-01" max="2024-12-31">
                                    @error('from')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="to" class="form-label">Do:</label>
                                    <input type="date" name="to" id="to" value="{{ old('to') }}" required class="form-control" min="2006-01-01" max="2024-12-31">
                                    @error('to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Wybierz kategorię:</label>
                                <select name="category" id="category" class="form-select">
                                    @php
                                        $categories = ["-- Nie wybrano --", "Rynek pierwotny(oferta)", "Rynek pierwotny(tranzakcja)", "Rynek wtórny (oferta)", "Rynek wtórny (tranzakcja)"];
                                    @endphp
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                                <div class="mb-3">
                                    <label for="stopTypes" class="form-label">Wybierz rodzaj stóp procentowych:</label>
                                    <select name="stopTypes" id="stopTypes" class="form-select">
                                        @php
                                            $stopTypes = ["-- Nie wybrano --", "ref", "lom", "dep", "red", "dys"];
                                        @endphp
                                        @foreach ($stopTypes as $stopType)
                                            <option value="{{ $stopType }}" {{ old('stopTypes') == $stopType ? 'selected' : '' }}>{{ $stopType }}</option>
                                        @endforeach
                                    </select>
                                    @error('stopTypes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary">{{ __('Generuj Wykres') }}</button>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>



                    @push('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('chartForm').addEventListener('submit', function(event) {
                                        let city = document.getElementById('city').value;
                                        let category = document.getElementById('category').value;
                                        let stopTypes = document.getElementById('stopTypes').value;
                                        let fromDate = document.getElementById('from').value;
                                        let toDate = document.getElementById('to').value;
                                        let fromYear = new Date(fromDate).getFullYear();
                                        let toYear = new Date(toDate).getFullYear();

                                        var message = "";

                                        if (city === "-- Nie wybrano --") {
                                            event.preventDefault();
                                            message += "Proszę wybrać miasto.\n";
                                            document.getElementById('city').classList.add('is-invalid');
                                        } else {
                                            document.getElementById('city').classList.remove('is-invalid');
                                        }

                                        if (category === "-- Nie wybrano --") {
                                            event.preventDefault();
                                            message += "Proszę wybrać kategorię.\n";
                                            document.getElementById('category').classList.add('is-invalid');
                                        } else {
                                            document.getElementById('category').classList.remove('is-invalid');
                                        }

                                        if (fromDate === '' || toDate === '') {
                                            event.preventDefault();
                                            message += "Proszę wybrać datę.\n";
                                            document.getElementById('from').classList.add('is-invalid');
                                            document.getElementById('to').classList.add('is-invalid');


                                        } else {
                                            document.getElementById('from').classList.remove('is-invalid');
                                            document.getElementById('to').classList.remove('is-invalid');
                                        }

                                        if (stopTypes === "-- Nie wybrano --") {
                                            event.preventDefault();
                                            message += "Proszę wybrać rodzaj stóp procentowych.\n";
                                            document.getElementById('stopTypes').classList.add('is-invalid');
                                        } else {
                                            document.getElementById('stopTypes').classList.remove('is-invalid');
                                        }

                                        if (fromYear < 2006 || fromYear > 2024 || toYear < 2006 || toYear > 2024) {
                                            event.preventDefault();
                                            message += "Rok daty powinien być z zakresu od 2006 do 2024.\n";
                                            document.getElementById('from').classList.add('is-invalid');
                                            document.getElementById('to').classList.add('is-invalid');
                                        } else {
                                            document.getElementById('from').classList.remove('is-invalid');
                                            document.getElementById('to').classList.remove('is-invalid');
                                        }

                                        if (fromYear >= toYear) {
                                            event.preventDefault();
                                            message += "Proszę wybrać właściwy rok (np. od 2006 do 2024).\n";
                                            document.getElementById('from').classList.add('is-invalid');
                                            document.getElementById('to').classList.add('is-invalid');
                                        } else {
                                            document.getElementById('from').classList.remove('is-invalid');
                                            document.getElementById('to').classList.remove('is-invalid');
                                        }


                                        if (message !== "") {
                                            event.preventDefault();
                                            let errorMessage = document.createElement('div');
                                            errorMessage.className = 'alert alert-danger';
                                            errorMessage.innerHTML = '<ul><li>' + message.trim().split('\n').join('</li><li>') + '</li></ul>';
                                            document.getElementById('chartForm').prepend(errorMessage);
                                        }

                                    });
                                });
                            </script>
                        @endpush
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
@endsection


@section('footer')
    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            <span class="text-muted">© 2024 Zestawienie Danych. Wszelkie prawa zastrzeżone.</span>
        </div>
    </footer>
@endsection

