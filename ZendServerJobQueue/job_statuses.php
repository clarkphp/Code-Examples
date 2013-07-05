<?php
$args = ZendJobQueue::getCurrentJobParams();

/*
There are three "OK" statuses in the ZendJobQueue class:
 [STATUS_OK] => 4
 [JOB_STATUS_OK] => 16
 [OK] => 0 - this is the one to use for successful job completion

 If the status is NOT explicitly set by the job script, and the job
 successfully runs to completion, the status found in the GUI at
 Overview | Job Queue is "Completed". This means only that the PHP
 ended without error; it says nothing about whether you consider the
 job to have successfully done what you expected it to.
*/

// Run 1. Do not set the status at all; leave the next several lines commented out

// Run 2. Set the status to JOB_STATUS_OK - results in "Job Logical Failure" event
// Lesson: in spite of the name, don't use this to report a successful job completion
//ZendJobQueue::setCurrentJobStatus(ZendJobQueue::JOB_STATUS_OK, 'JOB_STATUS_OK, not STATUS_OK, not OK');
/* This is the response. Ssome details of course may differ for you. Get this info
   at Overview | Job Queue, expand the job, click on Output tab:
  
HTTP/1.1 200 OK
Date: Fri, 05 Jul 2013 19:15:31 GMT
Server: Apache/2.2.23 (Unix) PHP/5.4.11 mod_ssl/2.2.23 OpenSSL/0.9.8x
X-Powered-By: PHP/5.4.11 ZendServer/5.0
Set-Cookie: ZDEDebuggerPresent=php,phtml,php3; path=/
X-Job-Queue-Status: 1 JOB_STATUS_OK, not STATUS_OK, not OK in \
 /usr/local/zend/apache2/htdocs/job_statuses.php line 18
Content-Length: 0
Connection: close
Content-Type: text/html
*/

// Run 3. Set the status to STATUS_OK
//ZendJobQueue::setCurrentJobStatus(ZendJobQueue::STATUS_OK, 'STATUS_OK, not JOB_STATUS_OK, not OK');
// Lesson: Don't use this one, either, to report a successful job completion
// Check out the response, error status, etc., yourself

// Run 4. Set the status to OK - this is the one to use for a successful job completion.
//ZendJobQueue::setCurrentJobStatus(ZendJobQueue::OK, 'OK, not JOB_STATUS_OK, not STATUS_OK');
// Check out the response, error status, etc., yourself

// Run 5. Set the status to FAILED - this is the one to use for a logically unsuccessful job completion.
// The job completed, yields an HTTP 200 OK, but the script algorithm detects a condition of failure.
//ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, 'Completed but failed');
/*
HTTP/1.1 200 OK
Date: Fri, 05 Jul 2013 22:26:55 GMT
Server: Apache/2.2.23 (Unix) PHP/5.4.11 mod_ssl/2.2.23 OpenSSL/0.9.8x
X-Powered-By: PHP/5.4.11 ZendServer/5.0
Set-Cookie: ZDEDebuggerPresent=php,phtml,php3; path=/
X-Job-Queue-Status: 1 Completed but failed in /usr/local/zend/apache2/htdocs/job_statuses.php line 48
Content-Length: 0
Connection: close
Content-Type: text/html
*/
file_put_contents(
    __DIR__ . '/' . basename(__FILE__) . '.out',
    'Arguments passed to Job: ' . var_export($args, true) . PHP_EOL,
    FILE_APPEND
);

