<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>REST API</title>

    <style>
        .method {
            color: white;
            font-weight: bold;
            background-color: #007bff;
            width: 82px;
            text-align: center
        }

        .showDetails {
            color: blue;
            float: right;
            cursor: pointer;
        }

        .details {
            display: none;
            margin-top: 10px;
        }

        textarea {
            color: #e83e8c;
            min-height: 95px;
            width: 100%;
            overflow: hidden;
            padding: 5px;
            font-size: 0.75rem;
            resize: none;
            border: none;
            outline: none;
            font-family: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
        }

        h1{
            margin: 15px 0 15px 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="/">REST API</a>
    </nav>

    <div class="container">
        <h1>Dostępne metody</h1>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Metoda</th>
                    <th scope="col" style="width: 250px">URL</th>
                    <th scope="col">Opis</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="method">GET</td>
                    <td>/api/v1/persons</td>
                    <td>
                        <div>Wyświetlenie wszystkich rekordów z tabeli w formacie JSON.</div>
                    </td>
                </tr>
                <tr>
                    <td class="method" style="background-color: green">POST</td>
                    <td>/api/v1/persons</td>
                    <td>
                        <div>Dodanie nowego rekordu. <span id="1_content" class="showDetails">Więcej</span></div>
                        <div id="1_content_details" class="details">
                            <div>Dane wejściowe:</div>
                            <textarea class="data" readonly></textarea>
                            <div>Odpowiedź:</div>
                            <textarea class="answer" readonly></textarea>
                            <div>Identyfikator reokrdu zwracany jest jeżeli status = true.</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="method">GET</td>
                    <td>/api/v1/persons/{id}</td>
                    <td>
                        <div>Wyświetlenie pojedynczego rekordu. <span id="2_content" class="showDetails">Więcej</span>
                        </div>
                        <div id="2_content_details" class="details">
                            <div>W adresie URL w miejsce {id} należy wstawić identyfikator rekordu.</div>
                            <div>Odpowiedź (rekord znaleziony):</div>
                            <textarea class="answerTrue" readonly></textarea>
                            <div>Odpowiedź (brak rekordu):</div>
                            <textarea class="answerFalse" readonly></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="method" style="background-color: orange">PUT</td>
                    <td>/api/v1/persons/{id}</td>
                    <td>
                        <div>Aktualizacja rekordu. <span id="3_content" class="showDetails">Więcej</span></div>
                        <div id="3_content_details" class="details">
                            <div>W adresie URL w miejsce {id} należy wstawić identyfikator rekordu.</div>
                            <div>Dane wejściowe:</div>
                            <textarea class="data" readonly></textarea>
                            <div>Odpowiedź:</div>
                            <textarea class="answer" readonly></textarea>
                            <div>Identyfikator reokrdu zwracany jest jeżeli status = true.</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="method" style="background-color: red;">DELETE</td>
                    <td>/api/v1/persons/{id}</td>
                    <td>
                        <div>Usunięcie rekordu. <span id="4_content" class="showDetails">Więcej</span></div>
                        <div id="4_content_details" class="details">
                            <div>W adresie URL w miejsce {id} należy wstawić identyfikator rekordu.</div>
                            <div>Odpowiedź:</div>
                            <textarea class="answer" readonly></textarea>
                            <div>Identyfikator reokrdu zwracany jest jeżeli status = true.</div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <script>
        $(".showDetails").click(function(event) {
            $("#" + event.target.id + "_details").toggle();
            $(this).text($(this).text() == 'Więcej' ? 'Ukryj' : 'Więcej');
        });

        var data = {
            "name": "Imie",
            "surname": "Nazwisko"
        };

        var data = JSON.stringify(data, undefined, 4);

        $(".data").text(data);

        var answer = {
            "id": "Identyfikator rekordu",
            "status": "true/false",
            "msg": "Powiadomienie tekstowe"
        };
        var answer = JSON.stringify(answer, undefined, 4);
        $(".answer").text(answer);

        var answerTrue = {
            "id": "Identyfikator rekordu",
            "name": "Imie",
            "surname": "Nazwisko"
        };
        var answerTrue = JSON.stringify(answerTrue, undefined, 4);
        $(".answerTrue").text(answerTrue);

        var answerFalse = {
            "status": "false",
            "msg": "Powiadomienie tekstowe"
        };
        var answerFalse = JSON.stringify(answerFalse, undefined, 4);
        $(".answerFalse").text(answerFalse);
    </script>
</body>

</html>
