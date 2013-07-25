<?php
// This example has a dependency on a listener, in this case a validator, so take this just as an example demonstrating that
// a listener can have, if desired, access to the triggering object, and that to cause some action to take place whenever
// a method is called, you can trigger an event from within that method.

// A validator or filter that is automatically triggered could make sense, but takes more infrastructure than is shown here,
// for example, to have an object activated to look for validators and run them on a set on input values.

include __DIR__ . '/' . 'includes.php';

use Zend\EventManager;

$events = new EventManager\EventManager();
try {
    $validator = new Validator();
    $events->attach(
        'start.pullCart',
        array($validator, 'validate'),
        1000
    );
} catch (\Exception $e) {
    echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
}

echo 'Listeners are attached', PHP_EOL;

$horse = new Workhorse($events);
$horse->pullCart();
echo "It took {$horse->getCompletionTime()} hours to pull the light load uphill", PHP_EOL, PHP_EOL;

$horse->pullCart('heavy');
echo "It took {$horse->getCompletionTime()} hours to pull the heavy load uphill", PHP_EOL, PHP_EOL;

$horse->pullCart('heavy', 'downhill');
echo "It took {$horse->getCompletionTime()} hours to pull the heavy load downhill", PHP_EOL, PHP_EOL;

$horse->pullCart('light', 'uphill');
echo "It took {$horse->getCompletionTime()} hours to pull the heavy load uphill", PHP_EOL, PHP_EOL;

class Validator
{
    public function validate(EventManager\Event $event)
    {
        $eventName = $event->getName();
        $params = $event->getParams();
        $target = $event->getTarget();

        $factor = null;
        switch ($params['weight'])
        {
            case 'light': 
                $factor = 1;
                break;
            case 'heavy': 
                $factor = 2;
                break;
            default:
                // no nothing
        }
        $target->setWeightFactor($factor);

        $factor = null;
        switch ($params['direction'])
        {
            case 'downhill': 
                $factor = 1;
                break;
            case 'uphill': 
                $factor = 2;
                break;
            default:
                // no nothing
        }
        $target->setDirectionFactor($factor);
    }
}

class Workhorse
{
    protected $em = null;
    protected $completionTime = null;
    protected $weightFactor = 0;
    protected $directionFactor = 0;

    public function __construct(EventManager\EventManager $em)
    {
        $this->em = $em;
    }

    public function setWeightFactor($factor)
    {
        $this->weightFactor = $factor ? $factor : 0;
    }

    public function setDirectionFactor($factor)
    {
        $this->directionFactor = $factor ? $factor : 0;
    }

    public function getCompletionTime()
    {
        return $this->completionTime;
    }

    public function pullCart($weight = 'light', $direction = 'uphill')
    {
        $params = compact('weight', 'direction');
        try {
            $this->em->trigger(
                'start.' . __FUNCTION__, // typical in ZF2 to use the function/method name somewhere in the event name
                $this, // passed to listeners, so they have access to this object, the "context" for the triggered event
                $params // listeners have the arguments passed to the triggering method
            );

            $this->completionTime = $this->weightFactor * $this->directionFactor;

            // this one is ready for listeners
            $this->em->trigger('end.' . __FUNCTION__, $this, $params);
        } catch (\Exception $e) {
            echo 'Line ', __LINE__, ': ', get_class($e), ' - ', $e->getMessage(), PHP_EOL, PHP_EOL;
        }

        return $this->completionTime;
    }
}

