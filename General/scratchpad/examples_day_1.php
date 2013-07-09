<?php
/* Examples - Class Day 1 */

echo "Quotes - Single and Double\n";
// single - no parsing, double - parsing and variable expansion
$name = 'Bob';
echo "1. my name is Bart.\n";
echo "2. my name is $name.\n";
echo '3. my name is $name.\n';
echo '4. my name is ' .  $name . "\n";
echo "5. How many {$name}s do you know?\n";
exit;

$message = <<<EOT
Line one
Line two - variables like $name expand in heredocs.
Line three
EOT;

echo $message . "\n";

$link = '<a href="http://www.example.com/" title="An example link in PHP">Example Link</a>';
echo $link;
$href = 'http://www.example.com/';
$title = 'An example link in PHP';
$contents = 'Example Link';
$link_double = "<a href=\"$href\" title=\"$title\">$contents</a>";
echo $link_double;

exit;

echo <<<'EX_NOWDOC'
This is an example of a PHP 5.3-only string
called a NOWDOC. Variables like $this_var_name are
not expanded into a value.
EX_NOWDOC;

# can a function be a data type? No, but it CAN return a value of a particular datatype.
echo '4. my name is ' .  my_str_function() . "\n";
function my_str_function() {
	return 'Slartibartfast'; // returns a string value
}

exit;

echo "\nComments\n";
#this is a line comment
// this is also a line comment
/* This is ...
   ... a multiline comment */

/* Be careful about commenting out blocks of code that contain multiline comments! */
echo "This is some code you want to comment out";
/* You will have problems if a comment is closed prematurely */

echo "\nEscaping characters - use double quotes\n";
echo "To display a newline, use \\n\n";
echo "To display a backslash at the end of a string, use an extra backslash \\";
echo "\nOne backslash, \ ";
echo "\nTwo backslashes, \\ ";
echo "\nThree backslashes, \\\ ";

exit;

echo "\nVariables and names\n";
var_dump(isset($test));
$test = '';
var_dump($test);
$test = null;
var_dump(isset($test));
unset($test);
var_dump(isset($test));
exit;

$totalPrice = 40;
$TotalPrice = 50;
echo "\n$totalPrice, $TotalPrice\n";
echo $iDoNotExist; // treated as an empty string.

exit;
echo "\nTypecasting\n";
$varA = 5;
$varB = (boolean) $varA;
$varC = "$varA";
$varC = (string) $varA;
var_dump($varA);
var_dump($varB);
var_dump($varC);

exit;
echo "\nconstants\n";
define('GUEST_USER', 'guest');
define('guest_user', 'user_two');
echo GUEST_USER . "\n" . guest_user . "\n";
exit;

var_dump(array('value1', 'key2' => 'value2'));

exit;
echo "\narrays exercise - slide 21 - starting array\n";
$var = array('2' => 1, 3);
var_dump($var);

exit;
echo "\narrays exercise possible answers\n";
$var = array('2' => 1, 3 => 3, 'b' => 4, 4 => 2);   
var_dump($var);
$var = array('2' => 1, 3, 'b' => 4, 2);
var_dump($var);
$var = array('2' => 1, 3, "b" => 4, 2);
var_dump($var);
$var = array('2' => 1, 3, "b" =>4, 4 => 2);
var_dump($var);
$var = $var + array(3 => 3, 'b' => 4, 4 => 2);
var_dump($var);

$var = array('2' => 1, 3);
var_dump($var);
$var['b'] = 4;
$var[] = 2;
var_dump($var);

$var = array('2' => 1, 3);
var_dump($var);
$var['b'] = 4;
$var[4] = 2;
var_dump($var);

exit;
echo "\nCount\n";
$size = count($var);
var_dump($size);

echo "\nCount of an invalid variable\n";
$size = count($undefined_variable);
var_dump($size);

$size = count($count_message);
echo "\n$size\n";

exit;
echo "\narray quiz - slide 24\n";
$array1 = array('color' => 'red', 2, 4);
$array2 = array('a', 'b', 'color' => 'green', 'shape' => 'trapezoid', 4);
print_r($array1);
print_r($array2);
$result = array_merge($array1, $array2);
print_r($result);

exit;
echo "\nAssignment vs. comparison operators\n";
var_dump(true == true);
var_dump(true === 1);
$var += array('hi' => 'there');
echo __LINE__; print_r($var);
exit;

# note difference between print_r($var) and print_r($var, true);

# assignment operators - division and modulus
$dividend = 10; // the number on the top
$divisor  = 5; // the number on the bottom

