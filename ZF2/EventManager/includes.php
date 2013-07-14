<?php
$pathToZf = '/usr/local/zend/share/ZendFramework2/library';
set_include_path($pathToZf . PATH_SEPARATOR . get_include_path());

$config = array(
    'Zend\Loader\StandardAutoloader' => array(
        'namespaces' => array(
            'Zend' => $pathToZf . '/Zend',
        ),
    ),
);

require_once 'Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory($config);

require_once 'Zend/EventManager/EventManager.php';

