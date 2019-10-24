<?php

namespace DoubleDeuce;

use DoubleDeuce\Traits\FormatRemessaData;

/**
 * 
 */
class ConfigField
{
    use FormatRemessaData;

    const TYPE_NUMERIC = 0;
    const TYPE_STRING = 1;

    public function __construct(
        RemessaConfig $reference,
        string $name,
        int $size,
        int $type
    ) {
        $this->reference = $reference ;
        $this->name = $name;
        $this->size = $size;
        $this->type = $type;
    }

    public function formatField()
    {
        if ($this->type === self::TYPE_NUMERIC) {
            return self::fillNumberFormated($this->getValue(), $this->size);
        }

        if ($this->type === self::TYPE_STRING) {
            return self::fillStringFormated($this->getValue(), $this->size);
        }
    }

    private function getValue()
    {
        if ($this->isFunction()) {
            return $this->getFunctionValue();
        }
        
        return $this->getVariableValue();
    }

    private function isFunction(): bool
    {
        return (strpos($this->name, '()') !== false);
    }

    private function getVariableValue()
    {
        return $this->reference->{$this->name};
    }

    private function getFunctionValue()
    {
        $item = str_replace('()', '', $this->name);
        return $this->reference->{$item}();
    }

    public function getFieldFromLine($line, $postion)
    {
        $value =  substr($line, $postion, $this->size);
        if ($this->type == ConfigField::TYPE_NUMERIC) {
            $value = self::clearNumber($value);
        }
        if ($this->type == ConfigField::TYPE_STRING) {
            $value = self::clearString($value);
        }

        return $value;
    }

    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
        throw new Exception("Cannot access private property $name");
    }
}
