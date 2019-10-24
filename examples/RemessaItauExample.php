<?php

namespace Examples;

require_once __dir__ . '/../vendor/autoload.php';

use DoubleDeuce\RemessaExport;
use DoubleDeuce\Itau;
use DoubleDeuce\Data;

class RemessaItauExample
{
    public function createRemessa()
    {
        // create person identities
        $company = $this->createCompany();
        $favored1 = $this->createFavored1();
        $favored2 = $this->createFavored2();
        $segments = [];

        //create each segment intance
        $itauFileHeader = new Itau\ItauFileHeader($company);
        $itauHeader = new Itau\ItauHeader($company, "LOTE PARA PAGAMENTO");
        $segments[] = new Itau\ItauSegmentA($favored1, 2250.55);
        $segments[] = new Itau\ItauSegmentB($favored1);
        $segments[] = new Itau\ItauSegmentA($favored2, 127895.77, "hara");
        $segments[] = new Itau\ItauSegmentB($favored2);

        $export = new RemessaExport(
            new Itau\ItauRemessa,
            $itauFileHeader,
            $itauHeader,
            new Itau\ItauFooter,
            new Itau\ItauFooterFile,
            ... array_values($segments)
        );
        echo $export->toString();
        \file_put_contents('remessa_itau.txt', $export->toString());
    }

    private function createCompany()
    {
        $companyIdenty = new Data\IdentifyDocument("Super empresa LTDA", "55997571000134");

        $companyAdress = new Data\Address(
            "Rua numero um",
            2558,
            "Savassi",
            "Belo Horizonte",
            "30200000",
            "MG",
            "10 andar"
        );

        $companyBank = new Data\BankAccount(341, 1234, 10012, "5");

        $company = new Data\Person($companyIdenty, $companyAdress, $companyBank);

        return $company;

    }

    private function createFavored1()
    {
        $favoredIdenty = new Data\IdentifyDocument("Jhon Doe", "99028359028");

        $favoredAddress = new Data\Address(
            "Rua comum",
            1245,
            "São Bento",
            "Betim",
            "31200000",
            "MG"
        );

        $favoredBank = new Data\BankAccount(70, 1, 69875, "9");

        $favored = new Data\Person($favoredIdenty, $favoredAddress, $favoredBank);

        return $favored;
    }

    private function createFavored2()
    {
        $favoredIdenty = new Data\IdentifyDocument("Nathanael Lito", "66191569084");

        $favoredAddress = new Data\Address(
            "Av Gavião",
            555,
            "Bairro Delongue",
            "Contagem",
            "32113000",
            "MG",
            "Apto 204"
        );

        $favoredBank = new Data\BankAccount(1, 3654, 98741, "6");

        $favored = new Data\Person($favoredIdenty, $favoredAddress, $favoredBank);

        return $favored;
    }
}

$example = new RemessaItauExample();
$example->createRemessa();