<?php

namespace DoubleDeuce\Itau;

use DoubleDeuce\ConfigField;
use Exception;
use DoubleDeuce\Data\Person;
use DoubleDeuce\RemessaConfig;
use DoubleDeuce\SegmentA;
use DoubleDeuce\Traits\FormatRemessaData;

class ItauSegmentA extends SegmentA implements RemessaConfig
{
    use FormatRemessaData;

    //fixed
    private $bankCode = '341';
    private $loteCode = 1;
    private $loteDetail = '3';
    private $type = 0;
    private $zeros1 = 0;
    private $moneyType = 'REA';
    private $zeros2 = 0;
    private $returnDocNumber = 0;
    private $advice = 0;
    private $payDate;
    private $registerComplement = '100010';
    private $identificationType = 0;
    private $paidDate = 0;
    private $paidValue = 0;
    private $blankAfterAgency = '';
    private $blankAfterAccount = '';
    private $ourNumber = '';
    private $blank1 = '';
    private $taxNumber = '';
    private $blank2 = '';
    private $ocurrency = '';

    //variable
    private $favoredBank;
    private $favoredAgency;
    private $favoredAccount;
    private $favoredAccountDigit;
    private $favoredName;
    private $favoredCpfOrCnpj;
    private $favoredIdentification;
    private $valueToPay;
    private $segment;
    
    //private $loteSequence = '00001'; //segment incremental

    public function __construct(
        Person $favored = null,
        float $valueToPay = null,
        string $identification = ''
    ) {
        if (!empty($favored)) {
            $this->favoredBank = $favored->bank;
            $this->favoredAgency = $favored->agency;
            $this->favoredAccount = $favored->account;
            $this->favoredAccountDigit = $favored->accountDigit;
            $this->favoredName = $favored->name;
            $this->favoredCpfOrCnpj = $favored->documentNumber;
        }
        
        if (!empty($valueToPay)) {
            $this->valueToPay = (int)(round($valueToPay, 2) * 100);
            $this->payDate = date('dmY');
        }

        if (!empty($identification)) {
            $this->favoredIdentification = $identification;
        }
        
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
            new ConfigField($this, 'type', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'zeros1', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'favoredBank', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'favoredAgency', 5, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blankAfterAgency', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredAccount', 12, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blankAfterAccount', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredAccountDigit', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredName', 30, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredIdentification', 20, ConfigField::TYPE_STRING),
            new ConfigField($this, 'payDate', 8, ConfigField::TYPE_STRING),
            new ConfigField($this, 'moneyType', 3, ConfigField::TYPE_STRING),
            new ConfigField($this, 'zeros2', 15, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'valueToPay', 15, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'ourNumber', 15, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blank1', 5, ConfigField::TYPE_STRING),
            new ConfigField($this, 'paidDate', 8, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'paidValue', 15, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'taxNumber', 14, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blank2', 6, ConfigField::TYPE_STRING),
            new ConfigField($this, 'returnDocNumber', 6, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'favoredCpfOrCnpj', 14, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'identificationType', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'registerComplement', 11, ConfigField::TYPE_STRING),
            new ConfigField($this, 'advice', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'ocurrency', 10, ConfigField::TYPE_STRING),
        ];
    }

    public function __get($name)
    {
        if (property_exists(self::class, $name)) {
            return $this->{$name};
        }
        throw new Exception("Cannot access property $name");
    }
}
