<?php

$unixTimestampNow = time();
$timestampNow = date('Y-m-d H:i:s', $unixTimestampNow);

$minute     = '*/3'; // every minute evenly-divisble by 3 (this is NOT three minutes from the moment this job is scheduled)
$hour       = '*'; // every hour
$dayOfMonth = '*';
$month      = '*';
$dayOfWeek  = '*';
$schedule   = "$minute $hour $dayOfMonth $month $dayOfWeek";
$jobName    = 'Job 1 Recurring via API';

$q = new ZendJobQueue();
$id = $q->createHttpJob(
    '/job_one.php', // URL to job script, relative to DOCROOT
    array( // arguments passed to the job script
        'starting_script_name' => $_SERVER['PHP_SELF'],
        'initiated' => $timestampNow,
        'scheduled_as' => $schedule,
        'name' => $jobName,
    ),
    array( // job options (scheduling, etc.)
        'name' => $jobName,
        'schedule' => $schedule,
    )
);
if (!is_int($id)) {
    echo 'Job was not created';
    exit(1);
}
echo '<p>Job ', $id, ' scheduled for recurring runs.</p>'
   , '<p>Job status is ', print_r($q->getJobStatus($id), true), '</p>';
/*
Look in Overview | Dashboard (or Events) for errors;
look in Overview | Job Queue for job status.
*/

