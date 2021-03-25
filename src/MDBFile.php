<?php

namespace MDBParser;

use MDBParser\Exceptions\MDBFileIsNotFound;
use MDBParser\Exceptions\NoTablesFound;

class MDBFile
{
    /**
     * @var string
     */
    protected $pathToMDBFile;

    /**
     * MDBFile constructor.
     * @param string $pathToMDBFile
     * @throws MDBFileIsNotFound
     */
    public function __construct(string $pathToMDBFile)
    {
        if (!file_exists($pathToMDBFile))
            throw new MDBFileIsNotFound();

        $this->pathToMDBFile = $pathToMDBFile;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->pathToMDBFile;
    }

    /**
     * get tables encoded in .mdb file
     *
     * @return array
     * @throws NoTablesFound
     */
    public function tables(): array
    {
        $output = shell_exec('mdb-tables ' . $this->pathToMDBFile);
        if (!$output)
            throw new NoTablesFound();

        $tables = [];
        foreach (explode(' ',  $output) as $table) {
            if (empty(trim($table)))
                continue;

            $tables = new MDBTable($table, $this);
        }

        return $tables;
    }
}
