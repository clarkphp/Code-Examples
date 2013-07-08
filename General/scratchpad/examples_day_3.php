<?php
/*
A. To run the WebEx Training Center from within the Virtual Machine, allowing you to copy and paste directly from chat to Zend Studio for Eclipse, visit zendtraining.webex.com and install Java plugin when prompted.

cd /usr/local/firefox/plugins/
sudo ln -s /usr/local/java/jre1.6.0_16/plugin/i386/ns7/libjavaplugin_oji.so 

Visiting Training Center again should work.

B. To run Flash in Firefox on the VMWare image, do this:
Use package manager to install Adobe Flash player.
cd /usr/local/firefox/plugins/
sudo cp /usr/lib/adobe-flashplugin/libflashplayer.so .

*/
// Exercise Slide 82
Exercise 82 reference info:
User/password is administrator/password

http://www.php.net/manual/en/book.stream.php
http://www.php.net/manual/en/stream.examples.php
http://www.php.net/manual/en/ref.stream.php

In particular, these links:
http://www.php.net/manual/en/function.stream-context-create.php
http://www.php.net/manual/en/wrappers.php
http://www.php.net/manual/en/context.php

$header = 'Authorization: Basic'
        . base64_encode('administrator:password') . "\r\n"
        . 'Cookie: ' . session_name() . '=' . md5(microtime()) . "\r\n";
$context = stream_context_create(array('http' => array('header' => $header)));
//exit(__LINE__ . "\n");
$fh = fopen('http://localhost/zblog/admin/?useHttpAuth=1', 'r', null, $context);
if (! $fh) {
	exit ("Error opening URL\n");
}

$content = '';
while (! feof($fh)) {
	$content .= fread($fh, 1024);
}

//echo strip_tags(($content));
echo $content;
