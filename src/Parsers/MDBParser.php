<?php

namespace MDBTools\Parsers;

use MDBTools\Exceptions\IncorrectBackUpFileProvided;
use MDBTools\Exceptions\MDBFileIsNotFound;
use MDBTools\Exceptions\MDBToolsIsNotInstalled;
use MDBTools\Exceptions\NoTablesFound;
use MDBTools\Exceptions\TableIsNotFound;
use MDBTools\Files\IFile;
use MDBTools\Files\MDBFile;
use MDBTools\Tables\ITable;
use MDBTools\Tables\MDBTable;

class MDBParser implements IParser
{
    /**
     * @var MDBFile
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
     * load file {use as a param string or MDBFile instance}
     *
     * @param MDBfile|string $MDBfile
     * @return $this
     * @throws NoTablesFound
     * @throws IncorrectBackUpFileProvided
     * @throws MDBFileIsNotFound
     */
    public function loadFile($MDBfile): IParser
    {
        if (empty($MDBfile)) 
            throw new IncorrectBackUpFileProvided();

        if ($MDBfile instanceof MDBFile)
            $this->MDBfile = $MDBfile;
        else
            $this->MDBfile = new MDBFile($MDBfile);

        $this->tables = $this->MDBfile->tables();
        return $this;
    }

    /**
     * check if .mdb file has table
     *
     * @param string $tableName
     * @return bool
     */
    public function hasTable(string $tableName): bool
    {
        foreach ($this->tables as $table)
            if ($tableName === $table->getName())
                return true;

        return false;
    }

    /**
     * get table by name
     *
     * @param string $tableName
     * @return MDBTable|null
     */
    public function getTableByName(string $tableName): ?ITable
    {
        foreach ($this->tables as $table)
            if ($tableName == $table->getName())
                return $table;

        return null;
    }

    /**
     * select specific table
     *
     * @param string $tableName
     * @throws TableIsNotFound
     */
    public function selectTable(string $tableName): void
    {
        if (!$this->hasTable($tableName))
            throw new TableIsNotFound();

        $this->selectedTable = $this->getTableByName($tableName);
    }

    /**
     * get file if loaded
     *
     * @return ?IFile
     */
    public function file(): ?IFile
    {
        return $this->MDBfile;
    }

    /**
     * get tables if file is loaded
     *
     * @return array
     */
    public function tables(): array
    {
        if (!$this->file())
            return [];

        return $this->file()->tables();
    }

    /**
     * get selected table if selected..
     *
     * @return ?ITable
     */
    public function getSelectedTable(): ?ITable
    {
        return $this->selectedTable;
    }

    /**
     * check if mdb-tools installed
     *
     * @return bool
     */
    private function MDBToolsInstalled(): bool
    {
        return strpos(shell_exec('mdb-tables --version'), 'command not found') === false;
    }

    /**
     * call table methods..
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name , array $arguments)
    {
        return $this->selectedTable->$name();
    }
}
