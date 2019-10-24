<?php

namespace Tests;

use Tests\Fixtures\Elements;
use PHPUnit\Framework\TestCase;
use DoubleDeuce\Itau\ItauHeader;
use DoubleDeuce\Itau\ItauRemessa;
use DoubleDeuce\Itau\ItauFileHeader;
use DoubleDeuce\Itau\ItauFooter;
use DoubleDeuce\Itau\ItauFooterFile;

class ItauRemessaTest extends TestCase
{
    private $elements;

    public function setUp()
    {
        parent::setUp();
        $this->elements = new Elements();
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->elements = null;
    }

    public function testCreateRemessaFileHeader()
    {
        $headerToTest = "34100000      081284554035000162                    09999 000000004484 7CAIXA DAGUA COM SOLUCOES SA   ITAU                                    1". date('dmYHis') ."00000000001600                                                                     \r\n";

        $company = $this->elements->createCompany();
        $itauFileHeader = new ItauFileHeader($company);
        $this->itauRemessa = new ItauRemessa();
        $header = $this->itauRemessa->createFileHeader($itauFileHeader);

        $this->assertEquals(240, strlen(rtrim($header, "\r\n")));
        $this->assertEquals($headerToTest, $header);
    }
    
    public function testCreateRemessaHeader()
    {
        $headerToTest = "34100011C2041040 284554035000162                    09999 000000004484 7CAIXA DAGUA COM SOLUCOES SA   REMESSE PARA PAGAR MEUS DEVEDO          RUA JOAO DO ALTO NOBRE        0089110 ANDAR       BELO HORIZONTE      30111000MG                  \r\n";
        
        $loteResponsability = "REMESSE PARA PAGAR MEUS DEVEDORES";
        
        $company = $this->elements->createCompany();
        $ItauHeader = new ItauHeader(
            $company,
            $loteResponsability
        );

        $this->itauRemessa = new ItauRemessa();
        $header = $this->itauRemessa->createHeader($ItauHeader);

        $this->assertEquals(240, strlen(rtrim($header, "\r\n")));
        $this->assertEquals($headerToTest, $header);
    }

    public function testCreateSegmentA()
    {
        $segmentAToTest = "3410001300001A00000000103333 000000077777 XTESTE PRODUCOES LTDA ME       70973FCH1           ". date('dmY') ."REA000000000000000000000012201840                    00000000000000000000000                    000000763755290001510100010     0          \r\n";
        $ItauSegmentA = $this->elements->createSegmentAData();
        $this->itauRemessa = new ItauRemessa();
        $segment = $this->itauRemessa->createSegments($ItauSegmentA);
        
        $this->assertEquals(240, strlen(rtrim($segment[0], "\r\n")));
        $this->assertEquals($segmentAToTest, $segment[0]);
    }

    public function testCreateSegmentB()
    {
        $segmentBToTest = "3410001300001B   276375529000151RUA DAS MAZELASALVAS          00999               BAIRRO DO ALTO SAO JOSE DOS CAMPOS 03500000SP                                                                                                                 \r\n";
        $ItauSegmentB = $this->elements->createSegmentBData();
        $this->itauRemessa = new ItauRemessa();
        $segment = $this->itauRemessa->createSegments($ItauSegmentB);
        
        $this->assertEquals(240, strlen(rtrim($segment[0], "\r\n")));
        $this->assertEquals($segmentBToTest, $segment[0]);
    }

    public function testCreateSegmentSequence()
    {
        $segmentAToTestPartial = "3410001300001A";
        $segmentBToTestPartial = "3410001300002B";
        $segmentAToTestPartial2 = "3410001300003A";
        $segmentBToTestPartial2 = "3410001300004B";
        $ItauSegmentA = $this->elements->createSegmentAData();
        $ItauSegmentB = $this->elements->createSegmentBData();
        $ItauSegmentA2 = $this->elements->createSegmentAData();
        $ItauSegmentB2 = $this->elements->createSegmentBData();
        
        $this->itauRemessa = new ItauRemessa();
        $segment  = $this->itauRemessa->createSegments($ItauSegmentA, $ItauSegmentB);
        $segment2 = $this->itauRemessa->createSegments($ItauSegmentA2, $ItauSegmentB2);

        $testSequenceA = substr($segment[0], 0, 14);
        $testSequenceB = substr($segment[1], 0, 14);
        $testSequenceA2 = substr($segment2[0], 0, 14);
        $testSequenceB2 = substr($segment2[1], 0, 14);
        $this->assertEquals($segmentAToTestPartial, $testSequenceA);
        $this->assertEquals($segmentBToTestPartial, $testSequenceB);
        $this->assertEquals($segmentAToTestPartial2, $testSequenceA2);
        $this->assertEquals($segmentBToTestPartial2, $testSequenceB2);
    }

    public function testCreateRemessaFooter()
    {
        $footerToTest = "34100015         000004000000000024403680000000000000000000                                                                                                                                                                                     \r\n";
        $this->itauRemessa = new ItauRemessa();
       
        $ItauSegmentA = $this->elements->createSegmentAData();
        $ItauSegmentB = $this->elements->createSegmentBData();
        $this->itauRemessa->createSegments(
            $ItauSegmentA,
            $ItauSegmentB,
            $ItauSegmentA,
            $ItauSegmentB
        );

        $footer = $this->itauRemessa->createFooter(new ItauFooter());
        $this->assertEquals(240, strlen(rtrim($footer, "\r\n")));
        $this->assertEquals($footerToTest, $footer);
    }

    public function testCreateRemessaFooterFile()
    {
        $footerFileToTest = "34199999         000001000008                                                                                                                                                                                                                   \r\n";

        $this->itauRemessa = new ItauRemessa();
       
        $ItauSegmentA = $this->elements->createSegmentAData();
        $ItauSegmentB = $this->elements->createSegmentBData();
        $this->itauRemessa->createSegments(
            $ItauSegmentA,
            $ItauSegmentB,
            $ItauSegmentA,
            $ItauSegmentB
        );

        $footerFile = $this->itauRemessa->createFooterFile(new ItauFooterFile());
        $this->assertEquals(240, strlen(rtrim($footerFile, "\r\n")));
        $this->assertEquals($footerFileToTest, $footerFile);
    }
}