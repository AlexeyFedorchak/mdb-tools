<?php

namespace MDBTools\Facades;

use MDBTools\Facades\Parsers\MDBParser;
use MDBTools\Parsers\MDBParser as Parser;

abstract class Facade
{
    /**
     * @var MDBParser
     */
    protected static $parser;

    /**
     * @var Parser
     */
    protected $nonStaticParser;

    /**
     * call static methods
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name , array $arguments)
    {
        return self::$parser->$name($arguments[0]);
    }

    /**
     * call non-static methods
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string$name, array $arguments)
    {
        return $this->nonStaticParser->$name($arguments[0]);
    }
}