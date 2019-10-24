<?php

namespace DoubleDeuce;

use DoubleDeuce\Segment;

class SegmentZ extends Segment
{
    const TYPE = 'Z';
    public function getSegmentType()
    {
        return self::TYPE;
    }
}
