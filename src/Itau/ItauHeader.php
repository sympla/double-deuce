<?php

namespace DoubleDeuce\Itau;

use Exception;
use DoubleDeuce\ConfigField;
use DoubleDeuce\Data\Person;
use DoubleDeuce\RemessaConfig;
use DoubleDeuce\RemessaHeaderAbstract;
use DoubleDeuce\Traits\FormatRemessaData;

class ItauHeader extends RemessaHeaderAbstract implements RemessaConfig
{
    use FormatRemessaData;

    //class controll
    private $bankCode = '341';
    private $typeHeader = '1';
    private $typeOperation = 'C';
    private $lote = '0001';
    private $typePayment = '20';
    private $paymentOption = '41';
    private $loteLayout = '040';
    private $blanks1 = '';
    private $blanks2 = '';
    private $blanks3 = '';
    private $blanks4 = '';
    private $blanks5 = '';
    private $releaseIdentification = '';
    private $ccHistory = '';
    private $occurrence = '';

    public function __construct(
        Person $company,
        string $loteResponsability
    ) {
        $this->loteResponsability = $loteResponsability;
        $this->documentType = $company->documentType;
        $this->documentNumber = $company->documentNumber;
        $this->agency = $company->agency;
        $this->account = $company->account;
        $this->dac = $company->accountDigit;
        $this->companyName = $company->name;
        $this->companyAddress = $company->address;
        $this->companyAddressNumber = $company->addressNumber;
        $this->companyAddressComplement = $company->addressComplement;
        $this->companyCity = $company->city;
        $this->companyCEP = $company->cep;
        $this->companyUF = $company->uf;
    }

    public function getSequence(): array
    {
        return [
            new ConfigField($this, 'bankCode', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'lote', 4, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'typeHeader', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'typeOperation', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'typePayment', 2, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'paymentOption', 2, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'loteLayout', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blanks1', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'documentType', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'documentNumber', 14, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'releaseIdentification', 4, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blanks2', 16, ConfigField::TYPE_STRING),
            new ConfigField($this, 'agency', 5, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blanks3', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'account', 12, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blanks4', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'dac', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'companyName', 30, ConfigField::TYPE_STRING),
            new ConfigField($this, 'loteResponsability', 30, ConfigField::TYPE_STRING),
            new ConfigField($this, 'ccHistory', 10, ConfigField::TYPE_STRING),
            new ConfigField($this, 'companyAddress', 30, ConfigField::TYPE_STRING),
            new ConfigField($this, 'companyAddressNumber', 5, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'companyAddressComplement', 15, ConfigField::TYPE_STRING),
            new ConfigField($this, 'companyCity', 20, ConfigField::TYPE_STRING),
            new ConfigField($this, 'companyCEP', 8, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'companyUF', 2, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blanks5', 8, ConfigField::TYPE_STRING),
            new ConfigField($this, 'occurrence', 10, ConfigField::TYPE_STRING),
        ];
    }

    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
        throw new Exception("Cannot access private property $name");
    }
}
