<?php

namespace Examples;

use DoubleDeuce\Itau\ItauSegmentA;
use DoubleDeuce\Itau\ItauSegmentZ;
use DoubleDeuce\ReadReturn;

require_once __dir__ . '/../vendor/autoload.php';

class ReturnItauExample
{
    public function readReturn()
    {
        $file = \file_get_contents(__dir__ . '/../tests/Fixtures/RETURN_BANK_EXAMPLE.txt');
        $readReturn =  new ReadReturn($file, new ItauSegmentA(), new ItauSegmentZ());

        $data = $readReturn->getReturnData();
        
        return $data;
    }
}

$example = new ReturnItauExample();
$response = $example->readReturn();

var_dump($response);