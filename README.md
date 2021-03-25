# Parser for MS Access .mdb files

How to use:
$mdbFile = new MDBFile('some/path');
$mdbProcessor = (new MDBProcessor())->loadFile($mdbFile)

$tables = $mdbProcessor
    ->tables();

$mdbProcessor->selectTable('some_table')
    ->toJson();

$data = [];
foreach ($mdbProcessor->tables() as $table) {
    $data[] = $mdbProcessor->selectTable($table->getName())
                ->toJson();
}