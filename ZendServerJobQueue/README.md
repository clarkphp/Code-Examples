Code Examples for Zend Server Job Queue Component
=================================================

To experiment with failed jobs, make sure that the configuration directive
"zend_jobqueue.history_failed" is set to a non-zero value. Otherwise, you will
lose the history of failed jobs, since they'll be deleted from the
Overview | Job Queue screen.

To see this directive's value, go to Configurations | Components, expand
"Zend Job Queue," select the "Daemon Directives" tab, and look for
"zend_jobqueue.history_failed."

Make sure you "Save" your directive changes (upper left), and then
Restart (upper right).

Run the samples by visiting the job_starter*.php files in your browser.

