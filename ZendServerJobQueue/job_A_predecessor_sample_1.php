<?php
// Job A writes to a file
// No direct communication between A and B

$args = ZendJobQueue::getCurrentJobParams();
$filepath = '';

if (empty($args)) { // could be wise to validate contents of each array element
    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, 'A; No output filepath supplied');
    return -1;
}

$filepath = $args['output_directory'] . DIRECTORY_SEPARATOR . $args['output_file_name'];
for ($i = 0; $i < 5; $i++) {
    if (!writeData($filepath, $i)) {
        ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, 'A: Failure writing to output file');
        return -1;
    }
}

ZendJobQueue::setCurrentJobStatus(ZendJobQueue::OK, 'A: Finished. See ' . $args['output_file_name']);

function writeData($outputFilepath, $datum) {
    sleep(3); // simulate taking some time to work
    if (false === file_put_contents(
        $outputFilepath,
        date('Y-m-d H:i:s') . ' - A: iteration ' . $datum . PHP_EOL,
        FILE_APPEND
        )) // assume for now no other PHP script attempts to write to the file
    {
        return false;
    }

    return true;
}

