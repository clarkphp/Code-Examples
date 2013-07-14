<?php
/*
    This comment adapted from the API documentation:
    Use the EventManager when you want to create a per-instance notification system for your objects.

    attach()
    In the call to attach(), the first argument is the event, and the next argument describes a callback
    that will respond to that event. A CallbackHandler instance describing the event listener combination will be returned.

    The last argument indicates a priority at which the event should be executed. By default, this value is 1;
    however, you may set it for any integer value. Higher values have higher priority (i.e., execute earlier).

    You can specify "*" for the event name. In such cases, the listener will be triggered for every event.

    trigger()
    In the call to trigger(), the first argument is the event name, the second (optional) argument is the 'target',
    which is either the object or function (method) calling trigger.
    
    The third argument is an optional array of arguments, which listeners can access.
    The final argument is an optional callback, and will be discussed in later examples.
 */
include __DIR__ . '/' . 'includes.php';

use Zend\EventManager;
$events = new EventManager\EventManager();

// Attach the listener 'doListener' to the event 'do'
try {
    $events->attach(
        'do', // the name of the event (can be an array, discussed in later examples)
        'doListener' // here the callback is a regular function, specified by it's name
        // optional 'priority' value is 1
    );

    // Attach second listener to the same event
    $events->attach(
        'do',
        'doListener::staticDoListener', // here the callback is a static class method
            // You can also use this notation to specify a static class method:
            // array('doListener', 'staticDoListener')
        10 // this listener has higher priority than 'doListener', and thus will run earlier
    );

    // Attach third listener to the same event
    $handlers = new myEventHandlers();
    $events->attach(
        'do',
        array($handlers, 'instanceMethodListener'),
        10 // this listener has the same priority as 'staticDoListener'; since it is
           // being registered with the EventManager after 'staticDoListener,' it
           // will run after that listener, but before the regular function listener,
           // which has lower priority of 1
    );

    // Attach fourth listener, an anonymous function, to the event
    $events->attach(
        'do',
        function ($event) {
            $eventName = $event->getName();
            $params = $event->getParams();
            echo 'Manipulating the arguments from the event. ', __FUNCTION__, ' handled event "', $eventName,
                '", uppercasing the parameters: ', implode(', ', array_map('strtoupper', $params)), PHP_EOL, PHP_EOL;
        },
        20 // highest priority in this example script, and thus will run first
    );

    // Attach fifth listener, a closure. Remember, if you do this, the closure must
    // exist before the call to attach(). I.e., the assignment statement here must
    // be executed prior to the call to attach().
    $closure = function ($event) {
        $eventName = $event->getName();
        $params = $event->getParams();
        echo 'Closure ', __FUNCTION__, ' handled event "', $eventName,
            '", swapping the parameters: ', print_r(array_flip($params), true), PHP_EOL, PHP_EOL;
    };

    $events->attach(
        'do',
        $closure,
        15 // runs second when the event is triggerd
    );
} catch (EventManager\Exception\InvalidArgumentException $e) {
    echo $e->getMessage(), PHP_EOL;
}

// these parameters become part of the event when it is triggered
$params = array('foo' => 'bar', 'baz' => 'bat');

try {
    // Triggering an event causes all the attached listeners to respond to the event
    $events->trigger(
        'do', // the event we are triggering
        null, // optional 'target', discussed in later examples
        $params // optional array of arguments available to the event (and to listeners handling the event)
    );
} catch (Exception\InvalidCallbackException $e) {
    echo $e->getMessage(), PHP_EOL;
}

// The remaining callbacks which act as listeners (handlers) of events
function doListener($event)
{
    $eventName = $event->getName();
    $params = $event->getParams();
    echo 'Simple function ', __FUNCTION__, ' handled event "', $eventName, '", with parameters ',
        json_encode($params), PHP_EOL, PHP_EOL;
}

class doListener
{
    static function staticDoListener($event)
    {
        $eventName = $event->getName();
        $params = $event->getParams();
        echo 'Static class method ', __METHOD__, ' handled event "', $eventName, '", and found ',
            count($params), ' parameters ', PHP_EOL, PHP_EOL;
    }
}

class myEventHandlers
{
    function instanceMethodListener($event)
    {
        $eventName = $event->getName();
        $params = $event->getParams();
        echo 'Instance object method ', __METHOD__, ' handled event "', $eventName,
            '", examined the parameters, and determined their data types to be ';

        $typeInfo = '';
        foreach ($params as $value) {
            $typeInfo .= $value . ': ' . gettype($value) . ', ';
        }
        echo substr($typeInfo, 0, -2), PHP_EOL, PHP_EOL;
    }
}

