<?php

namespace DoubleDeuce;

use DoubleDeuce\Segment;

class SegmentA extends Segment
{

    const TYPE = 'A';
    public function getSegmentType()
    {
        return self::TYPE;
    }
}
