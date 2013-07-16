<?php
/* Examples*/

// references
$original = 1;
$ref =& $original;
$ref = 'hello';
echo "ref is $ref and original is $original\n";
//unset($ref);
echo "ref is $ref and original is $original\n";
echo 'ref is ' . (isset($ref) ? '' : ' not ') . ' set' . PHP_EOL;
echo 'original is ' . (isset($original) ? '' : ' not ') . ' set' . PHP_EOL;
$ref = 1;
echo $original;


// passing by reference
$test_var = 'Test value';
function explain_references(&$variable)
{
	$variable = 'My new value';
	return $variable;
}

echo "before \$test_var is $test_var". $EOLN;
echo explain_references($test_var) . $EOLN;
echo "after \$test_var is $test_var". $EOLN;
exit;

// references to objects
// **if myFunction returns an object**, this notation in PHP4 would make $a a reference to the object.
// This is NOT NECESSARY in PHP 5.
$a[] =& myFunctionReturnsAnObject(); // Do this in PHP 4.
$a[] = myFunctionReturnsAnObject(); // In PHP 5, do this.
// In PHP 4, the second form would give $a a COPY of the object, instead of the actual object itself.
// In PHP 5, it gives you the actual object itself.

function makeArrayUpper($arr) {
	if (!is_array($arr)) {
		return false;
	}
	foreach ($arr as $value) {
		$array[] = strtoupper($value);
	}
	return $array;
}

function makeArrayUpper(&$inputArray)
{
    if (!is_array($inputArray)) {
    	return false;
    }
    foreach ($inputArray as $key => $value) {
    	$inputArray[$key] = strtoupper($value);
    }
    return true;
}
//
function makeArrayUpper($input = null)
{
    if (!is_array($input)) {
    	return false;
    }
    return array_map('strtoupper', $input);
}


$array = explode(' ', 'Zend Training - Building Security into your PHP Applications');
var_dump($array);
makeArrayUpper($array);
var_dump($array);


// list()
var_dump(microtime());
list($usec, $sec) = explode(' ', microtime());
echo $usec . ' ' . ' ' $sec . PHP_EOL;

$info = array('coffee', 'brown', 'caffeine');
$drink = $info[0];
$color = $info[1];
$power = $info[2];
echo "$drink is $color and $power makes it special.$EOLN";

unset($drink, $color, $power);
echo "$drink is $color and $power makes it special.$EOLN";

list($drink, $color, $power) = $info;
echo __LINE__ . " $drink is $color and $power makes it special.$EOLN";

$data = "foo:*:1023:1000::/home/foo:/bin/sh";
list($user, $pass, $uid, $gid, $ucomment, $home, $shell) = explode(":", $data);
echo 'user is ' . $user . $EOLN; // foo
echo 'password is ' . $pass . $EOLN; // *
var_dump($home);

list($myusername,,,,,$home) =  explode(":", $data);
//=============================================

$EOL = '<br />';
$dayOfWeek = 'Friday';
if ('Friday' === $dayOfWeek) {
   echo "See you next week!$EOL";
} elseif ('Saturday' === $dayOfWeek || 'Sunday' === $dayOfWeek) {
   echo "See you on Monday!$EOL";
} else {
   echo "See you tomorrow!$EOL";
}




# switch statement
$color = 'Red';
switch ($color) {
	case 'Red':
      echo 'Red Alert!';
    case 'Green':
      echo 'All ahead full!';
      break;
	case 'Blue':
      echo 'I can see clearly now; the rain is gone!';
      echo 'Hi there!';
      break;
	case 'Orange':
      echo 'As in ... A Clockwork?';
		break;
	case 'Yellow':
      echo 'Banana for Sale, cheap!';
		break;
	default:
	   echo 'Not a color I know or like!';
		break;
}

echo $color;


$a = true;
$b = false;

switch (true) {
	case $a:
	case $b:
		echo 'Run me now!' . PHP_EOL;
		break;
}

exit;

// array iteration
$array = array(
    1 => range(1, 4),
    2 => range(1, 4),
    3 => range(1, 4)
);

