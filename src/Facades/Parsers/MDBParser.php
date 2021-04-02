<?php

namespace MDBTools\Facades\Parsers;

use MDBTools\Facades\Facade;
use MDBTools\Parsers\MDBParser as Parser;

class MDBParser extends Facade
{
    /**
     * set up facade with corresponded instance
     *
     * MDBParser constructor.
     */
    public function __construct()
    {
        self::$parser = new Parser();
        $this->nonStaticParser = new Parser();
    }

}