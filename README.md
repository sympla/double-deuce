# sympla/double-deuce

>  New York City by Frank Tilghman to take over security at his club/bar, the Double Deuce, in Jasper, Missouri. Tilghman plans to invest substantial money into the club to enhance its image and needs a first-rate cooler to maintain stability.
> - It's a good night. Nobody died

This library helps to create Remessa file to Banks and Read Return file from Banks.

## Installation

Install the package using composer:

    $ composer require sympla/double-deuce ~1.0

That's it.

## Usage

The banks need a file in a format cnab. With the Person data like
Identify Document, Address and Bank Account
the library can create a file in right format to process

```php
<?php

require_once "vendor/autoload.php";

use DoubleDeuce\RemessaExport;
use DoubleDeuce\Itau;
use DoubleDeuce\Data;

// create person identities
$company = createCompany();
$favored1 = createFavored1();
$favored2 = createFavored2();
$segments = [];

//create each segment intance
$itauFileHeader = new Itau\ItauFileHeader($company);
$itauHeader = new Itau\ItauHeader($company, "LOTE PARA PAGAMENTO");
$segments[] = new Itau\ItauSegmentA($favored1, 2250.55);
$segments[] = new Itau\ItauSegmentB($favored1);
$segments[] = new Itau\ItauSegmentA($favored2, 127895.77, "ID 10 PAGAMENTO");
$segments[] = new Itau\ItauSegmentB($favored2);

//export data in right format
$export = new RemessaExport(
    new Itau\ItauRemessa,
    $itauFileHeader,
    $itauHeader,
    new Itau\ItauFooter,
    new Itau\ItauFooterFile,
    ... array_values($segments)
);
$dataFile = $export->toString();
file_put_contents('remessa_itau.txt', $dataFile);
```

### example to create a person like above createCompany() or createFavored1()

```php
<?php

require_once "vendor/autoload.php";

use Sympla\DoubleDeuce\Data;

//It is the same proccess to createCompany() 
function createFavored() {
    //create identity
    $favoredIdenty = new Data\IdentifyDocument("Jhon Doe", "99028359028");

    //create address
    $favoredAddress = new Data\Address(
        "Rua comum",
        1245,
        "São Bento",
        "Betim",
        "31200000",
        "MG"
    );

    //create bank account
    $favoredBank = new Data\BankAccount(70, 1, 69875, "9");

    //create a Person
    $favored = new Data\Person($favoredIdenty, $favoredAddress, $favoredBank);
}

```

## Read Return File

```php
<?php

use DoubleDeuce\Itau\ItauSegmentA;
use DoubleDeuce\Itau\ItauSegmentZ;
use DoubleDeuce\ReadReturn;

require_once "vendor/autoload.php";

    //load file as string
    file = file_get_contents(__dir__ . 'RETURN_ITAU.txt');

    //set file and segments to read return 
    $readReturn =  new ReadReturn($file, new ItauSegmentA(), new ItauSegmentZ());

    //can read one or many segments
    $readReturn2 =  new ReadReturn($file, new ItauSegmentA());

    //bring all segments in array format
    var_dump($readReturn->getReturnData());
    var_dump($readReturn2->getReturnData());

```

## More examples

There is more detailed example in [examples](examples path)

## Contact

Fabrício Cunha <baricio@gmail.com>

## License

This project is distributed under the MIT License. Check [LICENSE][LICENSE.md] for more information.