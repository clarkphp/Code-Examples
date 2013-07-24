<?php
namespace Example\ZF2\ServiceManager\ServiceType\Invokable;
// Demonstrate setting up and using an invokable service.

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

// First, without a configuration array
$sm = new ServiceManager\ServiceManager();

// register a class as an invokable, meaning it can be directly instantiated.
// This corresponds to the \'invokables\' key in a configuration array

try {
    echo hasService('invokable-class', $sm), PHP_EOL;
    // Take careful note of the class name: must be fully qualified for successful instantiation upon retrieval!
    //$sm->setInvokableClass('invokable-class', 'SimpleClass');
    $sm->setInvokableClass('invokable-class', 'Example\ZF2\ServiceManager\ServiceType\Invokable\SimpleClass');
    echo hasService('invokable-class', $sm), PHP_EOL;

    $service1 = $sm->get('invokable-class');
    $service2 = $sm->create('invokable-class');
    echo checkHowMuchTheSame($service1, $service2), PHP_EOL;
} catch (\Exception $e) {
    echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
}

// Now, with a configuration array
unset($sm, $service1, $service2);

$config = array(
    'invokables' => array(
        'invokable-class' => 'Example\ZF2\ServiceManager\ServiceType\Invokable\SimpleClass'
    ),
);

// See Zend/ServiceManager/Config.php
// and Zend/ServiceManager/ServiceManager.php

$configurator = new ServiceManager\Config($config);
$sm = new ServiceManager\ServiceManager($configurator);
$service1 = $sm->get('invokable-class');
$service2 = $sm->create('invokable-class');
echo checkHowMuchTheSame($service1, $service2), PHP_EOL;

// What just happened is that the ServiceManager called $config->configureServiceManager(),
// which called $sm->setInvokableClass();
// There can be, and usually are, multiple service managers in a typical application, so the same instance of
// Zend\ServiceManager\Config could configure all of them.