//$dividend = 5;
//$divisor  = 3;
//
//$quotient  = $dividend / $divisor;
//$remainder = $dividend % $divisor;
//
//echo "Given a divisor of $divisor and a dividend of $dividend:<br />";
//echo "The quotient ($dividend / $divisor) is $quotient<br />";
//echo "The remainder ($dividend % $divisor) is $remainder<br />";


# combining assignment operators
//echo "Combining assignment with modulus ($dividend %= $divisor) leaves \$dividend with a value of ";
//$dividend %= $divisor; // same as $dividend = $dividend % $divisor;
//echo $dividend . '<br />';
//
//
//
$EOL = PHP_EOL;
echo "The result of division is not always of data type 'float': ";
$dividend = 5;
$divisor  = 3; # 5 / 3 results in a float

//$dividend = 10;
//$divisor  = 5; # 10 / 5 results in an integer

$quotient  = $dividend / $divisor;
var_dump($quotient);
echo '<br />';


# pre and post increment
$a = 6;
echo $a++ . $EOL . 'A is now: ' . $a . $EOL;

$a = 6;
echo ++$a . $EOL;
echo 'A is now: ' . $a . $EOL;

//define('EOL', '<br />'); // web page
//define('EOL', "\r\n"); // command line (Windows)
//define('EOL', "\n"); // command line (Unix, Linux)
//define('EOL', "\r"); // command line (Older Macintosh)

# String Operators
echo 'Hello ' . 'World' . PHP_EOL;
$string = 'Hello ' . 'World' . PHP_EOL . PHP_EOL;
echo $string;

$salaryLevel = 4500;
$sql = 'SELECT first_name, last_name, city, state, postal_code'
     . ' FROM employee'
     . ' WHERE salary <= ' . $salaryLevel;

echo 'Query: ' . $sql . PHP_EOL . PHP_EOL;

# Note that echo is a function (language construct) that takes parameters, separated by commas:
# Language constructs do not require the use of parantheses.
# echo does the concatenation internally
$string = 'Hello ', 'World', PHP_EOL, PHP_EOL, 'Query: ', $sql, PHP_EOL, PHP_EOL;

exit;
echo "\nLogical operators\n";
var_dump(true || false and false );
var_dump(true or false && false);
var_dump(true or false and false);
var_dump(true || false && false);
var_dump(!true);
//var_dump(not true); 'not' doesn't exist, use exclamation point !
var_dump(5);
var_dump(5 ^ 1); // this is a BITWISE, not a logical, operator. It operates on bit patterns.

exit;

# catenating assignment (building up a string)
$sql .= " AND first_name != 'slartibartfast'";
echo 'Revised Query: ' . $sql . EOL;

# Comparison operators
$salary = 4500; $salaryMax = 5500; // both are ints
echo '$salary: '; var_dump($salary);
echo ', $salaryMax: '; var_dump($salaryMax); echo EOL;
echo '$salary == $salaryMax: '; var_dump($salary == $salaryMax); echo EOL . EOL;

$salary = 5500; $salaryMax = 5500; // both are ints
echo '$salary: '; var_dump($salary);
echo ', $salaryMax: '; var_dump($salaryMax); echo EOL;
echo '$salary == $salaryMax: '; var_dump($salary == $salaryMax); echo EOL . EOL;

$salary = '5500'; $salaryMax = 5500; //5500.0 string and int, string and float, loose comparison
echo '$salary: '; var_dump($salary);
echo ', $salaryMax: '; var_dump($salaryMax); echo EOL;
echo '$salary == $salaryMax: '; var_dump($salary == $salaryMax); echo EOL . EOL;

$salary = '5500'; $salaryMax = 5500; //5500.0 string and int, string and float, strict comparison
echo '$salary: '; var_dump($salary);
echo ', $salaryMax: '; var_dump($salaryMax); echo EOL;
echo '$salary === $salaryMax: '; var_dump($salary === $salaryMax); echo EOL . EOL;

$salary = '5500'; $salaryMax = '5500'; // both are strings, strict type comparison
echo '$salary: '; var_dump($salary);
echo ', $salaryMax: '; var_dump($salaryMax); echo EOL;
echo '$salary === $salaryMax: '; var_dump($salary === $salaryMax); echo EOL . EOL;

$salary = 5500; $salaryMax = '5500';
echo '$salary: '; var_dump($salary);
echo ', $salaryMax: '; var_dump($salaryMax); echo EOL;
echo '$salary !== $salaryMax: '; var_dump($salary !== $salaryMax); echo EOL . EOL;

