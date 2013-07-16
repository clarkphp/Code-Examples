<?php
// http headers reference:
// http://www.faqs.org/rfcs/rfc2616.html
// Section 9. Method Definitions

// Header quick reference:
// http://www.cs.tut.fi/~jkorpela/http.html 

// GET vs. POST
/* The GET and POST methods differ in two ways. The first is in how the data each is
 * transmitting is sent to the server, and the second is in the restrictions placed
 * on the length of that data. While the GET method transmits data by appending it to
 * the end of the desired URL (which is requested via a GET request when the user clicks
 * on the link), the POST method must be transmitted through the use of a POST HTTP request.
 * 
 * php.ini config setting   post_max_size Sets max size of post data allowed.
 * This setting also affects file upload. To upload large files, this value must be larger
 * than upload_max_filesize. If memory limit is enabled by your configure script, memory_limit
 * also affects file uploading. Generally speaking, memory_limit should be larger than post_max_size.
 * For more info, see http://www.php.net/manual/en/ini.core.php#ini.post-max-size
 *  
 */ 


echo 'Hello ' . htmlspecialchars($_GET["name"]) . '!';



// GET and POST
// Form that submits both get and post data simultaneously
?>
<form method="POST" action="?get=data">
<input type="submit" value="Submit" name="submit">
</form>
<?php
echo '<pre>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	echo 'GET<br />';
    var_dump($_GET);
    echo 'POST<br />';
    var_dump($_POST);
}
echo '</pre>';
exit;

// Output buffering
ob_start();
echo "This goes in the buffer."; // never appears in output.
$value = strlen(ob_get_clean());
echo "Buffer length: $value bytes<br />";
exit;

// buffers
// Uppercase all code
$dispatcher = new ZBlog_Dispatcher();
ob_start();
$dispatcher->dispatch();
$data = ob_get_clean();
echo strtoupper($data);


// Browser caching headers
$eTag = "$entryId-$entry->modified";

header('Expires: '.gmdate("D, d M Y H:i:s", $entry->modified+31536000) . " GMT");
header('Last-Modified: '.gmdate("D, d M Y H:i:s", $entry->modified) . " GMT");
header("ETag: $eTag");
header("Pragma: cache");
header("Cache-Control: public, must-revalidate, max-age=0");
if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] = $eTag ) {
	header('Not Modified', true, 304);
	return;
}
