<?php
/* This example demonstrates the relationship between a job and its predecessor.

   When a job is created, one optional key in the $options argument to
   ZendJobQueue::createHttpJob(string $url, array $vars, mixed $options) is 
   'predecessor'. This is the id number of the job being designated
   as the predecessor of the job currently being scheduled.
   
   A predecessor is something that comes before another thing; in the context
   of the job queue component, a job with a predecessor will normally wait for
   that predecessor to complete before it (the dependent job) can complete it's
   work.

   Observe that the job id of the predecessor must be known at the time the
   dependent job is being created, regardless of when the jobs are scheduled
   to run.

   This example demonstrates two jobs, in which job A is created, then job B.
   In this example, there is no communication between the jobs, and no
   contention for resources (in this case, files) the jobs need.

// Job B depends on the completion of job A, before job B can finish, forming
// what could be called a pipeline. Job A is therefore the predecessor of Job B.

   Starter -> creates Job A, scheduling it to run immediately
   Starter -> creates Job B, telling it that Job A is its predecessor, scheduling
       it to run immediately
   Jobs A and B do their work in parallel, writing their results to separate
       output files. 
   Look at the output files and the Overview | Job Queue screen to see what
       happens.

   See the "Run n" comments below, and uncomment the various lines to see what
   happens in different situations. Look at the job scripts themselves for
   more details on the scenarios.

*/

define('EOLN', PHP_SAPI === 'cli' ? PHP_EOL : '<br>');

$q = new ZendJobQueue();

$currentTime = date('Y-m-d H:i:s', time());
$job_A_StartTime = $currentTime;
$job_B_StartTime = $currentTime;

$id = startJob($q, 'A', $job_A_StartTime);
if (! is_int($id)) {
    echo 'Job A was not created', EOLN;
} else {
    echo "Job A (id $id) is scheduled to run at $job_A_StartTime", EOLN;
}

$id = startJob($q, 'B', $job_B_StartTime);
if (! is_int($id)) {
    echo 'Job B was not created', EOLN;
} else {
    echo "Job B (id $id) is scheduled to run at $job_B_StartTime", EOLN;
}

function startJob($queue, $shortJobName, $scheduledStartTime)
{
    $id = $queue->createHttpJob(
        '/job_' . $shortJobName . '_predecessor_sample_1.php',

        // Run 1 - empty parameter list
        // array(),

        // Run 2 - valid output directory and file name given
        array(
            'output_directory' => __DIR__,
            'output_file_name' => 'job_' . $shortJobName . '_predecessor_sample_1.out'
        ),

        array(
            'name' => 'A == pred(B), parallel',
            'schedule_time' => $scheduledStartTime,
        )
    );

    return $id;
}

