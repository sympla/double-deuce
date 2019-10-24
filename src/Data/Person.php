<?php

namespace DoubleDeuce\Data;

class Person
{
    public function __construct(
        IdentifyDocument $identifyDocument,
        Address $address,
        BankAccount $bankAccount
    ) {
        $this->name = $identifyDocument->name;
        $this->documentType = $identifyDocument->type;
        $this->documentNumber = $identifyDocument->number;
        $this->bank = $bankAccount->bank;
        $this->agency = $bankAccount->agency;
        $this->account = $bankAccount->account;
        $this->accountDigit = $bankAccount->digit;
        $this->address = $address->address;
        $this->addressNumber = $address->number;
        $this->addressDistrict = $address->district;
        $this->addressComplement = $address->complement;
        $this->city = $address->city;
        $this->cep = $address->zipCode;
        $this->uf  = $address->uf;
    }
}
