<?php
// Simple consumer reads to a data file.
$args = ZendJobQueue::getCurrentJobParams();

if (empty($args)) {
    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, 'Consumer X given no output filepaths');
    return;
}

if (false === ($fh = fopen($args['output_directory'] . '/' . $args['data_filename'], 'r+'))) {
    $errorMessage = 'Consumer X failed to open data file at ' . date('Y-m-d H:i:s - \X');
    error_log($errorMessage, 3, $args['errorlog_filename'] . PHP_EOL);
    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, $errorMessage);
    return;
}

if (! flock($fh, LOCK_EX)) {  // acquire an exclusive lock
    $errorMessage = 'Consumer X failed to obtain a lock on the data file at ' . date('Y-m-d H:i:s - \X');
    error_log($errorMessage, 3, $args['output_directory'] . '/' . $args['errorlog_filename'] . PHP_EOL);
    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, $errorMessage);
    return;
}

$buffer = '';
while (false !== ($line = fgets($fh, 255))) {
    $buffer .= $line;
}
if (!feof($fh)) {
    $errorMessage = 'Consumer X encountered error while reading data file at ' . date('Y-m-d H:i:s - \X');
    error_log($errorMessage, 3, $args['output_directory'] . '/' . $args['errorlog_filename'] . PHP_EOL);
    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, $errorMessage);
    flock($fh, LOCK_UN); // hope we can release lock
    fclose($fh);
    return;
}

ZendJobQueue::setCurrentJobStatus(ZendJobQueue::OK);
echo nl2br($buffer, false);

if (! flock($fh, LOCK_UN)) { // release lock
    $errorMessage = 'Consumer X failed to release the lock on the data file at ' . date('Y-m-d H:i:s - \X');
    error_log($errorMessage, 3, $args['output_directory'] . '/' . $args['errorlog_filename'] . PHP_EOL);
    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, $errorMessage);
    return;
}

fclose($fp);

