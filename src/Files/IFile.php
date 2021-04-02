<?php

namespace MDBTools\Files;

interface IFile
{
    public function getPath(): string;
    public function tables(): array;
}