foreach ($array as $key => $value) {
	if (2 === $key) {
		continue;
	}
	echo $key . ': ' . implode(', ', $value) . "\n";
}

foreach ($array as $value){
	foreach ($value as $value2){
		echo $value2."<br/>";
	}
}


exit;


// curly brace notation for variables
$drink= 5;
echo "${drink}s";


// Uncommon, but correct use of the switch statement.
// Switch is normally used to evaluate a variable against a number of known, literal values.
// I.e., is the color red, green, blue, etc., and then take action accordingly.
// Below, we are switching on the boolean true, and each case has an expression which is being tested.
// I'm making a note of this because this usage appears in the course project, and I wanted you to have a heads-up.
$test=3;
switch(true){
	case ($test<6):
		echo "yes, less than 6$EOLN";
		break;
	default:
		echo "no, at least 6$EOLN";
}

//# functions you already know
define('CONSTANT', 'Zend to the Resucue!');
echo 'CONSTANT is: ' . CONSTANT . $EOLN;
echo 'Constant is: ' . Constant . $EOLN;


$EOLN = '<br />';
$EOLN = "\n";
# Complete function index at http://www.php.net/manual/en/indexes.php
# Array functions http://www.php.net/manual/en/ref.array.php
# String functions http://www.php.net/manual/en/book.strings.php

function multipleReturnDemo($var)
{
	switch ($var) {
		case 1:
			return 'one';
			break; // break statement is never reached
		case 2:
			return 'two';
			break;
		default:
		    return false;
			break;
	}
	// code here is unreachable
}

echo multipleReturnDemo(1) . $EOLN;
echo multipleReturnDemo(2) . $EOLN;
echo multipleReturnDemo(6) . $EOLN;


//echo is a language construct, not a function
echo 'Hello Me' . $EOLN;
echo ('Hello You' . $EOLN);
//echo ('Hello Them', $EOLN); // not legal
echo 'Hello', ' all', ' you', $EOLN; // legal

//$test = echo 'Hi'; // Not legal - cannot use in expressions
$test = print 'Hi'. $EOLN; // This IS legal
var_dump($test);
echo $EOLN;

$test = "some other value";
print_r($test);
echo $EOLN;

$result = print_r($test, true);
echo $result . $EOLN;

$var = 'Hi there!';
echo '$var is ' . (is_array($var) ? '' : 'not ') . "an array.$EOLN";

$var = array('Hi there!');
echo '$var is ' . (is_array($var) ? '' : 'not ') . "an array.$EOLN";

$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
$pieces = explode(" ", $pizza);
echo $pieces[0] . $EOLN; // piece1
echo $pieces[1] . $EOLN; // piece2
$pieces = explode("piece3", $pizza);
echo $pieces[0] . $EOLN; // piece1 piece2
echo $pieces[1] . $EOLN; // piece4  etc...


if (function_exists('myFunction')) {
    $var = myFunction();
}

# strtolower - used in project
$oldString = 'This Is My Original String';
$oldArray = explode(' ', $oldString);

$newString = strtolower($oldString);
var_dump($oldArray);
echo "\$oldString : $oldString$EOLN" . "\$newString: $newString{$EOLN}";



# Return value
function returnValueDemo($argument) {
	switch ($argument) {
		case 1:
			$retVal = $argument . '10';
			break;

		case 3:
			$retVal = $argument . '30';
			break;

		case 7:
			return false;
			break;

		case 5:
			$retVal = $argument . '50';
			break;

		default:
			$retVal = '';
			break;
	}
	return $retVal;
}

var_dump(returnValueDemo(1)); echo '<br />';
var_dump(returnValueDemo(3)); echo '<br />';
var_dump(returnValueDemo(7)); echo '<br />';
var_dump(returnValueDemo('blecko')); echo '<br />';


# References
$color = 'red';
$Farbe = &$color; // Farbe is German for English 'color'
echo "\$Farbe is $Farbe <br />";
echo "\$color is $color <br />";

echo "\$color is $Farbe <br />";
echo "\$Farbe is $color <br />";

var_dump($Farbe === $color); echo '<br />';

