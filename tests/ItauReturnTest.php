<?php

namespace Tests;

use DoubleDeuce\Itau\ItauSegmentA;
use DoubleDeuce\Itau\ItauSegmentZ;
use DoubleDeuce\ReadReturn;
use PHPUnit\Framework\TestCase;

class ItauReturnTest extends TestCase
{
    

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testReadReturnSegments()
    {
        $file = \file_get_contents(__DIR__ . '/Fixtures/RETURN_BANK_EXAMPLE.txt');
        $retorno = new ReadReturn(
            $file,
            new ItauSegmentA(),
            new ItauSegmentZ()
        );

        $data = $retorno->getReturnData();
        
        
        $this->assertEquals(13000, $data[0]['A']['paidValue']);
        $segmentZAutentication = 'FCC73B9CBAC1B04EBFE4C78ECF024E71B2B44F44F640194D5AAA5302FBC59614';
        $this->assertEquals($segmentZAutentication, $data[0]['Z']['autentication']);
        $segmentZAutentication2 = 'FCC73B9CBAC1B04EBFE4C78ECF024E7173B0175EF7FF99AF4E29F6E4C6FE8D92';
        $this->assertEquals($segmentZAutentication2, $data[2]['Z']['autentication']);
        $this->assertEquals('DV', $data[3]['A']['ocurrency']);
    }

    public function testReadReturnOnlySegmentA()
    {
        $file = \file_get_contents(__DIR__ . '/Fixtures/RETURN_BANK_EXAMPLE.txt');
        $retorno = new ReadReturn(
            $file,
            new ItauSegmentA()
        );

        $data = $retorno->getReturnData();
        
        
        $this->assertEquals(13000, $data[0]['A']['paidValue']);
        $this->assertArrayNotHasKey('Z', $data[0]);
        $this->assertArrayNotHasKey('Z', $data[2]);
        
    }

    public function testReadReturnOnlySegmentZ()
    {
        $file = \file_get_contents(__DIR__ . '/Fixtures/RETURN_BANK_EXAMPLE.txt');
        $retorno = new ReadReturn(
            $file,
            new ItauSegmentZ()
        );

        $data = $retorno->getReturnData();
        
        $segmentZAutentication = 'FCC73B9CBAC1B04EBFE4C78ECF024E71B2B44F44F640194D5AAA5302FBC59614';
        $this->assertEquals($segmentZAutentication, $data[0]['Z']['autentication']);
        $this->assertArrayNotHasKey('A', $data[0]);
        $this->assertArrayNotHasKey('A', $data[2]);
        
    }

}