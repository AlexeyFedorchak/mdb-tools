<?php

namespace MDBTools\Tables;

interface ITable
{
    public function getName(): string;
    public function toArray(): array;
    public function toJson(): string;
    public function raw(): string;
}
