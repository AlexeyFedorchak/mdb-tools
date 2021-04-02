<?php

namespace MDBTools\Tests\Units;

use MDBTools\Facades\Parsers\MDBParser;
use MDBTools\Parsers\IParser;
use MDBTools\Tests\MDBToolsTestCase;
use function PHPUnit\Framework\assertTrue;

class MDBParserUnit extends MDBToolsTestCase
{
    /**
     * set up the test
     *
     * MDBParserUnit constructor.
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->setUpParser(MDBParser::class);
    }

    /**
     * @test
     */
    public function loadFileTest()
    {
        assertTrue($this->parser::loadFile($this->sampleFile) instanceof IParser);
    }
}