<?php
include __DIR__ . '/' . 'includes.php';
use Zend\ServiceManager;

$arrayService = array('This service happens to be an array. Services are generally objects.');

// This class is the template for a very simple service
class SimpleClass
{
    public $attribute = 'SimpleClassAttribute';
}

echo 'Instantiate SM (without configuration)', PHP_EOL;
$sm = new ServiceManager\ServiceManager();

echo 'What are all the services the SM is currently aware of? Use getRegisteredServices().', PHP_EOL;
echo print_r($sm->getRegisteredServices(), true), PHP_EOL;

echo 'Register a service with the SM', PHP_EOL;
$sm->setService('some-service', $arrayService);

echo 'Get the service from the service manager', PHP_EOL;
$service = $sm->get('some-service');
echo print_r($service, true), PHP_EOL;

echo 'Destroy original resource', PHP_EOL;
unset($arrayService);

echo 'Retrieve the service again; it is still available, since SM uses references', PHP_EOL;
$service = $sm->get('some-service');
echo print_r($service, true), PHP_EOL;

try {
    echo 'Attempt to register a service with a name that is already in use', PHP_EOL;
    $objectService = new StdClass();
    $sm->setService('some-service', $objectService);
} catch (ServiceManager\Exception\InvalidServiceNameException $e) {
    echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
}

echo 'Of course, we can still retrieve the service we previously registered', PHP_EOL;
$service = $sm->get('some-service');
echo print_r($service, true), PHP_EOL;

echo 'Show all registered services again. Note that getRegisteredServices() returns canonicalized names (lowercased, with word separator characters removed).', PHP_EOL;
echo print_r($sm->getRegisteredServices(), true), PHP_EOL;

echo 'Show all canonical service names by calling getCanonicalNames().', PHP_EOL;
echo print_r($sm->getCanonicalNames(), true), PHP_EOL;

echo 'Are exceptions thrown in SM create() method? - ';
var_dump($sm->getThrowExceptionInCreate()); echo PHP_EOL;

try {
    echo 'The create() method returns only object instances', PHP_EOL;
    $service = $sm->create('some-service');
} catch (\Exception $e) {
    echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
}

echo 'Can check to see if the SM can create the service by calling canCreate() method, but note that it only checks for the existence of the service name, not whether it can instantiate the service. Also note that you can always call has() instead of canCreate(), since has() itself calls canCreate() !', PHP_EOL
   , 'canCreate(\'some-service\') returns ';
var_dump($sm->canCreate('some-service'));
echo PHP_EOL;

echo 'Register an object instance with the SM and show all registered services', PHP_EOL;
try {
    $sm->setService('object-service', $objectService);
} catch (\Exception $e) {
    echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
}
echo 'Line ', __LINE__, '. After setting object service', print_r($sm->getRegisteredServices(), true), PHP_EOL;

echo 'SM create() method is for creating an object instance from a factory, invokable class, abstract factory, or an initializer. create() is not for retrieving an object instance already registered. An attempt to create a service using the service name of object already registered yields an exception:', PHP_EOL;
try {
    $service = $sm->create('object-service');
} catch (\Exception $e) {
    echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
}

echo 'Using get() method, the previously-registered object can be retrieved.', PHP_EOL;
$service = $sm->get('object-service');
var_dump($service); echo PHP_EOL;

echo 'Use setInvokableClass() to register a service using the name of a class. Then use either get() or create() method to retrieve an instance of that class.', PHP_EOL;

try {
    $sm->setInvokableClass('invokable-class', 'SimpleClass');
    echo 'Line ', __LINE__, ': service successfully set using class name: ', PHP_EOL, print_r($sm->getRegisteredServices(), true), PHP_EOL;
    echo 'Can use the SM has() method to check for existence of a service by name: ';
    var_dump($sm->has('invokable-class'));
    echo PHP_EOL;
} catch (\Exception $e) {
    echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
}

try {
    echo 'Retrieve the service we just registered, first using get(), then using create().  You would normally use get(). Remember, each retrieval yields a new instance.', PHP_EOL;
    $service1 = $sm->get('invokable-class');
    $service2 = $sm->create('invokable-class');
    var_dump($service1, $service2, $service1 === $service2);
    echo PHP_EOL;
} catch (\Exception $e) {
    echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
}

