<?php
$q = new ZendJobQueue();
$ts = date('Y-m-d H:i:s', time()+10); // 10 seconds from now

$id = $q->createHttpJob(
    '/iDoNotExist.php', // URL to job script; relative to DOCROOT; here, this target script does NOT exist
    array(  // arguments passed to the job script
        'starting_script_name' => $_SERVER['PHP_SELF']
    ),
    array( // job options (scheduling, etc.)
        'name' => 'Play w/ Statuses',
        'schedule_time' => $ts
    )
);
if (!is_int($id)) {
    'Job was not created';
    return;
}
echo 'Job ', $id, ' scheduled for ', $ts;

/*
The target will be successfully scheduled, but when the job is run, its
status will be set to "Failed" in the GUI Overview | Job Queue menu.

In Overview | Events, a "Job Execution Error" will be present. Expanding
the error and selecting "More Details" shows the expected 404 error (note
the Job id number will vary for you, as may your host and port number):

    Reason Job 13 failed. Bad HTTP response 404
    Job ID 13
    Job URL http://localhost:10088/iDoNotExist.php
    Job Variables [select all]  
          '"{"starting_script_name":"\\/job_starter.php"}"' 
*/