$salary = '5500'; $salaryMax = '5500';
echo '$salary: '; var_dump($salary);
echo ', $salaryMax: '; var_dump($salaryMax); echo EOL;
echo '$salary !== $salaryMax: '; var_dump($salary !== $salaryMax); echo EOL . EOL;

$return_value = false; $test_value = 0;
echo '$return_value: '; var_dump($return_value);
echo ', $test_value: '; var_dump($test_value); echo EOL;
echo '$return_value !== $test_value: '; var_dump($return_value !== $test_value); echo EOL . EOL;

# Normally don't use < or > for comparing strings, use strcmp() function
$string_one = 'aaaaa';
$string_two = 'Aaaaa';
echo "$string_one > $string_two: "; var_dump($string_one > $string_two); echo EOL . EOL;

# reference page in manual http://www.php.net/manual/en/types.comparisons.php

//exit;
# Logical operators
echo 'true && true: '; var_dump(true && true); echo EOL;
echo 'true and true: '; var_dump(true and true); echo EOL . EOL;
echo 'true && false: '; var_dump(true && false); echo EOL;
echo 'true and false: '; var_dump(true and false); echo EOL . EOL;
echo 'true || true: '; var_dump(true || true); echo EOL;
echo 'true || false: '; var_dump(true || false); echo EOL . EOL;
echo 'true or true: '; var_dump(true or true); echo EOL;
echo 'true or false: '; var_dump(true or false); echo EOL . EOL;

echo 'Exclusive Or:' . EOL;
$a = $b = true;
echo '$a is '; var_dump($a); echo EOL;
echo '$b is '; var_dump($b); echo EOL;
echo '$a xor $b is '; var_dump($a xor $b); echo EOL;
echo '($a or $b) and !($a and $b) is '; var_dump(($a or $b) and !($a and $b)); echo EOL;
echo EOL;

$b = false;
echo '$a is '; var_dump($a); echo EOL;
echo '$b is '; var_dump($b); echo EOL;
echo '$a xor $b is '; var_dump($a xor $b); echo EOL;
echo '($a or $b) and !($a and $b) is '; var_dump(($a or $b) and !($a and $b)); echo EOL;
echo EOL;

$a = false;
echo '$a is '; var_dump($a); echo EOL;
echo '$b is '; var_dump($b); echo EOL;
echo '$a xor $b is '; var_dump($a xor $b); echo EOL;
echo '($a or $b) and !($a and $b) is '; var_dump(($a or $b) and !($a and $b)); echo EOL;
echo EOL;

# Watch those precedence rules!
$result = $a xor $b;
echo '$result is '; var_dump($result); echo EOL;

echo 'true or false and false evaluates to '; var_dump(true or false and false); echo EOL;
echo 'true || false and false evaluates to '; var_dump(true || false and false); echo EOL;
//http://www.php.net/manual/en/language.operators.php#language.operators.precedence

# PHP applies short-circuit boolean evaluation
if (fopen() or die('error message')) {

}

# if ... else exercise
$EOL = '<br />';
$dayOfWeek = 'Thursday';
if ('Friday' === $dayOfWeek) {
   echo "See you on Monday!$EOL";
} else {
   echo "See you tomorrow!$EOL";
}

//# shorthand conditionals
$a = 6;
echo 'Before the if statement, $a has the value: ' . $a . '<br />';
if ($a > 10) {
	$a = 10;
}
echo 'After the if statement, $a has the value: ' . $a . '<br />';

$a = 6;
echo 'Before the ternary operator, $a has the value: ' . $a . '<br />';
$a = $a > 10 ? 10 : $a;

$a = $a > 10 // condition
   ? ($a < 50 ? 30 : 100) // 'then'
   : $a; // 'else'
echo 'After the ternary operator, $a has the value: ' . $a . '<br />';

echo 'Precedence rules: Ternary operator in a string: ' . $a > 10 ? 10 :$a . '<br />';
echo 'Precedence rules: Ternary operator in a string: ' . ($a > 10 ? 10 : $a) . '<br />';
// common
echo 'We have ' . $monkeys . ' monkey' . ($monkeys > 1 ? 's' : '') . '.<br />';

$DayOfWeek = 'Wednesday';
echo "See you " . (($DayOfWeek == "Friday") ? "Monday" : "tomorrow");
exit;

// Simple ecommerce (Credit card verfication calculation) example using if and switch
// http://www.zend.com/code/codex.php?ozid=80&single=1

echo "\nConditional exercise\n";
$a = true;
$b = false;

if ($a || $b) {
    echo "Execute this code\n";
}

switch (true) {
	case $a:
	case $b:
        echo "Execute this code\n";
		break;

	default:
		break;
}

