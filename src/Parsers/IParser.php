<?php

namespace MDBTools\Parsers;

use MDBTools\Tables\ITable;

interface IParser
{
    public function loadFile($MDBfile): IParser;
    public function hasTable(string $tableName): bool;
    public function getTableByName(string $tableName): ?ITable;
    public function selectTable(string $tableName): void;
}
