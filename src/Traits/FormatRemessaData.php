<?php

namespace DoubleDeuce\Traits;

trait FormatRemessaData
{
    private static function fillStringFormated($value, $size)
    {
        $formated = self::fillRightString(self::limitString($value, $size), $size);
        $formated = self::removeSpecialChars($formated);
        $formated = strtoupper($formated);
        return $formated;
    }

    private static function fillNumberFormated($value, $size)
    {
        return self::fillLeftNumber(self::limitString($value, $size), $size);
    }

    private static function fillRightString($value, $size)
    {
        return str_pad($value, $size);
    }

    private static function fillLeftNumber($value, $size)
    {
        return str_pad($value, $size, "0", STR_PAD_LEFT);
    }

    private static function limitString($str, $limit)
    {
        return substr($str, 0, $limit);
    }

    private static function breakLine()
    {
        return "\r\n";
    }

    private static function removeSpecialChars($string)
    {
        $string = preg_replace('/[áàãâä]/ui', 'a', $string);
        $string = preg_replace('/[éèêë]/ui', 'e', $string);
        $string = preg_replace('/[íìîï]/ui', 'i', $string);
        $string = preg_replace('/[óòõôö]/ui', 'o', $string);
        $string = preg_replace('/[úùûü]/ui', 'u', $string);
        $string = preg_replace('/[ç]/ui', 'c', $string);
        $string = preg_replace('/[^a-z0-9]/i', ' ', $string);
        $string = preg_replace('/_+/', '-', $string);
        $string = rtrim($string, "");
        return $string;
    }

    private static function clearString($str)
    {
        return rtrim($str, ' ');
    }

    private static function clearNumber($str)
    {
        return ltrim($str, '0');
    }
}
