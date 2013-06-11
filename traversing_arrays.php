<?php
$cards = array('hearts'   => array('Ace', '2'   , '3'),
               'diamonds' => array('4'  , '5'   , '6'),
               'spades'   => array('7'  , '8'   , '9'),
               'clubs'    => array('10' , 'Jack', 'Queen')
         );
print_r($cards);
var_dump( ${next($cards)}[2]);
exit;
$myArray = array(7 => 1, 2, 3);
$myArray[] = 4;
$myArray[2] = 5;
print_r($myArray); echo PHP_EOL;

reset($myArray);
next($myArray);

echo current($myArray);
echo key($myArray), PHP_EOL;

