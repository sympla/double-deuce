<?php

namespace Tests\Fixtures;

use DoubleDeuce\Data\Person;
use DoubleDeuce\Data\Address;
use DoubleDeuce\Data\BankAccount;
use DoubleDeuce\Data\IdentifyDocument;
use DoubleDeuce\Itau\ItauSegmentA;
use DoubleDeuce\Itau\ItauSegmentB;

class Elements
{
    public function createFavored()
    {
        $favoredBank = 1;
        $favoredAgency = 3333;
        $favoredAccount = 77777;
        $favoredAccountDigit = 'X';
        $favoredAddress = 'RUA DAS MAZELASALVAS';
        $favoredAddressNumber = 999;
        $favoredAddressDistrict = 'BAIRRO DO ALTO';
        $favoredAddressCity = 'SAO JOSE DOS CAMPOS';
        $favoredAddressCep = '03500000';
        $favoredAddressUF = 'SP';
        $favoredName = 'TESTE PRODUCOES LTDA ME';
        $favoredCpfOrCnpj = 76375529000151;
        

        $bankAccount = new BankAccount(
            $favoredBank,
            $favoredAgency,
            $favoredAccount,
            $favoredAccountDigit
        );

        $addressObj = new Address(
            $favoredAddress,
            $favoredAddressNumber, 
            $favoredAddressDistrict,
            $favoredAddressCity,
            $favoredAddressCep,
            $favoredAddressUF
        );


        $identifyDocument = new IdentifyDocument(
            $favoredName,
            $favoredCpfOrCnpj
        );

        $favored = new Person(
            $identifyDocument,
            $addressObj,
            $bankAccount
        );

        return $favored;
    }

    public function createCompany()
    {
        $companyName = "CAIXA DAGUA COM SOLUCOES SA";
        $documentNumber = 84554035000162;
        $bank = 341;
        $agency = 9999;
        $account = 4484;
        $dac = '7';
        $addressComplement = '10 ANDAR';
        $companyAddress = "RUA JOAO DO ALTO NOBRE";
        $companyAddressNumber = 891;
        $companyDistrict = "SAVASSI";
        $companyCity = "BELO HORIZONTE";
        $companyCEP = "30111000";
        $companyUF = "MG";

        $identifyDocument = new IdentifyDocument(
            $companyName,
            $documentNumber
        );

        $addressObj = new Address(
            $companyAddress,
            $companyAddressNumber, 
            $companyDistrict,
            $companyCity,
            $companyCEP,
            $companyUF,
            $addressComplement
        );

        $bankAccount = new BankAccount(
            $bank,
            $agency,
            $account,
            $dac
        );

        $company = new Person(
            $identifyDocument,
            $addressObj,
            $bankAccount
        );
        
        return $company;
    }

    public function createSegmentAData()
    {
        $valueToPay = 122018.40;
        $identification = '70973FCH1';
        $favored = $this->createFavored();

        return new ItauSegmentA(
            $favored,
            $valueToPay,
            $identification
        );
    }

    public function createSegmentBData()
    {
        $favored = $this->createFavored();
        return new ItauSegmentB($favored);
    }
}