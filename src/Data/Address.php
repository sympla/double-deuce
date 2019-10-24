<?php

namespace DoubleDeuce\Data;

class Address
{
    public $address;
    public $number;
    public $complement = '';
    public $district;
    public $city;
    public $zipCode;
    public $uf;

    public function __construct(
        string $address,
        int $number,
        string $district,
        string $city,
        string $zipCode,
        string $uf,
        string $complement = ''
    ) {
        $this->address = $address;
        $this->number = $number;
        $this->district = $district;
        $this->city = $city;
        $this->zipCode = $zipCode;
        $this->uf = $uf;
        $this->complement = $complement;
    }
}
