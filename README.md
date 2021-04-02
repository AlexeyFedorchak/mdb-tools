# Parser for MS Access .mdb files

Documentation is coming...

Example:
$tables = \MDBTools\Facades\Parsers\MDBParser::loadFile($pathToFile)
    ->tables();

$data = [];
foreach ($tables as $table)
    $data[] = $table->toJson();