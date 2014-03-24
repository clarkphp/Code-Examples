<h1>Data Cache Intro: Manual Clearing of Cache from Zend Server GUI</h1>
<?php
require_once __DIR__ . '/dc-functions.php';

$key = 'datum1'; // a non-namespaced key

// a data item to experiement with
$datum = array(1,2,3,4,5);

// Time-to-live, in seconds. Cache entry expires after $ttl seconds
$ttl = 40;

// sleep time used for script delay to allow user time to manually clear the cache via GUI
$sleepDuration = $ttl / 2;

echo '<p>Clear the cache completely, to give us a clean slate:';
$success = zend_disk_cache_clear();
var_dump($success); // true means cache was successfully cleared
echo '</p>';

echo '<p>Should see directories only.</p>';
listDatacacheDirectory();

echo "<p>Store a value in the cache at key $key, expiring in $ttl seconds.</p>";
$success = zend_disk_cache_store($key, $datum, $ttl);

echo '<p>See cache directories and cache file on disk:</p>';
listDatacacheDirectory();

echo "<p>Sleep for $sleepDuration seconds; go to Zend Server GUI now and manually clear the cache at<br>Configurations | Components | Zend Data Cache | click broom icon.</p>";
sleep($sleepDuration);

echo '<p>See cache directories, but all cache files have been remvoed:</p>';
listDatacacheDirectory();

echo '<p>Lesson: Manually clearing cache from Zend Server GUI results in cache files being removed, but the directory structure remains. The manual clear cache process is the same as calling zend_disk_cache_clear().</p>';
