<?php
// benchmark if-else vs. switch using microtime()
// test time of statements, not output to screen

define('ITERATIONS', 1000);
$dayOfWeek = 'Tuesday'; // force to final code branch

$start = microtime(true);
// how long does if take?
for ($index = 0; $index < ITERATIONS; $index++) {
	if($dayOfWeek == "Friday"){
		$a = 1;
	} elseif (($dayOfWeek == "Saturday") || ($dayOfWeek == "Sunday")) {
		$a = 1;
	} else {
	    $a = 1;
	}
}
$end = microtime(true);
echo "Total time for if is " . ($end - $start) . PHP_EOL;

$start = microtime(true);
// how long does switch take?
for ($index = 0; $index < ITERATIONS; $index++) {
	switch ($dayOfWeek) {
		case 'Friday':
		   $a = 1;
		break;
		case 'Saturday':
		case 'Sunday':
	       $a = 1;
	    break;
		default:
		   $a = 1;
		break;
	}
}
$end = microtime(true);
echo "Total time for switch is " . ($end - $start) . PHP_EOL;