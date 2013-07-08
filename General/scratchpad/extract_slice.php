<?php
/*
function setUpTest() {
	$return_val = array();

	$row = array(
		'id' => '12345',
		'FirstName' => 'John',
		'LastName' => 'Doe',
		'BirthdayDate' => '01/25/1982'
	);
 
	$i = 0;
	$end = 2000000;

	while ($i < $end) {
		$return_val[$i++] = $row;
	}

	return $return_val;
}

$users = setUpTest();
$arraySize = count($users);
echo 'count ' . $arraySize . PHP_EOL;

// while
$userIds = array();

// replace $arraySize with count($users) and note the elapsed time
$start = microtime(true);
$i = 0;
while ($i < $arraySize) {
	$userIds[] = $users[$i++]['id'];
}
$elapsedTime = microtime(true) - $start;
echo 'while           : ' . $elapsedTime . PHP_EOL;

// foreach no key
$userIds = array();

$start = microtime(true);
foreach ($users as $value) {
	$userIds[] = $value['id'];
}
$elapsedTime = microtime(true) - $start;
echo 'foreach no key  : ' . $elapsedTime . PHP_EOL;

// foreach with key
$userIds = array();

$start = microtime(true);
foreach ($users as $key => $value) {
	$userIds[] = $value['id'];
}
$elapsedTime = microtime(true) - $start;
echo 'foreach with key: ' . $elapsedTime . PHP_EOL;
*/

// just need to get the job done...
$array = explode(' ', 'Zend Training - Building Security into your PHP Applications');

$start = microtime(true);
foreach ($array as &$value) {
    $value = strtoupper($value);
}
$elapsedTime = microtime(true) - $start;
//print_r($array);
echo PHP_EOL . $elapsedTime . PHP_EOL;

// Using array walk because you mentioned it in the lesson...
$array = explode(' ', 'Zend Training - Building Security into your PHP Applications');
function myStrToUpper(&$value, $key) {
    $value = strtoupper($value);
}

$start = microtime(true);
array_walk($array, 'myStrToUpper');
$elapsedTime = microtime(true) - $start;
//print_r($array);
echo PHP_EOL . $elapsedTime . PHP_EOL;

// Probably best? (although have never used this function before)...
$array = explode(' ', 'Zend Training - Building Security into your PHP Applications');

$start = microtime(true);
$array = array_map('strtoupper', $array);
$elapsedTime = microtime(true) - $start;
//print_r($array);
echo PHP_EOL . $elapsedTime . PHP_EOL;

