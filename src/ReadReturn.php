<?php

namespace DoubleDeuce;

use DoubleDeuce\Segment;
use DoubleDeuce\Traits\FormatRemessaData;

class ReadReturn
{
    use FormatRemessaData;

    private $sequence;
    private $line;
    private $data = [];
    private $segments = [];

    public function __construct(
        string $file,
        Segment ...$segments
    ) {
        $this->segments = $segments;
        $this->file = $file;
    }

    public function getReturnData()
    {
        $this->data = [];
        $this->sequence = -1;
        $lines = $this->getLinesFromFile();
        foreach ($lines as $line) {
            $this->line = $line;
            $this->checkAndReadSegments();
        }
        return $this->data;
    }

    private function getLinesFromFile()
    {
        return explode("\r\n", $this->file);
    }

    private function checkAndReadSegments()
    {
        $type = $this->getSegmentType();
        if ($type == 'A') {
            $this->sequence++;// each segment A is a new sequence
            $segment = $this->getSegment(\DoubleDeuce\SegmentA::class);
            $this->readSegment($segment);
        }

        if ($type == 'Z') {
            $segment = $this->getSegment(\DoubleDeuce\SegmentZ::class);
            $this->readSegment($segment);
        }
    }

    private function getSegmentType()
    {
        return substr($this->line, 13, 1);
    }

    private function getSegment(string $segmentClass)
    {
        foreach ($this->segments as $segment) {
            if ($segment instanceof $segmentClass) {
                return $segment;
            }
        }

        return null;
    }

    private function readSegment(Segment $segment = null)
    {
        if (empty($segment)) {
            return;
        }

        $postion = 0;
        $segmentType = $this->getSegmentType();
        foreach ($segment->getSequence() as $key => $segmentItem) {
            $value = $segmentItem->getFieldFromLine($this->line, $postion);
            $this->data[$this->sequence][$segmentType][$segmentItem->name] = $value;
            $postion += $segmentItem->size;
        }
    }
}
