<?php

namespace MDBTools\Tests\Units;

use MDBTools\Facades\Parsers\MDBParser;
use MDBTools\Files\IFile;
use MDBTools\Parsers\IParser;
use MDBTools\Tables\ITable;
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
        assertTrue(
            $this->parser::loadFile($this->sampleFile)
            instanceof IParser
        );
    }

    /**
     * @test
     */
    public function getFileTest()
    {
        assertTrue(
            $this->parser::loadFile($this->sampleFile)->file()
            instanceof
            IFile
        );
    }

    /**
     * @test
     */
    public function getTablesTest()
    {
        assertTrue(
            is_array($this->parser::loadFile($this->sampleFile)->tables())
        );

        assertTrue(
            ($this->parser::loadFile($this->sampleFile)->tables()[0] ?? null)
            instanceof
            ITable
        );
    }

    /**
     * @test
     */
    public function selectTableTest()
    {
        $parser = $this->parser::loadFile($this->sampleFile);

        $table = $parser->tables()[0] ?? null;
        assertTrue($table instanceof ITable);

        $parser->selectTable($table->getName());

        assertTrue($parser->getSelectedTable() instanceof ITable);
    }

    /**
     * @test
     */
    public function hasTableTest()
    {
        $parser = $this->parser::loadFile($this->sampleFile);

        $table = $parser->tables()[0] ?? null;
        assertTrue(!is_null($table));

        assertTrue($parser->hasTable($table->getName()) === true);
    }

    /**
     * @test
     */
    public function getTableByNameTest()
    {
        $parser = $this->parser::loadFile($this->sampleFile);

        $table = $parser->tables()[0] ?? null;
        assertTrue(!is_null($table));

        assertTrue($parser->getTableByName($table->getName()) instanceof ITable);
    }
}