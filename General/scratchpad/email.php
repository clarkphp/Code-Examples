<?php
# Email
# Solutions like Zend_Mail (framework.zend.com), Swift Mailer (swiftmailer.org), or PHPMailer (http://sourceforge.net/projects/phpmailer/)
# are much better for normal email needs in PHP programs.
# PHP's mail() function is best reserved for very low volume, notification scenarios.


// exercise 174

// In articleController.php

if (defined('ADMIN_EMAIL')) {
	mail(ADMIN_EMAIL, 'New posting', 'A new comment has been posted');
}

// In config.inc.php

define('ADMIN_EMAIL', 'myaddr@mydomain.com');

///////

