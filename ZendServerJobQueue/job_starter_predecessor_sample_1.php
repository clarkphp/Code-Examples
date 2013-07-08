<?php
/* This example demonstrates the relationship between a job and its predecessor.

   When a job is created, one optional key in the $options argument to
   ZendJobQueue::createHttpJob(string $url, array $vars, mixed $options) is 
   'predecessor'. This is the id number of the job being designated
   as the predecessor of the job currently being scheduled.
   
   A predecessor is something that comes before another thing; in the context
   of the job queue component, a job with a predecessor will wait for
   that predecessor to complete before it (the dependent job) begin to run.

   Observe that the job id of the predecessor must be known at the time the
   dependent job is being created.

   It is important to remember that a job with a predecessor CANNOT be explicitly
   scheduled to run (i.e., do not set the 'schedule_time' options element).
   Instead, you must rely on the Job Queue Daemon to run the dependent job after
   the predecessor job completes.

   If you try to schedule a dependent job, a ZendJobQueueException is thrown, with
   the message: "Bad response from Job Queue server to a createHttpJob request.
   QLocalSocket: Remote closed." 

   This example demonstrates two jobs, in which job A is created, then job B.
   There is no communication between the jobs, and no contention for resources
   (in this case, files) the jobs need.

   Job B depends on the completion of job A, before job B can finish, forming
   what could be called a pipeline, except here B does not use any results from A.
   Nevertheless, Job A is the predecessor of Job B.

   Starter -> creates Job A, scheduling it to run immediately
   Starter -> creates Job B, telling it that Job A is its predecessor, does NOT
       specify any scheduling informtion whatsoever.
   Jobs A does its work, and upon completion, job B begins running. The jobs
       write their results to separate output files. 
   Look at the output files and the Overview | Job Queue screen to see what
       happens. You should see Job B "Waiting" until Job A finishes, a nonzero
       number next to "Jobs waiting for predecessor".
   If you play with scheduling job B, then look in Overview | Logs
       jobqueue and jqd log files for the errors.

   If you like, see the "Run n" comments below, and uncomment the various lines
   to see what happens in different situations. You can force a job to fail
   by not passing arguments to it. Look at the job scripts themselves for
   more details on the scenarios.

*/

define('EOLN', PHP_SAPI === 'cli' ? PHP_EOL : '<br>');

$q = new ZendJobQueue();

$currentUnixTimestamp = time();
$currentTime = date('Y-m-d H:i:s', $currentUnixTimestamp);
$job_A_StartTime = $currentTime;
// Use the next line is for experimenting
$job_B_StartTime = date('Y-m-d H:i:s', $currentUnixTimestamp + 5);

$id_A = startJob($q, 'A', $job_A_StartTime);
if (! is_int($id_A)) {
    echo 'Job A was not created; Job B will not be set up. Exiting...', EOLN;
    return -1;
} else {
    echo "Job A (id $id_A) is scheduled to run at $job_A_StartTime", EOLN;
}

$id = startJob($q, 'B', $job_B_StartTime, $id_A); // predecessor of B is A
if (! is_int($id)) {
    echo 'Job B was not created. Exiting...', EOLN;
    return -1;
} else {
    echo "Job B (id $id) is waiting for Job A (id $id_A).", EOLN;
}

function startJob($queue, $shortJobName, $scheduledStartTime = '', $predecessorJobId = '')
{
    $jobOptions = array(
        'name' => "$shortJobName: pred(B) is A",
        'schedule_time' => $scheduledStartTime,
    );

    // Make sure no attempt to schedule job if a predecessor is specified
    if ('' !== $predecessorJobId) {
        unset($jobOptions['schedule_time']);
        $jobOptions['predecessor'] = (integer) $predecessorJobId;
    }

    try {
        $id = $queue->createHttpJob(
            '/job_' . $shortJobName . '_predecessor_sample_1.php',

            // Run 1 - empty parameter list
            // array(),

            // Run 2 - valid output directory and file name given
            array(
                'output_directory' => __DIR__,
                'output_file_name' => 'job_' . $shortJobName . '_predecessor_sample_1.out'
            ),
            $jobOptions
        );
    } catch (ZendJobQueueException $e) {
        echo 'Exception creating job', $shortJobName, EOLN . '<pre>';
        var_dump($e);
        echo '</pre>';
        $id = false;
    }

    return $id;
}

