<?php
// Simple producer writes to a data file.
$args = ZendJobQueue::getCurrentJobParams();

if (empty($args)) {
    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, 'Producer A given no output filepaths');
    return;
}

$datum = date('Y-m-d H:i:s - \A');

$numBytes = file_put_contents(
    $args['output_directory'] . '/' . $args['data_filename'],
    $datum . PHP_EOL,
    FILE_APPEND | LOCK_EX
);

if (false === $numBytes) {
    $errorMessage = 'Producer A failed to write to output file ' . $datum;
    error_log($errorMessage, 3, $args['output_directory'] . '/' . $args['errorlog_filename'] . PHP_EOL);
    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, $errorMessage);
    return;
}
ZendJobQueue::setCurrentJobStatus(ZendJobQueue::OK, 'message is ignored on success');
echo $datum;
error_log($datum . PHP_EOL, 3, $args['output_directory'] . '/' . $args['errorlog_filename']);

