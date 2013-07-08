<?php
// regular expressions - slides 101 to 122
// http://www.regular-expressions.info/
// http://www.regular-expressions.info/tutorial.html
// http://www.visibone.com/regular-expressions/

// Regular expression tester at http://www.quanetic.com/regex.php
// http://www.regular-expressions.info/books.html
// Multi-byte string functions: http://www.php.net/manual/en/ref.mbstring.php

define('EX_DELIMITER_STR', "\n------\n");
$matches = array();

// Find if Bill or William is present in a string.
$pattern = '#Bill|William#';
$test_strings = array('Three Billy Goats Gruff', 'Little Richard',
                      'William Styron', 'Free Willy');
foreach ($test_strings as $string) {
	echo $string;
	if (preg_match($pattern, $string)) {
		echo ": Found it!\n";
	} else {
		echo ": Not there.\n";
	}
}
echo EX_DELIMITER_STR;

echo (preg_match('/^the$/', 'the') ? 'matched' : 'not matched') . PHP_EOL;
echo (preg_match('/^the$/', "the\nthe\n") ? 'matched' : 'not matched') . PHP_EOL;
echo (preg_match('/^the\Z/', 'the') ? 'matched' : 'not matched') . PHP_EOL;
echo (preg_match('/^the\Z/', "the\nthe\n") ? 'matched' : 'not matched') . PHP_EOL;
echo (preg_match('/^the\z/', "the\nthe\n") ? 'matched' : 'not matched') . PHP_EOL;
exit;
// Check Your Understanding - slide 104
// see http://php.net/preg_match_all
$pattern = '#(thor|thr)ough#';
$string = 'Hey, throughout the whole day, I\'m thoroughly stoked, even though my throat hurts.';
preg_match_all($pattern, $string, $matches);
print_r($matches);
echo "\n";

// this does NOT match one or more numbers from 1 to 25
$pattern = '/[1-25]+/';
$string = 'I can eat 25 doughnuts at 1 sitting, or maybe really only 10.';
preg_match_all($pattern, $string, $matches);
print_r($matches);

// a single digit from 1-9, or
// 1 followed by any single digit; i.e., 1-19, or
// 2 followed by any single digit from 0-5
echo "Match one or more numbers from 1 to 25:\n";
$pattern = '/2[0-5]|1\d|[1-9]/';
$string = 'I can eat 224 doughnuts at 1 sitting, or maybe really only 10.';
preg_match_all($pattern, $string, $matches);
print_r($matches);

echo EX_DELIMITER_STR;


exit;
// Check Your Understanding - slide 109
// Alter the following to match text before the @ in an email address
echo "Match text before the @ in an email address - does not work\n";
$pattern = '/[A-Za-z0-9._]+@/';
$address = 'cla|rk@.everetts@gmail.comclark@.everetts@gmail.com';
preg_match($pattern, $address, $matches);
print_r($matches);

echo "Match text before the @ in an email address - works\n";
$pattern = '/^[-A-Za-z0-9\._]+@/';
//$pattern = '/^[-\w\.]+@/'; // doesn't work
$address = 'clark.everetts@gmail.com';
$address = 'cla|rk@.everetts@gmail.comclark@.everetts@gmail.com';
preg_match($pattern, $address, $matches);
print_r($matches);

echo EX_DELIMITER_STR;
exit;
echo "Match domain name up to the first period after the @ in an email address\n";
$pattern = '/(?:@)([A-Za-z0-9]+\.)/';
$pattern = '/(?:@)([-\w\.]+\.)/';
$address = 'clark.everetts@gmail.com';
//$address = 'cla|rk@.everetts@gmail.comclark@.everetts@gmail.com';
preg_match($pattern, $address, $matches);
print_r($matches);

echo "Match top-level domain name characters in an email address\n";
$pattern = '/[A-Za-z]{2,4}\Z/';
$address = 'clark.everetts@gmail.com';
// next address has a match, showing the pattern isn't quite correct
//$address = 'cla|rk@.everetts@gmail.comclark@.everetts@gmail.com';
preg_match($pattern, $address, $matches);
print_r($matches);

echo EX_DELIMITER_STR;

echo "Exercise slide 112: validating a URL\n";
$pattern = '/^[-\w\.]+\.[A-Za-z]{2,4}$/';
$address = 'www.bbc.co.uk';
$address = 'news.bbc.co.uk';
//$address = 'www.bbc.co.uk/worldservice/';
preg_match($pattern, $address, $matches);
print_r($matches);

