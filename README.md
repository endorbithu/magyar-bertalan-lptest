# Magyar Bertalan LP teszt feladat

## Áttekintés

Egy-oldalas alkalmazás, amellyel LP-ket lehet listázni és rögzíteni,
és egy időben Szerzőt és Kiadót hozzákapcsolni/hozzáadni a feltöltendő LP-hez.

## Környezet

- Linux (ubuntu)
- Apache 2.4
- Composer 2
- PHP 8
- MySql 8

## Install

- `.env` létrehozása `.env.example` alapján
- `composer install`
- `php artisan key:generate`
- `php artisan migrate`

## Backend

- Laravel 9 framework
- Eloquent ORM

### DB struktúra

#### Táblák

- lps
    - `name | label_id (FK) | published_on | created_at | updated_at`
- composers
    - `name (idx) | created_at | updated_at`
- composer_lp (kapcsolótábla)
    - `composer_id (FK) | lp_id (FK)`
- labels
    - `name (idx) | created_at | updated_at`
- lp_flats (flat tábla lp-hez, nagy )
    - `name (idx) | published_on | label | composers | created_at | updated_at`
    - Mivel a rendszernek tudnia kell nagy mennyiségű adatot listáznia, ezért egy flat táblában is le vannak tárolva az
      LP-k
      a hatékonyabb listázás érdekében. Ezt százezres-milliós nagyságrendtől
      lehet Elasticsearch stb. jól skálázható, gyorsabb, index alapú motorokkal szinkroznizálni, és ezt a motort
      használni keresés/listázás célra.
    - Az `lp_flats` tábla realtime szinkronban van a `lps` táblával Eloquent entity observer segítségével,
      ebből is következik, hogy a `lps` CRUD műveleteknek az Eloquent ORM-en belül kell maradniuk.

#### Indexek

- labels.name
    - select2.js-nél a névre keresünk rá.
- composer.name
    - select2.js-nél a névre keresünk rá.
- lp_flats.name
    - `name` szerinti rendezés merült fel, ehhez lett beállítva index

### Controller, végpontok

Az "egy-oldal" a gyökér '/' route alatt érhető el, amelyet az `LpController::lps()` action metódus szolgál ki.  
Új LP hozzáadásánál a `<form action=` is a gyökér '/' route-ra mutat, csak POST HTTP method-dal,
így annak külön action-je van a controllerben, de feldolgozás után visszanavigál a GET '/' route-ra státusz üzenettel.

#### API végpontok

- /api/label
- /api/composer

Ezek a select2.js container-eket szolgálják ki AJAX hívás útján.
Név alapján tudunk keresni ezekre az entitásokra, és mivel az ID-t is lekérjük, hozzá tudjuk adni a formhoz az LP-hez
kapcsolva.

### Contracts, Services

Az implementációs függés csökkentése érdekében nem példányosítunk közvetlenül Service osztályt, hanem a Contracts-ban
határozzuk meg
mit várunk az egyes Service-ktől, és ezeket a Interface-eket az `AppServiceProvider`-ben kapcsoljuk össze a konkrét
service osztályokkal,és a laravel DI container `app(Contracts\AnInterface::class)` keresztül példányosítjuk a
meghatározott
service-t. így a konkrét service osztályoktól nem fogunk függeni.

- `LpSaveInstantInterface`
    - LP rögzítése és a hozzátartozó composer(ek) + label létrehozása és/vagy hozzákapcsolása.
- `Select2ServiceInterface`
    - A `select2.js` containert kiszolgáló service, melynek a `getResultsForApi()` metódusa keresőszó inputra
      => `ID, name` találatokat ad vissza formázottan a select.js számára.

### Observerek

`LpObserver` observer van hozzákapcsolva az `Lp` eloquent model CRUD eseményeire az `EventServiceProvider`-ben.
Ez felelős azért, hogy szinkronban tartsa az `lp_flats` táblával.

### Hibakezelés

A Laravel built-in hibakezelési mechanizmusokon túl, egy új `Exception` lett bevezetve: `StatusBarExcetion`, ha ezt
dobjuk fel, annál az esetnél a Laravel Handler.php ban beállított
módon visszairányít az előző oldalra, és a blade fájlokban globálisan elérhető `$errors` változóba be lesz állítva ennek
az exceptionnek a  
`$exception->getMessage()` -je, és az oldal a status barban ki is írja a hibát.

## Frontend

- Bootstrap JS
- Select2.js
