<?php
include __DIR__ . '/' . 'includes.php';
use Zend\ServiceManager;

$arrayService = array('This service happens to be an array.');

echo 'Instantiate SM without configuration', PHP_EOL;
$sm = new ServiceManager\ServiceManager();

echo 'What are all the services the SM is currently aware of?', PHP_EOL;
echo print_r($sm->getRegisteredServices(), true), PHP_EOL;

echo 'Register a service with the SM', PHP_EOL;
$sm->setService('some-service', $arrayService);

echo 'Get the service from the service manager', PHP_EOL;
$service = $sm->get('some-service');
echo print_r($service, true), PHP_EOL;

echo 'Destroy original resource', PHP_EOL;
unset($arrayService);

echo 'Retrieve the service again; it is still available', PHP_EOL;
$service = $sm->get('some-service');
echo print_r($service, true), PHP_EOL;

try {
    echo 'Attempt to register a service with the SM with a name that is already in use', PHP_EOL;
    $objectService = new StdClass();
    $sm->setService('some-service', $objectService);
} catch (ServiceManager\Exception\InvalidServiceNameException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
}

echo 'We can still get the service we previously registered', PHP_EOL;
$service = $sm->get('some-service');
echo print_r($service, true), PHP_EOL;

echo 'Show all registered services', PHP_EOL;
echo print_r($sm->getRegisteredServices(), true), PHP_EOL;

echo 'Are exceptions thrown in SM create method? - ';
var_dump($sm->getThrowExceptionInCreate()); echo PHP_EOL;

try {
    $service = $sm->create('some-service');
} catch (ServiceManager\Exception\ServiceNotFoundException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
}

echo 'Register object instance service with the SM and show all registered services', PHP_EOL;
try {
    $sm->setService('object-service', $objectService);
} catch (ServiceManager\Exception\InvalidServiceNameException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
} catch (ServiceManager\Exception\ServiceNotFoundException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
}
echo 'Line ', __LINE__, '. After setting object service', print_r($sm->getRegisteredServices(), true), PHP_EOL;

echo 'SM create method is for getting an object from a factory, invokable class, an abstract factory, or an initializer, not for an object instance already registered. Attempt to create service using name of object service', PHP_EOL;
try {
    $service = $sm->create('object-service');
} catch (ServiceManager\Exception\InvalidServiceNameException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
} catch (ServiceManager\Exception\ServiceNotFoundException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
}

echo 'Using get method, retrieve the object service that was successfully registered', PHP_EOL;
$service = $sm->get('object-service');
var_dump($service); echo PHP_EOL;

echo 'Register and attempt to create service using name of a class', PHP_EOL;
class SimpleClass
{
    public $attribute = 'SimpleClassAttribute';
    public function __construct()
    {
    }
}
try {
    $sm->setInvokableClass('invokable-class', 'SimpleClass');
    echo 'Line ', __LINE__, 'service successfully set using class name: ', print_r($sm->getRegisteredServices(), true), PHP_EOL;
} catch (ServiceManager\Exception\InvalidServiceNameException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
} catch (ServiceManager\Exception\ServiceNotFoundException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
}

try {
    echo 'Attempt to retrieve the service we just set', PHP_EOL;
    $service = $sm->get('invokable-class');
    var_dump($service); echo PHP_EOL;
} catch (ServiceManager\Exception\InvalidServiceNameException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
} catch (ServiceManager\Exception\ServiceNotFoundException $e) {
    echo 'Line ', __LINE__, ': ', $e->getMessage(), PHP_EOL;
}

