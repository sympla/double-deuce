<?php

namespace DoubleDeuce\Itau;

use DoubleDeuce\ConfigField;
use DoubleDeuce\RemessaConfig;
use DoubleDeuce\Traits\FormatRemessaData;
use DoubleDeuce\RemessaFooterFileAbstract;

class ItauFooterFile extends RemessaFooterFileAbstract implements RemessaConfig
{
    use FormatRemessaData;

    private $bankCode = '341';
    private $loteCode = '9999';
    private $registerType = '9';
    private $lotes = '000001';
    private $blank1 = '';
    private $blank2 = '';

    public function __construct()
    {
    }

    public function setTotalRegisters(int $totalRegisters)
    {
        $this->registers = $totalRegisters;
    }

    public function getSequence(): array
    {
        return [
            new ConfigField($this, 'bankCode', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'loteCode', 4, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'registerType', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blank1', 9, ConfigField::TYPE_STRING),
            new ConfigField($this, 'lotes', 6, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'registers', 6, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'blank2', 211, ConfigField::TYPE_STRING),
        ];
    }

    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
        throw new \Exception("Cannot access private property $name");
    }
}
