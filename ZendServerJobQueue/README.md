# Code Examples for Zend Server Job Queue Component
## Configuration Directives Note
To experiment with failed jobs, make sure that the configuration directive
*zend_jobqueue.history_failed* is set to a non-zero value. Otherwise, you will
lose the history of failed jobs, since they'll be deleted from the
**Overview | Job Queue** screen.

To see this directive's value, go to **Configurations | Components**, expand
"Zend Job Queue," select the "Daemon Directives" tab, and look for
*zend_jobqueue.history_failed*

Make sure you **Save** your directive changes (upper left), and then
**Restart** (upper right).

## Standalone Server Samples
Run the samples by visiting the `job_starter_*.php` files in your browser.

1. Begin by taking a look at `job_starter_non_existent_target.php`
2. Then see `job_starter_statuses.php` and `job_statuses.php`
3. Next, look at a recurring job with `job_starter_recurring.php` and `job_one.php`

## Cluster Samples
I will add sample scripts specfic to a Zend Server cluster.

