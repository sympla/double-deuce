<?php

namespace DoubleDeuce\Itau;

use Exception;
use DoubleDeuce\SegmentB;
use DoubleDeuce\ConfigField;
use DoubleDeuce\Data\Person;
use DoubleDeuce\RemessaConfig;
use DoubleDeuce\Traits\FormatRemessaData;

class ItauSegmentB extends SegmentB implements RemessaConfig
{
    use FormatRemessaData;

    //fixed
    private $bankCode = '341';
    private $loteCode = 1;
    private $loteDetail = '3';
    private $blank1 = '';
    private $favoredEmail = '';
    private $blank2 = '';
    private $blank3 = '';

    //private $loteSequence = '00001'; //segment incremental

    public function __construct(
        Person $favored
    ) {
        $this->documentType = $favored->documentType;
        $this->documentNumber = $favored->documentNumber;
        $this->favoredAddress = $favored->address;
        $this->favoredAddressNumber = $favored->addressNumber;
        $this->favoredAddressComplement = $favored->addressComplement;
        $this->favoredAddressDistrict = $favored->addressDistrict;
        $this->favoredAddressCity = $favored->city;
        $this->favoredAddressCep = $favored->cep;
        $this->favoredAddressUF = $favored->uf;
        $this->segment = $this->getSegmentType();
    }

    public function getSequence(): array
    {
        return [
            new ConfigField($this, 'bankCode', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'loteCode', 4, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'loteDetail', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'getOrder()', 5, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'segment', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blank1', 3, ConfigField::TYPE_STRING),
            new ConfigField($this, 'documentType', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'documentNumber', 14, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'favoredAddress', 30, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredAddressNumber', 5, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'favoredAddressComplement', 15, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredAddressDistrict', 15, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredAddressCity', 20, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredAddressCep', 8, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'favoredAddressUF', 2, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredEmail', 100, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blank2', 3, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blank3', 10, ConfigField::TYPE_STRING)
        ];
    }

    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
        throw new Exception("Cannot access property $name");
    }
}
