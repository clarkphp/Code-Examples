<?php
/*
 * This example script demonstrates basic concepts related to Job Queue:
 * 1. shows the names and values of several JQ-related class constants
 * 2. setting a job's status from within the job script
 * 3. obtaining a list of jobs JQ is aware of, whehter waiting, running, or completed
 * 4. restarting jobs that have completed
 * -. more...

 * See the usage message in the code below for instructions.
*/
if (!class_exists('ZendJobQueue')) {
    exit('<p>Jobqueue class does not exist within this PHP runtime. good bye!</p>');
}

$q = new ZendJobQueue();

$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";

// filesystem-based switch each job will inspect to see if it should fail or succeed
$switchFilename = 'flag';

/*
Note that the MAX_JOBS value does not have to remain below zend_jobqueue.max_http_jobs,
but if it is higher, you will get "Job Queue reached a high concurrency level" GUI notifications.
*/
define('MAX_JOBS', 4);

$jobName = 'parapapa';
$jobListQuery = array ('name' => $jobName);

// Display Statuses for getJobsList()
if (isset($_GET['s']) || isset($_GET['statuses'])) {
    $JqStatusConstants = array(
        'ZendJobQueue::STATUS_PENDING',
        'ZendJobQueue::STATUS_WAITING_PREDECESSOR',
        'ZendJobQueue::STATUS_RUNNING',
        'ZendJobQueue::STATUS_COMPLETED',
        'ZendJobQueue::STATUS_FAILED',
        'ZendJobQueue::STATUS_OK',
        'ZendJobQueue::STATUS_LOGICALLY_FAILED',
        'ZendJobQueue::STATUS_TIMEOUT',
        'ZendJobQueue::STATUS_REMOVED',
        'ZendJobQueue::STATUS_SCHEDULED',
        'ZendJobQueue::STATUS_SUSPENDED',
        'ZendJobQueue::JOB_STATUS_PENDING',
        'ZendJobQueue::JOB_STATUS_WAITING_PREDECESSOR',
        'ZendJobQueue::JOB_STATUS_RUNNING',
        'ZendJobQueue::JOB_STATUS_COMPLETED',
        'ZendJobQueue::JOB_STATUS_FAILED',
        'ZendJobQueue::JOB_STATUS_OK',
        'ZendJobQueue::JOB_STATUS_LOGICALLY_FAILED',
        'ZendJobQueue::JOB_STATUS_TIMEOUT',
        'ZendJobQueue::JOB_STATUS_REMOVED',
        'ZendJobQueue::JOB_STATUS_SCHEDULED',
        'ZendJobQueue::JOB_STATUS_SUSPENDED'
    );
    foreach ($JqStatusConstants as $v) {
        echo "$v = " . constant($v) . '<br>';
    }
    echo '<br>Note especially these two:<br>ZendJobQueue::STATUS_OK: '
       , ZendJobQueue::STATUS_OK
       , '<br>ZendJobQueue::JOB_STATUS_OK: '
       , ZendJobQueue::JOB_STATUS_OK
       , '<br>';
}

// Job functionality
if (isset($_GET['job']) && isset($_GET['job_status_switch'])) {
    $jobStatus = file_get_contents($switchFilename);
    if (false === $jobStatus) {
        exit('Could not open status switch file. Check permissions.<br>');
    }
    if ($jobStatus === 'fail') {
        ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, 'Setting Job Status FAILED');
        echo 'Setting Job Status ZendJobQueue::FAILED<br>';
        return; // can also exit
    }
    ZendJobQueue::setCurrentJobStatus(ZendJobQueue::OK, 'Setting Job Status ZendJobQueue::OK');
    echo 'Setting Job Status ZendJobQueue::OK<br>';
} else { // All other steps
    echo <<<EOT
<pre><a href="$url">Usage:</a>
Behaviour is controlled by URL query parameters.
Passing ?job causes the script to act as a Job Queue job.
    (Otherwise, as the Steps script)

See relevant <a href="$url?statuses">status code constants</a> by passing by ?statuses

<a href="$url?step=1">Step=1</a>: set flag fail
<a href="$url?step=2">Step=2</a>: set X jobs which will fail
Check ZS GUI for Failed Jobs
<a href="$url?step=3">Step=3</a>: get list of jobs - should be showing failed
<a href="$url?step=4">Step=4</a>: set flag success
<a href="$url?step=5">Step=5</a>: restart all failed jobs - in chunks of Y
CHECK ZS GUI for Success Jobs
<a href="$url?step=6">Step=6</a>: get list of jobs - should be showing successful
<a href="$url?step=7">Step=7</a>: delete the test jobs
<a href="$url?step=8">Step=8</a>: get list of jobs - should show empty array
Also CHECK ZS GUI for Verifying Deleted Jobs
</pre>
EOT;

    $step = isset($_GET['step']) ? (integer) $_GET['step'] : 0;
    switch ($step) {
        case 0:
            // do nothing if no step query parameter was passed
            break;
        case 1:
            if (file_put_contents($switchFilenameg, 'fail') === false) {
                exit ('Could not write to flag file - check permissions for PHP. byebye!');
            }
            echo 'Flag file was set to fail<br>';
            break;

        case 2:
            for ($i = 0; $i < MAX_JOBS; $i++) {
                //$jobId = $q->createHttpJob("$url?job", array('microtime'=>microtime()), array('name'=>$jobName,'schedule_time' => date('Y-m-d h:i:s', strtotime('+1s'))) );
                $jobId = $q->createHttpJob(
                      "$url?job",
                      array('microtime' => microtime()),
                      array('name' => $jobName,
                      'schedule_time' => date('Y-m-d h:i:s', strtotime('now')))
                );
                echo "New Job URL: $url ID: $jobId.<br>";
            }
            break;

        case 3:
        case 6:
        case 8:
            echo '<pre>' . print_r($q->getJobsList($jobListQuery), true) . '</pre>';
            break;

        case 4:
            if (file_put_contents($switchFilename, 'succeed') === false) {
                exit ('Could not write to flag file - check permissions for PHP. byebye!');
            }
            echo 'Flag file was set to 0<br>';
            break;

        case 5:
            $jobList = $q->getJobsList($jobListQuery);
            $restartCounter = 0;
            foreach($jobList as $v) {
                if ($q->restartJob($v['id'])) {
                    $restartCounter++;
                }
            }
            echo "Restarted $restartCounter Jobs<br>";
            break;

        case 7:
            $jobList = $q->getJobsList($jobListQuery);
            $deleteCounter = 0;
            foreach($jobList as $v) {
                if ($q->removeJob($v['id'])) {
                    $deleteCounter++;
                }
            }
            echo "Deleted $deleteCounter Jobs<br>";
            break;

        default;
            echo 'You need to set URL with a ?step= value in valid range. See the instructions above.<br>';
            break;
    }
}

