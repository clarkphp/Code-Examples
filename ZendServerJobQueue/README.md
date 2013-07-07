# Code Examples for Zend Server Job Queue Component
## Configuration Directives Note
To experiment with failed jobs, make sure that the configuration directive *zend_jobqueue.history_failed* is set to a non-zero value, and make sure that the *zend_jobqueue.history* value is at least as large as the *zend_jobqueue.history_failed* setting. Otherwise, you will lose the history of failed jobs, since they'll be deleted from the **Overview | Job Queue** screen.

To see this directive's value, go to **Configurations | Components**, expand "Zend Job Queue," select the "Daemon Directives" tab, and look for *zend_jobqueue.history_failed* and *zend_jobqueue.history*.

Make sure you **Save** your directive changes (upper left), and then **Restart** (upper right).

The current documentation pages are:

- [Directives](http://files.zend.com/help/Zend-Server-6/zend-server.htm#zend_job_queue_-_configuration_directives.htm)
- [Directives Summary](http://files.zend.com/help/Zend-Server-6/zend-server.htm#jqd-directives.html)
- [API](http://files.zend.com/help/Zend-Server-6/zend-server.htm#jobqueue-global-api.html)
- [ZendJobQueueClass](http://files.zend.com/help/Zend-Server-6/zend-server.htm#jobqueue-class-zendjobqueue.html)
- [Web API](http://files.zend.com/help/Zend-Server-6/zend-server.htm#job_queue_methods.htm)
- [Performance](http://files.zend.com/help/Zend-Server-6/zend-server.htm#optimizing_job_queue_performance.htm)

## Standalone Server Samples
Run the samples by visiting the `job_starter_*.php` files in your browser.

1. Begin by taking a look at `job_starter_non_existent_target.php`
2. Then see `job_starter_statuses.php` and `job_statuses.php`
3. Next, look at a recurring job with `job_starter_recurring.php` and `job_one.php`
4. See two jobs, one a predecessor of the other, in `job_starter_predecessor_sample_1.php`, `job_A_predecessor_sample_1.php`, and `job_B_predecessor_sample_1.php`

## Cluster Samples
I will add sample scripts specfic to a Zend Server cluster.

