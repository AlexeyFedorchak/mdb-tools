# Parser for MS Access .mdb files

Documentation is coming...

Example:
$parser = \MDBTools\Facades\Parsers\MDBParser::loadFile($pathToFile);
$tables = $parser->tables();

//see table names...

print_r($parser->selectTable('some_table')->toArray());