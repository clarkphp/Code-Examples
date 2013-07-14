<?php
/* This example demonstrates the relationship between a job and its predecessor.

   Starter -> creates producer
   Starter -> creates consumer
*/

$jobArgs = array(
    'output_directory' => __DIR__,
    'data_filename' => 'producer_consumer_datafile.txt',
    'errorlog_filename' => 'producer_consumer_errorfile.txt',
);

try {
    $jq = new ZendJobQueue();

    $producer_Id = $jq->createHttpJob(
        '/simple_producer.php',
        $jobArgs,
        array(
            'name' => 'Producer A',
            'schedule_time' => date('Y-m-d h:i:s', strtotime('now') + 2),
        )
    );
    if (! is_int($producer_Id)) {
        $errorMessage = 'Producer A not created. Exiting';
        error_log($errorMessage, 3, $args['output_directory'] . '/' . $args['errorlog_filename'] . PHP_EOL);
        exit($errorMessage) . '<br>';
    }
    echo 'Producer A sheduled<br>';

    $consumer_Id = $jq->createHttpJob(
        '/simple_consumer.php',
        $jobArgs,
        array(
            'name' => 'Consumer X',
            'schedule_time' => date('Y-m-d h:i:s', strtotime('now') + 2),
        )
    );
    if (! is_int($consumer_Id)) {
        $errorMessage = 'Consumer X not created. Exiting';
        error_log($errorMessage, 3, $args['output_directory'] . '/' . $args['errorlog_filename'] . PHP_EOL);
        exit($errorMessage) . '<br>';
    }

} catch (ZendJobQueueException $e) {
    echo 'Exception...<br>';
}