echo "Match URLs with path\n";
$pattern = '/^[\w\.]+\.[A-Za-z]{2,4}\/(?:\w){3,20}\/{0,1}$/';
$address = 'www.bbc.co.uk/worldservice/';
preg_match($pattern, $address, $matches);
print_r($matches);

echo EX_DELIMITER_STR;

// See this part of the manual
// http://www.php.net/manual/en/regexp.reference.assertions.php
echo "Checking for a strong password: 
at least 8 characters and must contain one lower case letter, one upper case
letter and one number ... change this so it must have one upper case character
and one special character.\n";
$password = "Fyfjk34sdfjfsjq7";
//$password = "Ffk34sd";
if (preg_match('/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $password)) {
    echo "Your password is strong.\n";
} else {
	echo "Your password is weak\n";
}
echo EX_DELIMITER_STR;

// Pattern modifiers - see php.net for more discussion
$phone_number_bad  = '92-123-3456';
$phone_number_good = '921-123-3456';

/**
 * Determine whether or not a phone number is formatted like
 * a valid U.S. phone number.
 * 
 * This regex pattern is very limited and is used merely as an example!
 * E.g., (931) 123-4567 would fail this pattern, even though it is valid.
 *
 * @param string $number
 * @return boolean true if valid format, false if not
 */
function validate_us_phone_number($number) {
	$valid_number = '/# extended mode - ignore whitespace chars in pattern
        # also, ignore any chars between # and newline
        # useful for documenting your regex patterns
        \d{3} # area code
        - # separator character
        \d{3} # exchange
        - # separator character
        \d{4} # station
	/x';
	return preg_match($valid_number, $number) ? true : false;
}

echo $phone_number_bad . ' ';
if (validate_us_phone_number($phone_number_bad)) {
	echo "is a valid U.S. phone number\n";
} else {
	echo "is not a valid U.S. phone number\n";
}

echo $phone_number_good . ' ';
if (validate_us_phone_number($phone_number_good)) {
	echo "is a valid U.S. phone number\n";
} else {
	echo "is not a valid U.S. phone number\n";
}
echo EX_DELIMITER_STR;

// Slide 119 - Other string-processing functions can be faster than using regex.
$test_string = 'I have alphabetic and 1 or 2 numeric characters only.';
echo ctype_alnum($test_string)
   ? "Alphanumeric only\n"
   : "Has other than alphanumeric characters\n";
echo EX_DELIMITER_STR;

echo ctype_print($test_string)
   ? "This is a printable string\n"
   : "Something in here is not printable\n";
echo EX_DELIMITER_STR;

if (preg_match('/have/', $test_string)) { // note data type of return value
	echo "preg_match says the test string contains the word 'have'.\n"
	   . EX_DELIMITER_STR;
}
if (false !== strpos($test_string, 'have')) { // again, note possible return values
	echo "strpos says the test string contains the word 'have'.\n"
	   . EX_DELIMITER_STR;
}


// Exercise slide 120 (use myfile_slide_120.txt)
echo preg_replace('/C\+\+|Java/',
                  'PHP',
                  file_get_contents('myfile_slide_120.txt'))
   . EX_DELIMITER_STR;

echo preg_replace(array('/C\+\+/', '/Java/'),
                  'PHP',
                  file_get_contents('myfile_slide_120.txt'))
   . EX_DELIMITER_STR;

///// Slide 114 - More examples; probably should modify before using them:
if (preg_match("/ell/", "Hello World!", $matches)) {
	echo "Match was found <br />";
	echo $matches[0];
}

if (preg_match("/ll.*/", "The History of Halloween", $matches)) {
	echo "Match was found <br />";
	echo $matches[0];
}

// Checking for strong password - at least 8 characters and must contain one lower case letter, one upper case letter and one number
// change it to be one upper case character and one special character
$password = "Fyfjk34sdfjfsjq7";
if (preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) {
	echo "Password is strong.";
} else {
	echo "Password is weak.";
}

// Can rewrite this to use preg_match() instead of eregi
if (!$_POST['action']) { ?>
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>Email Address: <input type='text' name='email'>  <input type='hidden' name='action' value='validate'>
   <p><input type='submit' value='Submit'></p>
</form>
<?php
}
if ($_POST['action'] == 'validate') {
	if (eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$',
	          $_POST['email'])) {
		echo 'Valid';
	} else {
		echo 'Invalid';
	}
}
