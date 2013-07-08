<?php
function doSomething($string, array $array = null) {}

$arg1 = array(1, 2, 3);
$arg2 = new ArrayObject();

doSomething('Pass an Array', $arg1);
doSomething('Pass an ArrayObject', $arg2);

