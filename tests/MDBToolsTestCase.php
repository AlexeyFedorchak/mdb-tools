<?php

namespace MDBTools\Tests;

use MDBTools\Parsers\IParser;
use MDBTools\Tables\ITable;
use PHPUnit\Framework\TestCase;

class MDBToolsTestCase extends TestCase
{
    /**
     * @var IParser
     */
    protected $parser;

    /**
     * @var ITable
     */
    protected $table;

    /**
     * @var string
     */
    protected $sampleFile = __DIR__ . '/../sample.mdb';

    /**
     * create env version of test case class
     *
     * MDBToolsTestCase constructor.
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        if (!file_exists($this->sampleFile))
            die('Sample "' . $this->sampleFile . '" file is not found!' . "\r\n");
    }

    /**
     * set up parser for testing cases..
     *
     * @param string $facadeName
     */
    public function setUpParser(string $facadeName)
    {
        $this->parser = new $facadeName;
    }

    /**
     * set up table for testing
     *
     * @return mixed
     */
    public function setUpTable()
    {
        if (!$this->parser)
            die('Parser is not set up! Please use "setUpParser" in constructor to set up parser' . "\r\n");

        $table = $this->parser->loadFile($this->sampleFile)->tables()[0] ?? null;

        if (!$table)
            die('Seems like sample file is not correct or doesn\'t contain any tables!'. "\r\n");

        $this->table = $table;
    }
}