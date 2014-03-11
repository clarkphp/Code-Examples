<h1>Data Cache Intro: Expiration</h1>
<?php
// a "key" is the name used to store or retrieve data from cache
// Keys can be "non-namespaced" - 'datum1'
// They can be "namespaced" - 'group1::datum1','group2::datum1'
// Above, these are two separate items in cache, in separate namespaces.
// Note: these namespaces have nothing to do with PHP 5.3+ namespaces
// A cache namespace is simply a collection of keys/data items.
$key = 'datum1'; // a non-namespaced key
$ns_key = 'test1::datum1'; // a namespaced key, test1 is the namespace

// a data item to experiement with
$datum = array(1,2,3,4,5);

// Time-to-live, in seconds. Cache entry expires after $ttl seconds
$ttl = 2;

// sleep time used for script delay to allow items to expire
$sleepDuration = $ttl + 1;

echo '<p>Clear the cache completely, to give us a clean slate:';
$success = zend_disk_cache_clear();
var_dump($success); // true means cache was successfully cleared
echo '</p>';

echo '<p>Should see directories only.</p>';
listDatacacheDirectory();

echo "<p>Store a value in the cache at key $key, expiring in $ttl seconds.</p>";
$success = zend_disk_cache_store($key, $datum, $ttl);

echo '<p>Cache directories and cache file on disk:</p>';
listDatacacheDirectory();

echo '<p>Fetch the item we just stored</p>';
$success = zend_disk_cache_fetch($key);
echo 'Return value of fetch is: ';
var_dump($success);

echo "<p>Sleep for $sleepDuration seconds, to allow cache items to expire.</p>";
sleep($sleepDuration);

echo "<p>Fetch key $key; should return false, since the item has expired.</p>";
$success = zend_disk_cache_fetch($key);
echo 'Return value of fetch is: ';
var_dump($success);

echo '<p>Note the cache file is still in place:</p>';
listDatacacheDirectory();

echo '<p>Delete the item from cache:';
$success = zend_disk_cache_delete($key);
var_dump($success); // it is valid to delete an expired item
echo '</p>';

echo '<p>Cache file has been removed.</p>';
listDatacacheDirectory();
$success = zend_disk_cache_fetch($key);
echo 'And fetching the same key indicates a cache miss: ';
var_dump($success);

echo '<p>Clear the cache completely:';
$success = zend_disk_cache_clear();
var_dump($success); // true means cache was successfully cleared
echo '</p>';

echo '<p>The cache file is gone, but directories persist</p>';
listDatacacheDirectory();

echo '<h3>Add two items to cache, allow one to expire, observe directories and files.</h3>';
echo "<p>Store key $key in the cache, with expiration in $ttl seconds</p>";
zend_disk_cache_store($key, $datum, $ttl);
$key2 = 'datum2';
$ttl2 = $ttl + 5;
echo "<p>Store key $key2 in the cache, with expiration in $ttl2 seconds</p>";
zend_disk_cache_store($key2, array_reverse($datum), $ttl2);

echo '<p>Two cache files have been added:</p>';
listDatacacheDirectory();

echo '<p>Fetch the item we just stored</p>';
$success = zend_disk_cache_fetch($key2);
echo 'Return value of fetch is: ';
var_dump($success);

echo "<p>Sleep for $sleepDuration seconds, to allow the item with shorter duration of $ttl seconds to expire.</p>";
sleep($sleepDuration);

echo '<p>Both cache files remain.</p>';
listDatacacheDirectory();

echo '<p>The expired item cannot be fetched.';
$success = zend_disk_cache_fetch($key);
var_dump($success);
echo '</p>';

echo '<p>But the longer ttl item can still be fetched.</p>';
$success = zend_disk_cache_fetch($key2);
echo 'Return value of fetch is: ';
var_dump($success);

echo '<p>Delete the expired item:';
$success = zend_disk_cache_delete($key);
var_dump($success);
echo '</p>';

echo '<p>Directories remain; the deleted item\'s cache file is gone.</p>';
listDatacacheDirectory();

echo '<p>Lesson: Expired items are not "in the cache" but the files storing them remain on the filesystem until explicitly deleted, or cleared.</p>';
function listDatacacheDirectory()
{
    $path = '/usr/local/zend/tmp/datacache/';
    echo "<p>Listing of Data Cache directory hierarchy at $path</p>";
    try {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        if ($iterator->valid()) {
            echo '<table><tr><th>File/Directory</th><th>Pathname</th><th>Size</td><th>Modified</td></tr>';
            foreach ($iterator as $file) {
                if ('..' == $file->getFilename()) {
                    continue;
                }
                echo sprintf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
                    $file->isDir() ? 'Dir' : 'File',
                    $file->getPathname(),
                    $file->getSize(),
                    date('Y-m-d h:i:s', $file->getMTime()));
            }
            echo '</table>';
        }
    } catch (Exception $e) {
        echo '<p>Check the directory path to make sure it exists. Exiting...</p>';
        exit;
    }
}
