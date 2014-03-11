<h1>Data Cache Intro: Fetching, Storing, Deleting, Clearing Cache</h1>
<?php
// This function is defined at the bottom of this file
listDatacacheDirectory();

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
$ttl = 10;

// In Zend Server GUI, clear the cache of all data by going to
// Configurations | Components and click the broom icon on the far right of the
// screen on the "Zend Data Cache" line.

echo '<p>Attempt to fetch an item from cache.
There should be nothing in cache, so this should return false
to indicate a cache miss.</p>';
$success = zend_disk_cache_fetch($key);
echo 'Return value of fetch is ';
var_dump($success);

echo '<p>Store a value in the cache, using a non-namespaced key for retrieval</p>';
$success = zend_disk_cache_store($key, $datum, $ttl);

echo '<p>See how the cache directory on disk has changed</p>';
listDatacacheDirectory();

echo '<p>Fetch the item we just stored</p>';
$success = zend_disk_cache_fetch($key);
echo 'Return value of fetch is: ';
var_dump($success);

echo '<p>Clear the cache completely, to give us a clean slate:';
$success = zend_disk_cache_clear();
var_dump($success); // true means cache was successfully cleared
echo '</p>';

echo '<p>See how the cache directory on disk has changed; the cache file is gone.</p>';
listDatacacheDirectory();
$success = zend_disk_cache_fetch($key);
echo 'And fetching the same key indicates a cache miss: ';
var_dump($success);

echo '<h3>Working with Delete</h3>';
echo '<p>Store a value in the cache, using a non-namespaced key for retrieval</p>';
$success = zend_disk_cache_store($key, $datum, $ttl);

echo '<p>Cache directory on disk has changed</p>';
listDatacacheDirectory();

echo '<p>Fetch the item we just stored</p>';
$success = zend_disk_cache_fetch($key);
echo 'Return value of fetch is: ';
var_dump($success);

echo '<p>Delete the item from cache:';
$success = zend_disk_cache_delete($key);
var_dump($success); // true means item was successfully deleted
echo '</p>';

echo '<p>Cache file is gone</p>';
listDatacacheDirectory();
$success = zend_disk_cache_fetch($key);
echo 'And fetching the same key indicates a cache miss: ';
var_dump($success);

echo '<p>Clear the cache completely, to give us a clean slate:';
$success = zend_disk_cache_clear();
var_dump($success); // true means cache was successfully cleared
echo '</p>';

echo '<p>The cache file is gone, but directories persist</p>';
listDatacacheDirectory();

echo '<h3>Add two items to cache, delete one of them, observe directories and files.</h3>';
echo '<p>Store two values in the cache, using non-namespaced keys.</p>';
zend_disk_cache_store($key, $datum, $ttl);
$key2 = 'datum2';
zend_disk_cache_store($key2, array_reverse($datum), $ttl);

echo '<p>Two cache files have been added:</p>';
listDatacacheDirectory();

echo '<p>Fetch one item we just stored</p>';
$success = zend_disk_cache_fetch($key2);
echo 'Return value of fetch is: ';
var_dump($success);

echo '<p>Delete this item from cache:';
$success = zend_disk_cache_delete($key2);
var_dump($success); // true means item was successfully deleted
echo '</p>';

echo '<p>One cache file remains, the other file (for the deleted item) is gone.</p>';
listDatacacheDirectory();

echo '<p>And the remaining item can be fetched.';
$success = zend_disk_cache_fetch($key);
var_dump($success);
echo '</p>';

echo '<p>Clear the cache completely, to give us a clean slate:';
$success = zend_disk_cache_clear();
var_dump($success); // true means cache was successfully cleared
echo '</p>';

echo '<p>Directories remain; all cache files are gone.</p>';
listDatacacheDirectory();

echo '<p>The difference between deleting and clearing is that deletion occurs by key name, whereas clearing removes all keys (actually a namespace can be specified, shown in another example later).</p>';
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
