<?php
# Unit testing
# http://www.phpunit.de/
# http://www.simpletest.org/

# Turn error reporting up to prevent undefined variables resulting from typos.
error_reporting(E_ALL | E_STRICT);

# File/class not found?  See what the include path is, or what
# files are included at that point in the code.
echo get_include_path();
var_dump(get_included_files());

# In development (NOT production!), turn display_errors ON.
# In production, log errors to a file and check the logs to find and debug problems.
# see the error_log directive
# File locations - be careful with relative path names fopen('../input_file.txt');
# Current working directory might have changed in your script, or your code might
# be deployed differently that it was on your dev machine.

# For more, see these pages, and those they refer to:
# http://www.php.net/manual/en/errorfunc.configuration.php
# http://www.php.net/manual/en/function.error-reporting.php


# phpDocumentor at http://www.phpdoc.org/

# Error handling
# http://www.php.net/manual/en/security.errors.php
# http://www.php.net/manual/en/function.set-error-handler.php

// we will do our own error handling
error_reporting(0);

// user defined error handling function
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars) 
{
    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s (T)");

    // define an assoc array of error string
    // in reality the only entries we should
    // consider are E_WARNING, E_NOTICE, E_USER_ERROR,
    // E_USER_WARNING and E_USER_NOTICE
    $errortype = array (
                E_ERROR              => 'Error',
                E_WARNING            => 'Warning',
                E_PARSE              => 'Parsing Error',
                E_NOTICE             => 'Notice',
                E_CORE_ERROR         => 'Core Error',
                E_CORE_WARNING       => 'Core Warning',
                E_COMPILE_ERROR      => 'Compile Error',
                E_COMPILE_WARNING    => 'Compile Warning',
                E_USER_ERROR         => 'User Error',
                E_USER_WARNING       => 'User Warning',
                E_USER_NOTICE        => 'User Notice',
                E_STRICT             => 'Runtime Notice',
                E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
                );
    // set of errors for which a var trace will be saved
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
    
    $err = "<errorentry>\n"
         . "\t<datetime>"      . $dt    . "</datetime>\n"
         . "\t<errornum>"      . $errno . "</errornum>\n"
         . "\t<errortype>"     . $errortype[$errno] . "</errortype>\n"
         . "\t<errormsg>"      . $errmsg   . "</errormsg>\n"
         . "\t<scriptname>"    . $filename . "</scriptname>\n"
         . "\t<scriptlinenum>" . $linenum  . "</scriptlinenum>\n";

    if (in_array($errno, $user_errors)) {
        $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
    }
    $err .= "</errorentry>\n\n";
    
    // for testing
    // echo $err;

    // save to the error log, and e-mail me if there is a critical user error
    /*
    error_log($err, 3, "/usr/local/php4/error.log");
    if ($errno == E_USER_ERROR) {
        mail("phpdev@example.com", "Critical User Error", $err);
    }
    */
}


function distance($vect1, $vect2) 
{
    if (!is_array($vect1) || !is_array($vect2)) {
        trigger_error("Incorrect parameters, arrays expected", E_USER_ERROR);
        return NULL;
    }

    if (count($vect1) != count($vect2)) {
        trigger_error("Vectors need to be of the same size", E_USER_ERROR);
        return NULL;
    }

    for ($i=0; $i<count($vect1); $i++) {
        $c1 = $vect1[$i]; $c2 = $vect2[$i];
        $d = 0.0;
        if (!is_numeric($c1)) {
            trigger_error("Coordinate $i in vector 1 is not a number, using zero", 
                            E_USER_WARNING);
            $c1 = 0.0;
        }
        if (!is_numeric($c2)) {
            trigger_error("Coordinate $i in vector 2 is not a number, using zero", 
                            E_USER_WARNING);
            $c2 = 0.0;
        }
        $d += $c2*$c2 - $c1*$c1;
    }
    return sqrt($d);
}

$old_error_handler = set_error_handler("userErrorHandler");

// undefined constant, generates a warning
$t = I_AM_NOT_DEFINED;

// define some "vectors"
$a = array(2, 3, "foo");
$b = array(5.5, 4.3, -1.6);
$c = array(1, -3);

// generate a user error
$t1 = distance($c, $b) . "\n";

// generate another user error
$t2 = distance($b, "i am not an array") . "\n";

// generate a warning
$t3 = distance($a, $b) . "\n";

/////////////////////////////
# Exceptions
# http://www.php.net/manual/en/language.exceptions.php
function inverse($x) {
    if (!$x) {
        throw new Exception('Division by zero.');
    }
    else return 1/$x;
}

try {
    echo inverse(5) . "\n";
    echo inverse(0) . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// Continue execution
echo 'Hello World';


// checking return values
$haystack = 'I am a string.';
$needle = 'a';

if (strpos($haystack, $needle)) {
	echo  'Found string' . PHP_EOL;	
} else {
	echo 'Not found' . PHP_EOL;
}

$haystack = 'a string am I.';
if (strpos($haystack, $needle)) {
	echo  'Found string' . PHP_EOL;	
} else {
	echo 'Not found' . PHP_EOL;
}





