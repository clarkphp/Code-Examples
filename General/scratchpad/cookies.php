<?php
/*
 * forged http request headers - slide 156

GET /admin HTTP/1.0
Cookie: isAdmin=1

 */

/*
 * Cookies exercise slide 158
 * Somewhere in views/scripts/index/index.phtml
 */
?>
<a href="/index/togglepreview"><?echo (isset($_COOKIE['hidePreview']))?'Show':'Hide'?> Previews</a>

<?php
// In helpers/Mainpage.php
if (!isset($_COOKIE['hidePreview'])) {
	// Ignore preview
}

// In controllers/indexController.php
class indexController {
	public function togglepreviewAction()
	{
		if (isset($_COOKIE['hidePreview'])) {
			setcookie('hidePreview',0, 1, '/');
		} else {
			setcookie('hidePreview',1, PHP_INT_MAX, '/');
			
		}
		header('Location: '.URL_HOME, true, 302);
	}
}
