<?php
$args = ZendJobQueue::getCurrentJobParams();

$q = new ZendJobQueue();
$schedulingRules = $q->getSchedulingRules();
ZendJobQueue::setCurrentJobStatus(ZendJobQueue::OK, 'Finished OK');

file_put_contents(
    __FILE__ . '.out',
        'Script ' . $args['starting_script_name'] . ' started me at ' . $args['initiated']
      . PHP_EOL . "Scheduled as {$args['scheduled_as']}" . PHP_EOL
      . print_r($schedulingRules, true),
  FILE_APPEND
);
echo '<p>A job can send output. See Overview | Job Queue; expand a completed job (do not click on the job name link), then click on "Output" tab.</p>';

