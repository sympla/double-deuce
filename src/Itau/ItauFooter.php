<?php

namespace DoubleDeuce\Itau;

use Exception;
use DoubleDeuce\ConfigField;
use DoubleDeuce\RemessaConfig;
use DoubleDeuce\RemessaFooterAbstract;
use DoubleDeuce\Traits\FormatRemessaData;

class ItauFooter extends RemessaFooterAbstract implements RemessaConfig
{
    use FormatRemessaData;

    private $bankCode = '341';
    private $loteCode = '0001';
    private $footerLoteCode = '5';
    private $blank1 = '';
    private $zeros = 0;
    private $blank2 = '';
    private $ocurrencies = '';

    public function setTotalSegments(int $totalSegments)
    {
        $this->totalSegments = $totalSegments;
    }

    public function setTotalToPay(int $totalToPay)
    {
        $this->totalToPay = $totalToPay;
    }

    public function getSequence(): array
    {
        return [
            new ConfigField($this, 'bankCode', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'loteCode', 4, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'footerLoteCode', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blank1', 9, ConfigField::TYPE_STRING),
            new ConfigField($this, 'totalSegments', 6, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'totalToPay', 18, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'zeros', 18, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blank2', 171, ConfigField::TYPE_STRING),
            new ConfigField($this, 'ocurrencies', 10, ConfigField::TYPE_STRING),
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
