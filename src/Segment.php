<?php

namespace DoubleDeuce;

use DoubleDeuce\Traits\FormatRemessaData;

abstract class Segment
{
    use FormatRemessaData;

    private $loteSequence;
    
    abstract public function getSegmentType();

    public function setOrder(int $sequence)
    {
        $this->loteSequence = $sequence;
    }

    public function getOrder()
    {
        return self::fillNumberFormated($this->loteSequence, 5);
    }
}
