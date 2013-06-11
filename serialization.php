<?php
$string = serialize('string');
$array = serialize(array('one' => 1, 'two' => 2));

class mySourceClass {
    public $string = 'a string';
    public $boolean = false;
    public $array;
    
    protected $integer = 123;
    private $float = 987.65;

    public function __construct() {
        $this->array = array('one' => 1, 'two' => 2);
    }

    public function getVarInfo($expression = null) {
        $return = '';
        if (isset($expression)) {
            $return = gettype($expression) . ' : ' . var_export($expression, true);
        }
        return $return;
    }
}

$sourceObject = new mySourceClass();
$object = serialize($sourceObject);
var_dump($string);
var_dump($array);
var_dump($object);

print_r(unserialize('a:2:{s:4:"five";i:5;s:3:"two";i:2;}')); echo PHP_EOL;

class myOtherSourceClass extends mySourceClass {
    public function __sleep() {
        // serialize only these properties
        return array('string', 'boolean');
    }

    public function __wakeup() {
        echo 'Restore properties that could not be serialized, like db, file, or other resources', PHP_EOL;
    }
}

$sourceObject = new myOtherSourceClass();
$object = serialize($sourceObject);
var_dump($object);
