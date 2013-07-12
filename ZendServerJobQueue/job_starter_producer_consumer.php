<?php
/* This example demonstrates the relationship between a job and its predecessor.

   Starter -> creates producer
   Starter -> creates consumer
*/

try {
    $jq = new ZendJobQueue();
    $producer_Id = $jq->createHttpJob(
        '/simple_producer.php',
        array('data_filename' => 'producer_consumer_datafile.txt'),
        array(
            'name' => 'producer',
            'schedule_time' => date('Y-m-d h:i:s', strtotime('now')),
        )
    );
    if (! is_int($producer_Id)) {
        exit('Producer not created. Exiting...');
    }

    $consumer_Id = $jq->createHttpJob(
        '/simple_consumer.php',
        array('data_filename' => 'producer_consumer_datafile.txt'),
        array(
            'name' => 'consumer',
            'schedule_time' => date('Y-m-d h:i:s', strtotime('now')),
        )
    );
    if (! is_int($consumer_Id)) {
        echo 'Consumer not created. Exiting...';
    }
} catch (ZendJobQueueException $e) {
    echo 'Exception creating consumer';
}

