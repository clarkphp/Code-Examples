<?php
namespace Example\ZF2\ServiceManager\ServiceType\Service;
// Demonstrate setting up and using a already-instantiatd service.

include __DIR__ . '/' . 'includes.php';
use Zend\ServiceManager;

// utility functions
function hasService($serviceName, ServiceManager\ServiceManager $sm)
{
    return 'The Service Manager '
        . ($sm->has($serviceName) ? 'has' : 'does not have')
        . " the service '$serviceName'";
}

function checkHowMuchTheSame($object1, $object2)
{
    $equivalence = $object1 == $object2;
    $identity = $object1 === $object2;
    return 'The two objects are ' . ($equivalence ? 'equal' : 'not equal')
        . ' and are ' . ($identity ? 'the same instance' : 'different instances');
}

// This class is the template for a very simple service
class SimpleClass
{
    public $attribute = 'SimpleClassAttribute';
}

$object = new SimpleClass();

// First, without a configuration array

// register an object as a service
// This corresponds to the \'services\' key in a configuration array

try {
    $sm = new ServiceManager\ServiceManager();
    echo hasService('my-service', $sm), PHP_EOL;
    $sm->setService('my-service', $object);
    echo hasService('my-service', $sm), PHP_EOL;

    $service1 = $sm->get('my-service');
    $service2 = $sm->get('my-service');
    // remember from introduction.php that we cannot use create() here
    echo checkHowMuchTheSame($service1, $service2), PHP_EOL;
} catch (\Exception $e) {
    echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
}

// Now, with a configuration array
unset($sm, $service1, $service2);
// do not unset our object from above; we need it

$config = array(
    'services' => array(
        'my-service' => $object,
    ),
);

// See Zend/ServiceManager/Config.php
// and Zend/ServiceManager/ServiceManager.php

$configurator = new ServiceManager\Config($config);
$sm = new ServiceManager\ServiceManager($configurator);
$service1 = $sm->get('my-service');
$service2 = $sm->get('my-service');
echo checkHowMuchTheSame($service1, $service2), PHP_EOL;

// What just happened is that the ServiceManager called $config->configureServiceManager(),
// which called $sm->setService();
// There can be, and usually are, multiple service managers in a typical application, so the same instance of
// Zend\ServiceManager\Config could configure all of them.

