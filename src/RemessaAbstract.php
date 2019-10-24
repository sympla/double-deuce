<?php

namespace DoubleDeuce;

use DoubleDeuce\RemessaConfig;
use DoubleDeuce\RemessaFooterAbstract;
use DoubleDeuce\Traits\FormatRemessaData;
use DoubleDeuce\RemessaFooterFileAbstract;

abstract class RemessaAbstract
{
    use FormatRemessaData;

    private $countSegments = 0;
    private $totalToPay = 0;

    public function createFileHeader(RemessaFileHeaderAbstract $bankFileHeader)
    {
        return $this->createLine(... array_values($bankFileHeader->getSequence()));
    }

    public function createHeader(RemessaHeaderAbstract $bankHeader)
    {
        return $this->createLine(... array_values($bankHeader->getSequence()));
    }

    public function createSegments(Segment ...$bankSegments)
    {
        $segments = [];
        foreach ($bankSegments as $bankSegment) {
            $bankSegment->setOrder(++$this->countSegments);
            $segments[] = $this->selectSegment($bankSegment);
        }

        return $segments;
    }

    protected function selectSegment(Segment $bankSegment)
    {
        switch ($bankSegment->getSegmentType()) {
            case 'A':
                $this->totalToPay += $bankSegment->valueToPay;
                return $this->createSegmentA($bankSegment);
                break;
            
            case 'B':
                return $this->createSegmentB($bankSegment);
                break;
            
            default:
                break;
        }
        return;
    }
    
    protected function createSegmentA(Segment $segmentA)
    {
        return $this->createLine(... array_values($segmentA->getSequence()));
    }

    protected function createSegmentB(Segment $segmentB)
    {
        return $this->createLine(... array_values($segmentB->getSequence()));
    }

    public function createFooter(RemessaFooterAbstract $bankFooter)
    {
        $bankFooter->setTotalSegments($this->getTotalSegments());
        $bankFooter->setTotalToPay($this->getTotalToPay());
        return $this->createLine(... array_values($bankFooter->getSequence()));
    }

    protected function getTotalToPay(): int
    {
        return $this->totalToPay;
    }

    protected function getTotalSegments(): int
    {
        return $this->countSegments;
    }

    public function createFooterFile(RemessaFooterFileAbstract $bankFooterFile)
    {
        $bankFooterFile->setTotalRegisters($this->getTotalRegisters());
        return $this->createLine(... array_values($bankFooterFile->getSequence()));
    }

    protected function getTotalRegisters()
    {
        $header = 2;
        $footer = 2;
        $total = $this->countSegments + $header + $footer;

        return $total;
    }

    public function createLine(ConfigField ...$fields)
    {
        $line = '';
        foreach ($fields as $field) {
            $line .= $field->formatField();
        }
        return $line . $this->breakLine();
    }
}
