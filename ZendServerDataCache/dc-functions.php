<?php
/**
 *
 * Must match path defined in zend_datacache.disk.save_path (See Configurations | Components | Zend Data Cache)
 * IBM i path will have 'zendsvr6', not 'zend', as a path component.
 *
 * @var string The path for storing cached content to the disk.
 */
define('DATACACHE_PATH', '/usr/local/zend/tmp/datacache/');

/**
 * Displays contents of data cache directory where cached content is stored to disk.
 */
function listDatacacheDirectory()
{
    echo '<p>Listing of Data Cache directory hierarchy at ', DATACACHE_PATH, '</p>';
    try {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(DATACACHE_PATH));
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
        echo '<p>Check the directory path \'', DATACACHE_PATH,'\' to make sure it exists. Exiting...</p>';
        exit;
    }
}
