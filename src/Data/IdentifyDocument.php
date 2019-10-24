<?php

namespace DoubleDeuce\Data;

class IdentifyDocument
{
    const CPF = 1;
    const CNPJ = 2;

    public $name;
    public $number;
    public $type;

    public function __construct(
        string $name,
        int $number
    ) {
        $this->name = $name;
        $this->number = $number;
        $this->type = self::getDocumentType($number);
    }

    public static function getDocumentType(int $docNumber)
    {
        if (self::isCpf($docNumber)) {
            return self::CPF;
        }

        if (self::isCnpj($docNumber)) {
            return self::CNPJ;
        }
    }

    public static function isCpf(int $docNumber)
    {
        return (strlen($docNumber) == 11);
    }

    public static function isCnpj(int $docNumber)
    {
        return (strlen($docNumber) == 14);
    }
}
