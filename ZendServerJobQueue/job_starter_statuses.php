<?php
$q = new ZendJobQueue();
$ts = date('Y-m-d H:i:s', time()+10); // 10 seconds from now

try {
    $id = $q->createHttpJob(
        '/job_statuses.php',
        array('starting_script_name' => $_SERVER['PHP_SELF']),
        array(
            'name' => 'Play w/ Statuses',
            'schedule_time' => $ts
        )
    );
    if (!is_int($id)) {
        'Job was not created';
        return;
    }
    echo 'Job ', $id, ' scheduled for ', $ts;
} catch (Exception $e) {
    echo 'Problem scheduling job: ', $e->getMessage();
}

/*
Use this script to schedule the jobs found in the target script
"job_statuses.php". In that script, comment out each status setting to see the
effect in the Zend Server GUI. Look in Overview | Dashboard (or Events) for
errors, and look in Overview | Job Queue for job status.

The jobs are scheduled for 10 seconds from the time you visit this script;
adjust the duration upwards if you want more time to see status "Scheduled"
and to play with managing jobs via the GUI or API, as future examples will.
*/

