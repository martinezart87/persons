# REST API

Przykładowe API, za pomocą którego można wykonać operacje na tabeli persons. Tabela składa się z trzech kolumn: id, name, surname.

API udostępnia następujące operacje: 
- odczyt wszystkich rekordów 
- dodanie nowego rekordu
- aktualizacja istniejącego rekordu
- odczyt rekordu 
- usunięcie rekordu 

API wykonano z wykorzystaniem:
- PHP 7.4
- Lumen micro-framework
- SQLite

## Demo i dokumentacja

http://mswierczek.sldc.pl/


## Lokalne uruchomienie

Aby przetestować API lokalnie, wystarczy pobrać cały projekt i przy użyciu konsoli wykonać polecenie uruchamiające serwer: 

php -S localhost:8000 -t public
