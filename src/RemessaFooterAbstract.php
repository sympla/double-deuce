<?php

namespace DoubleDeuce;

abstract class RemessaFooterAbstract
{
    abstract public function setTotalSegments(int $totalSegments);
    abstract public function setTotalToPay(int $totalToPay);
}
