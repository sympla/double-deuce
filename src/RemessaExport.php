<?php

namespace DoubleDeuce;

use DoubleDeuce\Segment;
use DoubleDeuce\RemessaFooterAbstract;
use DoubleDeuce\RemessaHeaderAbstract;
use DoubleDeuce\RemessaFileHeaderAbstract;
use DoubleDeuce\RemessaFooterFileAbstract;

class RemessaExport
{
    public function __construct(
        RemessaAbstract $remessa,
        RemessaFileHeaderAbstract $fileHeader,
        RemessaHeaderAbstract $header,
        RemessaFooterAbstract $footer,
        RemessaFooterFileAbstract $fileFooter,
        Segment ...$segments
    ) {
        $this->fileHeaderLine = $remessa->createFileHeader($fileHeader);
        $this->headerLine = $remessa->createHeader($header);
        $this->segmentLines= $remessa->createSegments(... $segments);
        $this->footerLine = $remessa->createFooter($footer);
        $this->fileFooterLine = $remessa->createFooterFile($fileFooter);
    }

    public function toString()
    {
        $remessaFile = $this->fileHeaderLine;
        $remessaFile .= $this->headerLine;
        foreach ($this->segmentLines as $segment) {
            $remessaFile .= $segment;
        }
        $remessaFile .= $this->footerLine;
        $remessaFile .= $this->fileFooterLine;

        return $remessaFile;
    }
}
