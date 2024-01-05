<?php

namespace MDBTools\Tables;

use MDBTools\Exceptions\IncorrectFormatChosen;
use MDBTools\Exceptions\ErrorOnParsingTable;
use MDBTools\Exceptions\ParsingFileNotFound;
use MDBTools\Files\MDBFile;

class MDBTable implements ITable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var MDBFile
     */
    protected $MDBfile;

    public function __construct(string $name, MDBFile $MDBFile)
    {
        $this->name = $name;
        $this->MDBfile = $MDBFile;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * get data in array
     * ['column_name' => ['value_1', 'value_2', ..]]
     *
     * @return array
     * @throws ErrorOnParsingTable
     * @throws ParsingFileNotFound
     */
    public function toArray(): array
    {
        $this->createCSVFileOrFail();

        $tableHandler = fopen($this->name, 'r');

        $columns = [];
        $data = [];

        $counter = 0;
        $i = 0;
        while($row = fgetcsv($tableHandler, 5000)) {
            if ($counter == 0) {
                $columns = $row;
                $counter++;

                continue;
            }

            foreach ($columns as $key => $column) {
                $data[$column][$i] = $row[$key] ?? null;
            }

            $counter++;
            $i++;
        }

        $this->removeCSVFile();

        return $data;
    }

    /**
     * get data in JSON
     * {'column_name' => ['value_1', 'value_2', ..]}
     *
     * @return string
     * @throws ErrorOnParsingTable
     * @throws ParsingFileNotFound
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * get raw content
     *
     * @return string
     * @throws ErrorOnParsingTable
     * @throws ParsingFileNotFound
     */
    public function raw(): string
    {
        $this->createCSVFileOrFail();

        $data = file_get_contents($this->name);

        $this->removeCSVFile();

        return $data;
    }

    /**
     * create csv file which will be used for parsing data
     *
     * @throws ErrorOnParsingTable
     * @throws ParsingFileNotFound
     */
    private function createCSVFileOrFail(): void
    {
        $output = shell_exec('mdb-export ' . $this->MDBfile->getPath() . ' "' . $this->name . '" > "' . $this->name . '"');

        if (!empty($output))
            throw new ErrorOnParsingTable($output);

        if (!file_exists($this->name))
            throw new ParsingFileNotFound();
    }

    /**
     * remove csv file if exists
     */
    private function removeCSVFile(): void
    {
        if (file_exists($this->name))
            unlink($this->name);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @throws IncorrectFormatChosen
     */
    public function __call(string $name, array $arguments)
    {
        throw new IncorrectFormatChosen();
    }
}
