<?php

namespace DoubleDeuce\Itau;

use Exception;
use DoubleDeuce\ConfigField;
use DoubleDeuce\Data\Person;
use DoubleDeuce\RemessaConfig;
use DoubleDeuce\Traits\FormatRemessaData;
use DoubleDeuce\RemessaFileHeaderAbstract;

class ItauFileHeader extends RemessaFileHeaderAbstract implements RemessaConfig
{
    use FormatRemessaData;

    // Fixed
    private $bankCode = '341';
    private $lote = 0;
    private $type = 0;
    private $layoutVersion = '081';
    private $bankName = 'ITAU';
    private $fileCode = '1';
    private $zeros = 0;
    private $densityUnit = '01600';
    private $blanks1 = '';
    private $blanks2 = '';
    private $blanks3 = '';
    private $blanks4 = '';
    private $blanks5 = '';
    private $blanks6 = '';

    public function __construct(Person $company)
    {
        $this->documentType = $company->documentType;
        $this->documentNumber = $company->documentNumber;
        $this->agency = $company->agency;
        $this->account = $company->account;
        $this->dac = $company->accountDigit;
        $this->companyName = $company->name;
        $this->createdDate = date('dmY');
        $this->createdTime = date('His');
    }

    public function getSequence(): array
    {
        return [
            new ConfigField($this, 'bankCode', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'lote', 4, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'type', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blanks1', 6, ConfigField::TYPE_STRING),
            new ConfigField($this, 'layoutVersion', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'documentType', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'documentNumber', 14, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blanks2', 20, ConfigField::TYPE_STRING),
            new ConfigField($this, 'agency', 5, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blanks3', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'account', 12, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blanks4', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'dac', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'companyName', 30, ConfigField::TYPE_STRING),
            new ConfigField($this, 'bankName', 30, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blanks5', 10, ConfigField::TYPE_STRING),
            new ConfigField($this, 'fileCode', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'createdDate', 8, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'createdTime', 6, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'zeros', 9, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'densityUnit', 5, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blanks6', 69, ConfigField::TYPE_STRING),
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
