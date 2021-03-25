<?php

namespace MDBParser;

use MDBParser\Exceptions\MDBToolsIsNotInstalled;
use MDBParser\Exceptions\TableIsNotFound;

class MDBProcessor
{
    /**
     * @var MDBfile
     */
    protected $MDBfile;

    /**
     * @var array
     */
    protected $tables;

    /**
     * @var MDBTable
     */
    protected $selectedTable;

    /**
     * MDBConverter constructor.
     * @throws MDBToolsIsNotInstalled
     */
    public function __construct()
    {
        if (!$this->MDBToolsInstalled())
            throw new MDBToolsIsNotInstalled('Utility `mdb-tools` is not installed!');
    }

    /**
     * @param MDBfile $MDBfile
     * @return $this
     * @throws Exceptions\NoTablesFound
     */
    public function loadFile(MDBfile $MDBfile): MDBProcessor
    {
        $this->MDBfile = $MDBfile;
        $this->tables = $this->MDBfile->tables();

        return $this;
    }

    /**
     * @return array
     */
    public function tables()
    {
        return $this->tables;
    }

    /**
     * check if .mdb file has table
     *
     * @param string $name
     * @return bool
     */
    public function hasTable(string $name): bool
    {
        foreach ($this->tables as $table) {
            if ($name === $table->getName())
                return true;
        }

        return false;
    }

    /**
     * get table by name
     *
     * @param string $name
     * @return MDBTable|null
     */
    public function getTableByName(string $name): ?MDBTable
    {
        foreach ($this->tables as $table) {
            if ($name == $table->getName())
                return $table;
        }

        return null;
    }

    /**
     * select specific table
     *
     * @param string $name
     * @throws TableIsNotFound
     */
    public function selectTable(string $name)
    {
        if (!$this->hasTable($name))
            throw new TableIsNotFound();

        $this->selectedTable = $this->getTableByName($name);
    }

    public function __call(string $name , array $arguments)
    {
        return $this->selectedTable->$name();
    }

    /**
     * check if mdb-tools installed
     *
     * @return bool
     */
    private function MDBToolsInstalled()
    {
        return strpos(shell_exec('mdb-tables'), 'command not found') !== false;
    }
}
