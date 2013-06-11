<?php
$e = 10;

function get($a, $b, $c = 3) {
    global $e;

    $d = 4 + $a;
    $x = function($a, $b, $c) /* use ($d, $e) */ {
        echo "[$a, $b, $c, $d]\n";
        $d++;
        $e++;
    };
    $x($b, $a, $c);
}

get(2, 3);
get(2, 3, 5);

