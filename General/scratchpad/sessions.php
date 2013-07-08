<?php
echo 'Before starting the session' . PHP_EOL;
print_r($_SESSION);

session_start();

echo 'After starting the session' . PHP_EOL;
print_r($_SESSION);

$_SESSION['any_var_will_do'] = 'SomeValue';
echo session_id() . PHP_EOL;

exit;

// sessions and email

//echo ini_get('session.save_path') . '<br />';
//exit;

// slide 163
session_start();
echo "The session id is " . session_id() . "\n";
if (isset($_SESSION['arraydata'])) {
	echo $_SESSION['arraydata'][1] . '<br />';
}
//$_SESSION['example_varname'] = 'sample value';
//$_SESSION['arraydata'] = array(1, 'two', 3);

//session_destroy();

exit;


// Exercise slide 165
// Solution will look something like this in View_Helper_Columnleft::load() plus the 
// place where it's assigned in articleController

//$lastReadHtml = '';
//		if (isset($_SESSION['lastread'])) {
//			$lastReadHtml = <<<EOQ
//<div id="blog-recentposts">
//<h3>Last Article</h3>
//<p>
//<a href="$urlHome/article/view/id/{$_SESSION['lastread']->entry_id}">
//    
//    {$_SESSION['lastread']->title}
//    </a>
//    </p>
//
//</div>
//EOQ;
//}

// Email exercise slide 174
// In ArticleController.php

//if (defined('ADMIN_EMAIL')) {
//	mail(ADMIN_EMAIL, 'New posting', 'A new comment has been posted');
//}

// In config.inc.php

define('ADMIN_EMAIL', 'myaddr@mydomain.com');
