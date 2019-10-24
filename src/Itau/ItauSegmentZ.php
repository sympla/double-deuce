<?php

namespace DoubleDeuce\Itau;

use DoubleDeuce\SegmentZ;
use DoubleDeuce\ConfigField;
use DoubleDeuce\RemessaConfig;

class ItauSegmentZ extends SegmentZ implements RemessaConfig
{

    private $bankCode;
    private $loteCode;
    private $loteDetail;
    private $order;
    private $segment;
    private $autenticated;
    private $favoredIdentification;
    private $blank1;
    private $docNumber;
    private $blank2;

    public function getSequence(): array
    {
        return [
            new ConfigField($this, 'bankCode', 3, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'loteCode', 4, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'loteDetail', 1, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'order', 5, ConfigField::TYPE_NUMERIC),
            new ConfigField($this, 'segment', 1, ConfigField::TYPE_STRING),
            new ConfigField($this, 'autentication', 64, ConfigField::TYPE_STRING),
            new ConfigField($this, 'favoredIdentification', 20, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blank1', 5, ConfigField::TYPE_STRING),
            new ConfigField($this, 'docNumber', 15, ConfigField::TYPE_STRING),
            new ConfigField($this, 'blank2', 122, ConfigField::TYPE_STRING),
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
