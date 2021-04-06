# PHP Parser for MS Access .mdb files

**Installation**

1) Install mdb-tools globally on your machine:
```
apt-get update -y
```
```
apt-get install -y mdbtools
```

2) Install Composer PHP package:
```
composer require mdb-tools/mdb-parser
```

**Usage**

Main logic is put into class "Parser", which has corresponded Facade class.
You may include the parser into your code like this:
```PHP
use MDBTools\Facades\Parsers\MDBParser;
```

After you may do things like this:
```PHP
//load you file
$parser = MDBParser::loadFile('/path/to/file');

//see table names...
$tables = $parser->tables();

//parse data from one chosen table...
print_r($parser->selectTable('some_table')->toArray());
```
**Links**

 - Visit author's [linkedin](https://www.linkedin.com/in/oleksii-fedorchak-web-developer/)
 - Composer package [link](https://packagist.org/packages/mdb-tools/mdb-parser)
 - Documentation website is coming...