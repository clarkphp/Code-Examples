<?php
try {
    $db = new PDO('sqlite::memory:');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec('create table names (id int, name varchar(10))');
    $db->exec("insert into names values (1, 'anna')");
    $db->exec("insert into names values (2, 'betty')");
    $db->exec("insert into names values (3, 'clara')");
    $db->exec("insert into names values (4, 'demi')");
    $db->exec("insert into names values (5, 'emma')");


    $db->exec('create table emails (id int, email varchar(10))');
    $db->exec("insert into emails values (1, 'anna@example.com')");
    $db->exec("insert into emails values (2, 'betty@example.com')");
    $db->exec("insert into emails values (3, 'clara@example.com')");
    $db->exec("insert into emails values (4, 'demi@example.com')");
    $db->exec("insert into emails values (5, 'emma@example.com')");

    echo 'Names Table:', PHP_EOL;
    foreach ($db->query('select * from names') as $row) {
        echo "{$row['id']}\t{$row['name']}", PHP_EOL;
    }

    echo 'Emails Table:', PHP_EOL;
    foreach ($db->query('select * from emails') as $row) {
        echo "{$row['id']}\t{$row['email']}", PHP_EOL;
    }

    echo 'Left Join: ', PHP_EOL;
    foreach ($db->query('select name, email from names left join emails on emails.id = names.id') as $row) {
        echo "{$row['name']}\t{$row['email']}", PHP_EOL;
    }

    $db->exec('drop table names');
    $db->exec('create table names (id int, name varchar(10), email varchar(10))');
    $db->exec("insert into names values (1, 'anna', 'anna@example.com')");
    $db->exec("insert into names values (2, 'betty', 'betty@example.com')");
    $db->exec("insert into names values (3, 'clara', 'clara@example.com')");
    $db->exec("insert into names values (1, 'anna', 'anna@example.com')");
    $db->exec("insert into names values (2, 'betty', 'betty@example.com')");
    $db->exec("insert into names values (3, 'clara', 'clara@example.com')");
    echo 'Names Table:', PHP_EOL;
    foreach ($db->query('select * from names') as $row) {
        echo "{$row['id']}\t{$row['name']}\t{$row['email']}", PHP_EOL;
    }

    echo 'Select Distinct:', PHP_EOL;
    foreach ($db->query('select distinct name, email from names') as $row) {
        echo "{$row['name']}\t{$row['email']}", PHP_EOL;
    }

    /*
    echo 'Count(id):', PHP_EOL;
    $sql = 'select count(id) from :table where name = :name';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':table', 'names');
    $stmt->bindValue(':name', 'anna');
    $stmt->execute();
    */

    $db->exec('drop table names');
    $db->exec('create table names (id int, name varchar(10), email varchar(10))');
    $db->exec("insert into names values (1, 'anna', 'anna@example.com')");
    $db->exec("insert into names values (2, 'betty', 'betty@example.com')");
    $db->exec("insert into names values (3, 'clara', 'clara@example.com')");
    echo 'Names Table:', PHP_EOL;
    foreach ($db->query('select * from names') as $row) {
        echo "{$row['id']}\t{$row['name']}\t{$row['email']}", PHP_EOL;
    }
    // $db->begin();
    $db->beginTransaction();
    $db->rollback();
 
} catch (PDOException $e) {
    echo $e->getMessage(), PHP_EOL;
    $db = null;
    exit('Exiting...');
}

$db = null;
//exit;

$xml = <<<'CONTENT'
<?xml version="1.0" encoding="utf-8"?>
<html><body>
<ul>
    <li name="x1">List 1</li>
    <li name="x2">List 2</li>
    <li name="x3">List 3</li>
</ul>
</body></html>
CONTENT;

$dom = new DOMDocument();
$dom->loadXML($xml);

//var_dump($dom->getElementById('x3'));
//var_dump($dom->getElementByName('x3')->text());
//var_dump($dom->getElementsByTagName('x3'));

/*
$currentText = '';
foreach ($dom->getElementsByTagName('li') as $list) {
    $currentText = $list->nodeValue;
}
echo $currentText, PHP_EOL;
*/

/*
$xpath = new DOMXPath($dom);
echo $xpath->query("//*[@name='x3']")->innerHTML();
*/

/*********/

function execute($value) {
    switch ($value) {
        case true:
            return 1;
        case false:
            return 0;
        default:
            return -1;
    }
}
$value = '1';
echo execute((((int) $value) & 2)), PHP_EOL;

//=======

http://www.php.net/manual/en/ini.core.php#ini.open-basedir

//=======

echo sprintf('"%4d"', ord('a')), PHP_EOL;

//=======

class myClass {
    const FOO = 'BAR';
}

echo myClass::FOO, PHP_EOL;
//echo myClass::foo, PHP_EOL;

//=======

$a = 2;
$b = 3;

function test() {
    global $b;
    static $a;
    echo 'Line ', __LINE__, ": \$a is $a, \$b is $b", PHP_EOL;
    $a++;
    $b += 2;
    echo 'Line ', __LINE__, ": \$a is $a, \$b is $b", PHP_EOL;
}

test();
echo 'Line ', __LINE__, ": \$a is $a, \$b is $b", PHP_EOL;

test();
echo 'Line ', __LINE__, ": \$a is $a, \$b is $b", PHP_EOL;

test();
echo 'Line ', __LINE__, ": \$a is $a, \$b is $b", PHP_EOL;

echo "$a, $b", PHP_EOL;

/***********/
class MyException extends Exception {}

function bad() {
    try {
        throw new MyException('Something bad happened');
    } catch (OtherException $e) {
        echo 'What?', PHP_EOL;
    }
}

try {
    bad();
} catch (MyException $e) {
    echo 'Bad!', PHP_EOL;
} catch (Exception $e) {
    echo 'Oops!', PHP_EOL;
}

/********/

// Abstract Classes
/**
 * A not-particulary-well designed set of classes, for purposes of illustration.
 */
// final abstract class TelecommunicationsDevice // abstract classes cannot be final!
// abstract final class TelecommunicationsDevice // abstract classes cannot be final!
abstract class TelecommunicationsDevice
{
    protected $id_number = '';

    protected function getIdNumber()
    {
        return $this->id_number; // abstract classes can have instance (object) variables
    }

    abstract public function sendMessage($recipientNumber, $message);

}

class Telephone extends TelecommunicationsDevice
{
    public function getPhoneNumber()
    {
        return $this->getIdNumber();
    }

    public function sendMessage($recipientNumber, $message)
    {
        return 'Sent Text Message ' . $message . ' to ' . $recipientNumber;
    }

}

class Pager extends TelecommunicationsDevice
{
    public function getPagerNumber()
    {
        return $this->getIdNumber();
    }

    public function sendMessage($recipientNumber, $message)
    {
        return 'Paged ' . $recipientNumber . ' with this message: ' . $message;
    }

}

// $cannotInstantiateAnAbstractClass = new TelecommunicationsDevice();


