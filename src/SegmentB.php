<?php

namespace DoubleDeuce;

use DoubleDeuce\Segment;

class SegmentB extends Segment
{

    const TYPE = 'B';
    public function getSegmentType()
    {
        return self::TYPE;
    }
}
