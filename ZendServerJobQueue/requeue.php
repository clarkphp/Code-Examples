<?php
/*
 * This example script demonstrates basic API concepts related to Job Queue:
 * 1. shows the names and values of several JQ-related class constants
 * 2. setting a job's status from within the job script
 * 3. obtaining a list of jobs JQ is aware of, whehter waiting, running, or completed
 * 4. restarting jobs that have completed
 *
 * See the usage message in the code below for instructions.
 *
 * Zvika Dror wrote the script from which this one is derived.
*/
if (!class_exists('ZendJobQueue')) {
    exit('<p>Jobqueue class does not exist within this PHP runtime. good bye!</p>');
}

$q = new ZendJobQueue();

$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";

// filesystem-based switch each job will inspect to see if it should fail or succeed
$switchFilename = 'outcome';

/*
Note that the MAX_JOBS value does not have to remain below zend_jobqueue.max_http_jobs,
but if it is higher, you will get "Job Queue reached a high concurrency level" GUI notifications.
*/
define('MAX_JOBS', 4);

$jobName = 'parapapa';
$jobListQuery = array('name' => $jobName);

// Display Statuses for getJobsList()
if (isset($_GET['statuses'])) {
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
if (isset($_GET['job'])) {
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
} else { // demo sequence
    echo <<<EOT
<pre><a href="$url">Usage:</a>
This script has three modes of operation, and this behaviour is controlled by
URL query parameters.
Passing <em>?job</em> causes the script to act as a Job Queue job.
Passing <em>?step=n</em> causes the script to perform a given step in the demo sequence.
Passing <em>?statuses</em> causes the script to display a number of JQ status constants.

See relevant <a href="$url?statuses">status constants</a>

<a href="$url?step=1">Step 1</a> - set the outcome switch to "failure"

<a href="$url?step=2">Step 2</a> - use API to create jobs; check ZS GUI to see that they failed

<a href="$url?step=3">Step 3</a> - use API to get list of jobs - should show they failed

<a href="$url?step=4">Step 4</a> - set the outcome switch to "success"

<a href="$url?step=5">Step 5</a> - use API to restart the existing failed jobs; check ZS GUI to see they ran to successful completion

<a href="$url?step=6">Step 6</a> - use API to get list of jobs - should show success

<a href="$url?step=7">Step 7</a> - use API to delete the jobs this script created; check ZS GUI see jobs were deleted

<a href="$url?step=8">Step 8</a> - use API to get list of jobs - should show empty array
</pre>
EOT;

    $step = isset($_GET['step']) ? (integer) $_GET['step'] : 0;
    switch ($step) {
        case 0:
            // do nothing if no step query parameter was passed
            break;
        case 1:
            setJobOutcomeSwitch($switchFilename, 'fail');
            break;

        case 2:
            for ($i = 0; $i < MAX_JOBS; $i++) {
                $jobId = $q->createHttpJob(
                      "$url?job", // url to job in document root
                      array('microtime' => microtime()), // parameters passed to the job script
                      array('name'          => $jobName, // job configuration options
                            'schedule_time' => date('Y-m-d h:i:s', strtotime('now'))
                      )
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
            setJobOutcomeSwitch($switchFilename, 'success');
            break;

        case 5:
            echo 'Restarted ', performActionOnJobs('restartJob', $jobListQuery, $q), ' Jobs<br>';
            break;

        case 7:
            echo 'Deleted ', performActionOnJobs('removeJob', $jobListQuery, $q), ' Jobs<br>';
            break;

        default;
            echo 'You need to set URL with a ?step value in valid range. See the instructions above.<br>';
            break;
    }
}

function setJobOutcomeSwitch($filename, $setting)
{
    if (file_put_contents($filename, $setting) === false) {
        // not the most graceful way to handle error
        exit ('Could not write to outcome switch file ' . $filename . '. Check permissions for PHP. byebye!');
    }
    echo "Outcome switch set to '$setting' in file $filename<br>";
}

function performActionOnJobs($action, $jobListQuery, $queue)
{
    if (!in_array($action, array('restartJob', 'removeJob'))) {
        // not the most graceful way to handle error
        exit ('Invalid jobs action: ' . $action . ' specified. Can only restartJob or removeJob. byebye!');
    }
    $jobList = $queue->getJobsList($jobListQuery);
    $actionCounter = 0;
    foreach($jobList as $v) {
        if ($queue->$action($v['id'])) {
            $actionCounter++;
        }
    }
    return $actionCounter;
}
 
