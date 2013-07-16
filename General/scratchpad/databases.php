<?php
# Databases and PDO, Error-handling, and Exceptions

# http://www.php.net/manual/en/book.pdo.php
# http://www.php.net/manual/en/pdo.drivers.php - drivers for the databases supported by PDO

# The old way
//$db = sqlite_open('phpII_examples.db');
//$id = sqlite_escape_string($_GET['id']);
//$result = sqlite_query($db, 'select * from users where user_key = ' . $id);
//while (($row = sqlite_fetch_array()) !== false) {
//}

# The current way, using PDO
//$db = new PDO('sqlite:phpII_examples.db');
//$statement = $db->prepare('select * from users where user_key = ?');
//if ($statement->execute(array($_GET['id']))) {
//    while (($row = $statement->fetch()) !== false) {
//    }
//}

# stored procedures - See books like in "MySQL Stored Procedure Programming", by Guy Harrison

# PDO::ATTR_PERSISTENT  (integer)
# Request a persistent connection, rather than creating a new connection.
# See Connections and Connection management in PHP manual for more information on this attribute.

# Database Connections
# See also http://www.php.net/manual/en/ref.pdo-mysql.connection.php for proper DSN (data source name)
//    public static function getAdapter()
//    {
//        if (ZBlog_Data::$dbAdapter === NULL) {
//
//            try {
//                $db = 'mysql:host=localhost;dbname=testdb'; // This is the line to change.
//
//                ZBlog_Data::$dbAdapter = new ZBlog_Data(new PDO($db));
//                ZBlog_Data::$dbAdapter->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//            } catch (Exception $e) {
//                ZBlog_Logger::getInstance()->writeLog( $e->getMessage(), 'ERR' );
//
//            }
//        }
//
//        return ZBlog_Data::$dbAdapter;
//    }


# Sessions
// Something like this in View_Helper_Columnleft::load() plus the
// place where it's assigned in articleController

$lastReadHtml = '';
if (isset($_SESSION['lastread'])) {
    $lastReadHtml = <<<EOQ
<div id="blog-recentposts">
<h3>Last Article</h3>
<p>
<a href="$urlHome/article/view/id/{$_SESSION['lastread']->entry_id}">

    {$_SESSION['lastread']->title}
    </a>
    </p>

</div>
EOQ;
}

# Email
// In articleController.php
if (defined('ADMIN_EMAIL')) {
    mail(ADMIN_EMAIL, 'New posting', 'A new comment has been posted');
}

// In config.inc.php
define('ADMIN_EMAIL', 'myaddr@mydomain.com');

# Error Handling
# http://www.php.net/manual/en/errorfunc.examples.php

# Form Validation - character type checks
# http://www.php.net/manual/en/book.ctype.php


# Exceptions
# http://www.php.net/manual/en/language.exceptions.php

function inverse($x) {
    if (!$x) {
        throw new Exception('Division by zero.');
    }
    else return 1/$x;
}

try {
    echo inverse(5) . ' from line ' . __LINE__ . "\n";
    echo inverse(0) . ' from line ' . __LINE__ . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// Continue execution
echo 'Hello World';
