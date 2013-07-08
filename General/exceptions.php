<?php
class myException extends Exception {

    public function __construct($value) {
        if ($value == 'specialError') {
            throw new Exception('oops: special error');
        } else {
            throw new Exception('oops: generic error');
        }
    }

}

try {
    $e = new myException('unknownError');
//} catch (myException $ex) {
} catch (Exception $ex) {
    echo 'Error: ', $ex->getMessage(), PHP_EOL;
}

