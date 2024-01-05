<?php

namespace MDBTools\Files;

use MDBTools\Exceptions\MDBFileIsNotFound;
use MDBTools\Exceptions\NoTablesFound;
use MDBTools\Tables\MDBTable;

class MDBFile implements IFile
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
        $output = shell_exec('mdb-tables --single-column ' . $this->pathToMDBFile);
        if (!$output)
            throw new NoTablesFound();

        $tables = [];
        foreach (explode("\n",  $output) as $table) {
            if (empty(trim($table)))
                continue;

            $tables[] = new MDBTable($table, $this);
        }

        return $tables;
    }
}
