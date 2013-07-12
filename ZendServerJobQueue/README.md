# Code Examples for Zend Server Job Queue Component
## Configuration Directives Note
To experiment with failed jobs, make sure that the configuration directive *zend_jobqueue.history_failed* is set to a non-zero value, and make sure that the *zend_jobqueue.history* value is at least as large as the *zend_jobqueue.history_failed* setting. Otherwise, you will lose the history of failed jobs, since they'll be deleted from the **Overview | Job Queue** screen.

To see this directive's value, go to **Configurations | Components**, expand "Zend Job Queue," select the "Daemon Directives" tab, and look for *zend_jobqueue.history_failed* and *zend_jobqueue.history*.

When running multiple jobs simultaneously, you may see a GUI notification "Job Queue reached a high concurrency level. The Job Queue daemon has reached a high concurrency level."

*zend_jobqueue.max_http_jobs* defines **The maximum number of HTTP based jobs which can be executed simultaneously by single back-end server**
*zend_jobqueue.high_concurrency_margin_allowed* **Report an event when the Job Queue Daemon reaches a margin between the number of running jobs and the maximum allowed**

Make sure you **Save** your directive changes (upper left), and then **Restart** (upper right).

If you see errors in the jq log file similar to this: "WARNING] Scheduled Job 71 has time skewed with 43200 seconds." it means TK.

The current documentation pages are:

- [Directives](http://files.zend.com/help/Zend-Server-6/zend-server.htm#zend_job_queue_-_configuration_directives.htm)
- [Directives Summary](http://files.zend.com/help/Zend-Server-6/zend-server.htm#jqd-directives.html)
- [API](http://files.zend.com/help/Zend-Server-6/zend-server.htm#jobqueue-global-api.html)
- [ZendJobQueueClass](http://files.zend.com/help/Zend-Server-6/zend-server.htm#jobqueue-class-zendjobqueue.html)
- [Web API](http://files.zend.com/help/Zend-Server-6/zend-server.htm#job_queue_methods.htm)
- [Performance](http://files.zend.com/help/Zend-Server-6/zend-server.htm#optimizing_job_queue_performance.htm)

## The Basics - Examples Introducing Job Queue
Most of the examples are run by visiting the `job_starter_*.php` files in your browser.

1. Begin by taking a look at `job_starter_non_existent_target.php`
2. Then see `job_starter_statuses.php` and `job_statuses.php`
3. Next, look at a recurring job with `job_starter_recurring.php` and `job_one.php`
4. See two jobs, one a predecessor of the other, in `job_starter_predecessor_sample_1.php`, `job_A_predecessor_sample_1.php`, and `job_B_predecessor_sample_1.php`
5. A quick overview of using the API (setting status, getting job list, restarting jobs) is `jq_basic_api_demo.php`
6. TODO - Classic producer-consumer pipeline, in which one job produces information required by another, both jobs running simultaneously.
7. TODO - A parent job which depends upon the completion of child jobs in order for the entire workflow to be considered complete.

## More Advanced Examples

## Job Queue "Design Patterns"
Is this "too much?" An idea for workflow "Templates" in a sense - arrangements of collections of jobs for solving various processing problems. A full set of examples in the previous two sections would probably be sufficient.

