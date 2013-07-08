<?php
if (class_exists('ZendJobQueue'))
  $q = new ZendJobQueue();
else
  die ('Jobqueue class does not exist within this PHP runtime. good bye!');

$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$file_flag = 'flagme';
$max_jobs = 4; // Note this value does not have to remain below zend_jobqueue.max_http_jobs,
    // but if it is higher, you will get "Job Queue reached a high concurrency level" GUI notifications.
$job_name = "parapapa";
$query = array ('name'=>$job_name);

// Display Statuses for getJobsList()
if (isset($_GET['s']) || isset($_GET['statuses'])) {
  $arrS = array('ZendJobQueue::STATUS_PENDING','ZendJobQueue::STATUS_WAITING_PREDECESSOR','ZendJobQueue::STATUS_RUNNING','ZendJobQueue::STATUS_COMPLETED','ZendJobQueue::STATUS_FAILED','ZendJobQueue::STATUS_OK','ZendJobQueue::STATUS_LOGICALLY_FAILED','ZendJobQueue::STATUS_TIMEOUT','ZendJobQueue::STATUS_REMOVED','ZendJobQueue::STATUS_SCHEDULED','ZendJobQueue::STATUS_SUSPENDED','ZendJobQueue::JOB_STATUS_PENDING','ZendJobQueue::JOB_STATUS_WAITING_PREDECESSOR','ZendJobQueue::JOB_STATUS_RUNNING','ZendJobQueue::JOB_STATUS_COMPLETED','ZendJobQueue::JOB_STATUS_FAILED','ZendJobQueue::JOB_STATUS_OK','ZendJobQueue::JOB_STATUS_LOGICALLY_FAILED','ZendJobQueue::JOB_STATUS_TIMEOUT','ZendJobQueue::JOB_STATUS_REMOVED','ZendJobQueue::JOB_STATUS_SCHEDULED','ZendJobQueue::JOB_STATUS_SUSPENDED');
  foreach ($arrS as $v) {
    echo $v." = ".constant($v)."<br>\n";
  }
echo "<br><br>vardump(ZendJobQueue::STATUS_OK): ";
var_dump(ZendJobQueue::STATUS_OK);
echo "<br><br>vardump(ZendJobQueue::JOB_STATUS_OK): ";
var_dump(ZendJobQueue::JOB_STATUS_OK);
}

// Job functionality
if (isset($_GET['job'])) {
  $status = file_get_contents($file_flag);
  if ($status == 1)
    ZendJobQueue::setCurrentJobStatus (ZendJobQueue::FAILED,"Setting Job Status FAILED");
  else // status == 1
    ZendJobQueue::setCurrentJobStatus (ZendJobQueue::OK,"Setting Job Status OK");
}

// All other steps
else {

echo <<<EOT
<pre><a href="$url">Usage:</a>
If passing ?job - it acts as the job script, otherwise as the Steps script
Check <a href="$url?s">status codes</a> by ?statuses or ?s
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

$_GET['step'] = (integer) $_GET['step'];
  switch ($_GET['step']) {

    case 1:
      if (file_put_contents($file_flag,1)===false) die ('Could not write to flag file - check permissions for PHP. byebye!');
      echo "Flag file was set to 1";
    break;

    case 2:
      for ($i=0; $i<$max_jobs; $i++) {
        //$job = $q->createHttpJob($url."?job", array('microtime'=>microtime()), array('name'=>$job_name,'schedule_time' => date('Y-m-d h:i:s', strtotime('+1s'))) );
        $job = $q->createHttpJob($url."?job", array('microtime'=>microtime()), array('name'=>$job_name,'schedule_time' => date('Y-m-d h:i:s', strtotime('now'))) );
        echo "New Job URL: $url ID: $job.<br>\n";
      }
    break;

    case 3:
    case 6:
    case 8:
      echo "<pre>".print_r($q->getJobsList($query),1)."</pre>\n";
    break;

    case 4:
      if (file_put_contents($file_flag,0)===false) die ('Could not write to flag file - check permissions for PHP. byebye!');
      echo "Flag file was set to 0";
    break;

    case 5:
      $job_list = $q->getJobsList($query);
      $restart_counter = 0;
      foreach($job_list as $v) {
        if ($q->restartJob($v['id']))
          $restart_counter++;
      }
      echo "Restarted $restart_counter Jobs.";
    break;

    case 7:
      $job_list = $q->getJobsList($query);
      $delete_counter = 0;
      foreach($job_list as $v) {
        if ($q->removeJob($v['id']))
          $delete_counter++;
      }
      echo "Deleted $delete_counter Jobs.";
    break;

    default;
      echo "You need to set URL with a ?step= value in valid range. See the instructions above.<br>\n";
    break;

  } // switch $_GET['step']


} // else

