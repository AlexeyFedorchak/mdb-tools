<?php

namespace MDBTools\Tests\Units;

use MDBTools\Facades\Parsers\MDBParser;
use MDBTools\Tests\MDBToolsTestCase;

class MDBTableUnit extends MDBToolsTestCase
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
        $this->setUpTable();
    }

    /**
     * @test
     */
    public function rawTest()
    {
        self::assertTrue(
            !empty($this->table->raw())
            &&
            !is_array($this->table->raw())
            &&
            !is_numeric($this->table->raw())
        );

        self::assertTrue(!file_exists($this->table->getName()));
    }

    /**
     * @test
     */
    public function jsonTest()
    {
        self::assertTrue(
            !empty($this->table->toJson())
            &&
            !is_array($this->table->toJson())
            &&
            !is_numeric($this->table->toJson())
        );

        self::assertTrue(!file_exists($this->table->getName()));
    }

    /**
     * @test
     */
    public function arrayTest()
    {
        self::assertTrue(
            is_array($this->table->toArray())
        );

        self::assertTrue(!file_exists($this->table->getName()));
    }
}