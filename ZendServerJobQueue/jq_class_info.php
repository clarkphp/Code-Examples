<?php
// Job Queue Class Information
$info = new ReflectionClass('ZendJobQueue');

echo '<pre>Class Constants - ', print_r($info->getConstants(), true), '</pre>';

echo '<pre>Many of these methods DO actually take parameters.</pre>';
foreach ($info->getMethods() as $method) {
    try {
        echo '<pre>', $method, '</pre>';
    } catch (Exception $e) {
        echo '<pre>Some error happened. Pressing on...</pre>';
    }
}

