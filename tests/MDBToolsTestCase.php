<?php

namespace MDBTools\Tests;

use MDBTools\Parsers\IParser;
use PHPUnit\Framework\TestCase;

class MDBToolsTestCase extends TestCase
{
    /**
     * @var IParser
     */
    protected $parser;

    /**
     * @var string
     */
    protected $sampleFile = 'sample.mdb';

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
}