exit;
echo "\nLooping practice\n";
echo "For loop<br />";
// can do multiple inits and updates: for ($i = 1, $j = 0; $i < 11; $i++, $j--) {
for ($i = 1; $i < 11; $i++) {
	echo "\$i is $i<br />";
}

echo '<br />';

echo "While loop<br />";
$i = 1;
while ($i < 11) {
	echo "\$i is $i<br />";
	 $i++;
}
echo '<br />';

echo "do-while loop<br />";
$i = 1;
do {
	echo "\$i is $i<br />";
	$i++;
} while ($i < 11);
echo '<br />';

$EOLN = '<br />';

echo $EOLN . 'Continue statement' . $EOLN;
for ($i = 0; $i <= 5; $i++) {
   if (3 == $i) {
		continue;
   }
   echo "The number is " . $i . $EOLN;
}


echo $EOLN . 'Break statement' . $EOLN;
for ($i = 0; $i <= 5; $i++) {
   if (3 == $i) {
		break;
   }
   echo "The number is " . $i . $EOLN;
}

$array = array(
    1 => range(1, 4),
    2 => range(1, 4),
    3 => range(1, 4)
);
foreach ($array as $key => $value) {
	if ($key % 2 === 0) {
	    continue;
	}
	echo $key . ': ' . implode(', ', $value) . "\n";
}

exit;
echo "\nForeach exercise - slide 39\n";
$array = explode(' ', 'Zend Training - Building Security into Your PHP Applications');
foreach ($array as $key => $value) {
	$array[$key] = strtoupper($value);
}

// alternatively...
$array = explode(' ', 'Zend Training - Building Security into Your PHP Applications');
foreach ($array as &$value) {
	$value=strtoupper($value);
}

// how many functions are on your system?
$definedFunctions = get_defined_functions();
echo 'There are ' . count($definedFunctions['internal']) . ' functions on my system' . PHP_EOL;


# Optional parameters
$junkyString = "|this is my string,hi,\n|";
echo $junkyString . '<br />';
echo trim($junkyString, "|,\n") . '<br />';
var_dump($junkyString, trim($junkyString));
# http://www.php.net/manual/function.trim.html

# Declaring Optional parameters
function myOptionalParmFunction ($parm1, $parm2 = 'World') {
	return "$parm1 $parm2";
}

echo myOptionalParmFunction('Hi there') . '<br />';
echo myOptionalParmFunction('Hi there', 'Slartibartfast!') . '<br />';


//function myOptionalParmFunction ($parm1, $parm2 = array('this', 'that', 'the other')) {
//	return array ($parm1, $parm2);
//}
//$returnValue = myOptionalParmFunction(458, 'a test string');
//echo '<pre>'; var_dump($returnValue); echo '</pre>';

$returnValue = myOptionalParmFunction(true);
echo '<pre>'; var_dump($returnValue); echo '</pre>';
exit;

function optional_arguments($required, $optional = 'OptOne', $also_optional = 'OptTwo')
{
	var_dump($optional);
	return "\$required is $required; \$optional is $optional; \$also_optional is $also_optional";
}

// If you pass any optional parameter a value, you must also pass all optional parameters to the the left of that parameter.
echo 'Pass only $required: ' . optional_arguments(35) . $EOLN;
echo 'Pass $required and middle argument: ' . optional_arguments(35, 'middle') . $EOLN;
//echo 'No way to pass only $required and third arguments: ' . optional_arguments(35, , 'middle') . $EOLN;
echo 'No way to pass only $required and third arguments: ' . optional_arguments(35, null, 'third') . $EOLN;
// see http://www.php.net/manual/en/functions.arguments.php#functions.arguments.default
// for a good example, see http://php.net/mktime

// writing functions exercise - slide 46
// previous Student code
//function getName($firstName, $lastName, $middleInitial) {
//
//	return ucfirst($lastName).", ".ucfirst($firstName)." ".ucfirst($middleInitial).".";
//
//}
//

//function getName($first, $last, $middle = null) {
//	$temp = ucfirst($last) ucfirst($first)
//	if (null != $middle){
//		$temp = $temp . ' ' . ucfirst($middle) . '.';
//	}
//	return $temp;
//}
//exit;
function getName($first, $last, $middle = null)
{
	$name = ucfirst(strtolower($last)) . ', ' . ucfirst(strtolower($first));
	if (null !== $middle) {
		$name .= ' ' . ucfirst(strtolower($middle)) . '.';
	}
	return $name;
}

echo getName('john', 'smith', 'k') . "\n";
echo getName('john', 'sMITH') . "\n";