$my_array = array('beef', 'chicken', 'potato');
$reference = &$my_array[1];

$reference = 'sausage';

echo $reference . '<br />';
var_dump($my_array);
// http://www.php.net/manual/en/language.references.php


# Internal functions demo
$original = 'This Is A String Of Mixed Case INCLUDING ALL CAPS';
$caseFoldedString = strtolower($original);
echo "\$original $original<br />";
echo "\$caseFoldedString $caseFoldedString<br />";

$originalArray = explode(' ', $original);
echo '<pre>'; var_dump ($originalArray); echo '</pre>';

sort($originalArray);
echo '<pre>'; var_dump ($originalArray); echo '</pre>';
exit;
// http://www.php.net/manual/en/book.array.php

# File-related predefined constants
echo DIRECTORY_SEPARATOR . "\n" . PATH_SEPARATOR . "\n";

# Show me all defined constants.
define("MY_CONSTANT", 1);
print_r(get_defined_constants(true)); // optional TRUE categorizes them

# What is this context stuff?
#http://php.net/manual/en/intro.stream.php
#http://www.php.net/manual/en/context.php
$zend_home = file_get_contents('http://www.zend.com/');
echo strlen($zend_home) . '<br />';
exit;
//
echo get_include_path() . '<br />';
$fp = fopen('testfile.txt', 'r') or exit('Could not open file!<br />');
if (! $fp) {
	echo 'There was an error opening the file<br />';
}

$contents = fgetc($fp);
echo $contents . '<br />';
$contents = fgets($fp);
echo $contents . '<br />';
$contents = fgets($fp, 1000000);
echo $contents . '<br />';
exit;

$EOLN = "\r\n"; // Windows text line ending char sequence

//fgets(); // get a  from the file

# Reading from files
fgetc();
fgetcsv();
fgetss();
fscanf();
rewind();
file_get_contents();

# Writing to files
$fp_write = fopen('mytestfile.txt', 'w');
fwrite($fp_write, "Some data to write.$EOLN");
fputs($fp_write, "Some more data to write.$EOLN");
// fputs is an alias for fwrite - same function.
fclose($fp_write);


$fp = fopen('mytestfile.txt', 'a+'); // append to file
$csv_data = array('Column1', 'Column2', 'Column3', 'Column4', 'Column5');
fputcsv($fp, $csv_data); // try using "\t" as third parameter
fclose($fp);
echo 'At line ' . __LINE__;

$fp = fopen('mytestfile.txt', 'r') or exit('Error!');


# Locking files
// open the file first
$fp = fopen('lockfile.txt', 'r+');

//flock

# Closing files and Other file functions
$fp = fopen('myfile.txt', 'r');
$result = fclose($fp);
echo ($result ? 'Successfully closed.' : 'Close failed!') . '<br />';

$lines = file('myfile.txt');
echo '$lines: <pre>' . print_r($lines, true) . '</pre><br />';
$zend_home = file('http://www.zend.com/');

$textFiles = glob('*.txt');

$fileOrPathName = 'ce_samples3.txt';
//$fileOrPathName = 'blecko.jnk';
if (is_dir($fileOrPathName)) {
	echo "$fileOrPathName is a directory<br />";
} else {
	echo "$fileOrPathName is not a directory<br />";
}

if (is_file($fileOrPathName)) {
	echo "$fileOrPathName is a file<br />";
} else {
	echo "$fileOrPathName is not a file<br />";
}

tmpfile();

//fpassthru();

# Using fopen() and fclose()
$fh = fopen('myfile.txt', 'r') or die("Cannot open file<br />");
// do something here
fclose($fh);
//
//
$fh = fopen('myfile.txt', 'r') or die("Cannot open file<br />");
while (! feof($fh)) {
	echo  fgets($fh) . '<br />';
}
fclose($fh);
echo $sec . ' ' . $usec . "\n";

$dirs = glob('../application/views/scripts/*');
foreach ($dirs as $dir) {
        foreach( glob("$dir/*") as $file) {
            echo "$file - ";
            echo filesize($file).'bytes - ';
            echo count(file($file));
            echo '<br />';
        }
}
