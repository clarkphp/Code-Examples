<?php
error_reporting(E_ALL | E_STRICT);
/**
 * A user class for demonstration purposes.
 * @link http://www.php.net/manual/en/language.oop5.php
 */
class User
{
	public $a;
	public $b;

    public static $objectType = 'User';

    /**
     * User's full name
     *
     * @var string
     */
    public $name = 'My Name';

    /**
     * User's age
     *
     * @var integer
     */
    protected $age = 0;

    /**
     * User's dna code
     *
     * @var string
     */
    private $dna = 'AGCU';

    public $clone = false;

    /**
     * Contructor, simulates connecting to a database if given a user id.
     *
     * @param integer $id
     * @return null
     */
    public function __construct($id = null)
    // In PHP 4 (valid also for PHP5), this method would be named User($id = null),
    // and the keyword "public" does not exist.
    // In PHP5, __construct() is recommended.
    {
//    	$this->a = 's;dklfjd';
//    	$this->b = $a;
    	
//    	$this->b = 3434;
//    	$this->a = $this->b;
    	
        if (null == $id) {
            echo "No id to work with: returning<br />";
            return;
        }
        echo "id is $id. Could search a db for that user id.<br />";
    }

    /**
     * Destructor method, automatically invoked when object is destroyed.
     */
    public function __destruct()
    // PHP 4 does not have destructors,
    // though many people have written about how to emulate that behavior.
    {
        echo "Cleanup code goes here.<br />";
    }

    public static function classType()
    {
        return 'User class';
    }

    /**
     * Accessor method: obtains the current User's name.
     *
     * @return string User name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Accessor method: sets the current User's name to a value.
     *
     * @return string User name
     */
    public function setName($name = null)
    {
        $this->name = $name ? $name : 'My Name';
        return $this->name;
    }

    /**
     * Return user's age
     *
     * @return string User's age
     */
    protected function userAge()
    {
        return $this->age;
    }

    /**
     * Accessor method: obtains the current User's dna!
     *
     * @return string User DNA code
     */
    public function getDna()
    {
    	return $this->dna;
    }

    public function doUserStuff()
    {
        echo 'Doing some user stuff (' . __METHOD__ . ")<br />";
    }

    private function cantTouchThis() {
    	return $this->age;
    }
    
//    public function __clone()
//    {
//        throw new Exception('Clone me not!'); // do this to prevent cloning
//          $this->clone = true;
//    }

}

$user = new User(6);
$mom = new User();
$dad = new User();

$mom->setName('Mother');
$dad->name = 'Dad';
echo $user->getName() . '<br />';
echo 'User name is now ' . $user->setName('Clarko') . '<br />';
echo "Mom is {$mom->name}<br />, and dad is {$dad->name}<br />";


echo "Static member " . User::$objectType . '<br />';

echo "Static member " . User::classType() . '<br />';

$classname = 'User';
$testUser = new $classname();
$property = 'name';
echo 'Line ' .  __LINE__ . $testUser->$property . PHP_EOL;

$testUser->a;
$testUser->b;


$user = new User();
//echo $user->userAge();

echo "Attribute/property: The user's name is $user->name<br />";
echo 'Method: The user\'s name is ' . $user->getName(). "<br />";

// no further code here (script ends); this is going "out of scope".
// Therefore, the destructor will be called.
// exit;

$user = null; // unset($user);

$user = new User(5);
unset($user);  // also results in destructor method running


$user = new User(5);
$user = null;  // also results in destructor method running

////////////////// Static Properties and Methods

///////////


class Foo
{
    public static $staticVar = 'foo';

    function staticValue() {
        return self::$staticVar;
    }
}

print 'Line ' . __LINE__ . ': Static access of class property ' . Foo::$staticVar . "<br />";
// change static property value
Foo::$staticVar = 'new value';
print 'New class property value' . Foo::$staticVar . "<br />";


$foo = new Foo();
print 'Access an object instance\'s property ' . $foo->staticValue() . "<br />";

// Undefined "Property" staticVar , since this is an object instance.
print 'Accessing static var as an object property yields: ' . $foo->staticVar . "<br />";

// PHP 5.3.0 only:
// $classname = 'Foo';
// print $classname::$my_static . "<br />";
/////////////
class FooMethod {

    public static $free = 'speech';

    public static function aStaticMethod() {
        return 'In static method ' . __METHOD__ . "<br />"
           . 'Open source is free as in ' . self::$free . "<br />";
    }

    // Static methods cannot access properties using $this,
    // since we are not in an object context.
    public static function doNotTryThis() {
        return 'In static method ' . __METHOD__ . "<br />"
           . 'Open source is free as in ' . $this->free . "<br />";
    }
}

// Static method call
echo 'Line ' . __LINE__ . ': '. FooMethod::aStaticMethod();

// Non-static call of a static method. This is okay.
$foo = new FooMethod();
echo 'Line ' . __LINE__ . ': '. $foo->aStaticMethod();

// see doNotTryThis() for the problem
//echo 'Line ' . __LINE__ . ': '. $foo->doNotTryThis();

// PHP 5.3.0 only: variable class names.
// $classname = 'Foo';
// echo 'Line ' . __LINE__ . ': '. $classname::aStaticMethod();


/////////
//Added in PHP v.5.3, "Late static binding" means that static:: (as apposed to self::)  is resolved using runtime information and not the name of the class it was defined in
//It is also called a "static binding" as it can be used for (but is not limited to) static method calls.
//"Late static binding"  means that static::  is no longer resolved using the class where the method is defined but it is computed using runtime information. 
/////////

/////////////////
// Create a static method called changeCase() in a class called Functions
// that will change a given string to lowercase or uppercase based on a parameter

$string = "Hello, World<br />";
echo Functions::changeCase($string, 'upper');
echo Functions::changeCase($string, 'lower');
echo Functions::changeCase($string, 34);

class Functions
{
    /**
     * Case-fold a string. If an invalid action is specified,
     * then returns the original string.
     *
     * @param string $string Input string to be upper- or lowercased.
     * @param string $action 'upper' | 'lower'
     * @return string Upper-cased, lower-cased, or original string
     */
    public static function changeCase($string, $action = null)
    {
        switch ($action) {
            case 'upper':
                $string = strtoupper($string);
                break;

            case 'lower':
                $string = strtolower($string);
                break;

            default:
                break;
        }
        return $string;
    }
}

/////////
//class Functions {
//	static function changeCase($str, $doLower) {
//		if ($doLower) {
//			return strtolower($str);
//		} else {
//			return strtoupper($str);
//		}
//	}
//}
//////

////////////////
// Class constants
class SystemUser
{
    const TYPE_GUEST = 1;
    const TYPE_USER = 2;
    const TYPE_ADMIN = 3;

    public static $testVar;

    public $type = self::TYPE_GUEST;

    public function __construct($userType = null)
    {
        if (! empty($userType)) {
            $this->type = $userType;
        }
    }

    public static function testStatic() {
        return self::$testVar;
    }
}
echo SystemUser::testStatic();

$user = new SystemUser(SystemUser::TYPE_ADMIN);
if (SystemUser::TYPE_ADMIN ==  $user->type) {
    echo "User is an administrator<br />";
}

// Visibility of class members
class Person extends User
{
    public function getData() {
        return $this->dna;
    }

    public function getUserAge()
    {
    	echo $this->cantTouchThis(); // fails - does not exist
        return $this->userAge(); // userAge() is visible to Person (protected inside User class)
        
    }

    protected function cantTouchThis()
    {
        return 'do some silly stuff';
    }

}
echo '<h1>Visibility</h1>';
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);
echo ini_get('display_errors');
$user = new Person(1);
var_dump($user);
echo 'Age is ' . $user->getUserAge() . "<br />";
//echo 'Age is ' . $user->userAge() . "<br />";

echo 'DNA code is ' . $user->dna .  "<br />";
echo 'DNA code is ' . $user->getDna() .  "<br />";
echo 'DNA code is ' . $user->getData() .  "<br />";

////
// Example from class - getters and setters
class david
{
    protected $data = 'protected_data';

    public function getProtectedData()
    {
        return $this->data;
    }

    public function setProtectedData($value)
    {
        $this->data = $value;
    }
}

$class = new david();
echo $class->getProtectedData() . "<br />";

//$class->data = 'Bill'; // this won't work
$class->setProtectedData('Bill'); // this will work

echo $class->getProtectedData() . "<br />";
exit;
////
// Inheritance
class myClass
{
    public $value = 'Inherited';
}

class newClass extends myClass
{}

$obj = new newClass();
echo $obj->value . "<br />";

// Inheritance
class myClass1
{
    private $var = 1;
}

class myClass2 extends myClass1
{
    public function getVar()
    {
        return $this->var;
    }
}

$obj = new myClass2();
echo $obj->getVar();

// Overriding Methods
class AdminUser extends User
{
    public function doUserStuff()
    {
        echo 'Doing some Admin user stuff (' . __METHOD__ . ")<br />";
        // parent::doUserStuff(); // runs the parent's version of the method
    }

}

$user = new AdminUser(12);
$user->doUserStuff();

// More on $this and parent
class test1
{
    // defines test1::f2()
    public function f2()
    {
        echo 'f2 from ' . __METHOD__ . ' ';
    }
}

class test2 extends test1
{
    // defines test2::f1()
    // and test2::f2()

    public function f1()
    {
        echo $this->f2()
           . parent::f2();
    }

    public function f2()
    {
        echo 'f3 from ' . __METHOD__ . ' ';
    }

}
$test = new test2();
$test->f1();

// visibility and overriding
class class1
{
    public function test()
    {
        return 1;
    }

    public function test2()
    {
        return $this->test();
    }
}

// access to class2::test() must be public, as it is in class1
// can loosen visibility in child classes, but not make it more
// restrictive
// uncomment and run to see for yourself
//class class2 extends class1
//{
//    protected function test() // protected visibility is too restrictive to override class1::test()
//    {
//        return 2;
//    }
//
//}

$test = new class2();
echo $test->test2();

// Type Hinting
function myFunction(Countable $i)
{
    ;
}
$a = new ArrayObject();
myFunction($a);

/**
 * An example class demonstrating type hinting
 */
class ThisClass
{
    /**
     * A method we require be passed an object of type ThatClass.
     * @param ThatClass $object Some object
     * @return null
     */
    public function functionUsingAnObject(ThatClass $object)
    {
        echo $object->var . "<br />";
    }

    /**
     * A method we require be passed an array.
     * @param array $var Some array variable
     *        Note it has nothing to do with the $var in ThatClass.
     * @return null
     */
    public function functionUsingAnArray(array $var)
    {
        echo $var[0] . "<br />";
    }
}

/**
 * Another example class for type hinting
 */
class ThatClass
{
    public $var = 'Not Another Hello, World!';
}

// Using the classes
$a = new ThisClass();
$b = new ThatClass();
$c = array('some', 'sample', 'data');

$a->functionUsingAnObject($b); // pass a ThatClass instance
$a->functionUsingAnArray(explode(' ', $b->var)); // pass an array
$a->functionUsingAnArray($c);

// Misusing the classes - catchable fatal error
$a->functionUsingAnObject('Invalid to pass method a string');
$a->functionUsingAnArray('Invalid to pass method a string');


//////// Polymorphism - see User and AdminUser classes above
function doSomething(User $obj)
{
    echo $obj->getName();
}

$regularUser = new User(18);
$adminUser = new AdminUser(8);
doSomething($adminUser); // AdminUser class is a User class, because it inherits from User base class

function doSomethingElse(AdminUser $obj)
{
    echo strtoupper($obj->getName());
}

doSomethingElse($adminUser); // this works fine
doSomethingElse($regularUser); // this causes an error, because User is NOT an AdminUser

// Interfaces specify which methods a class must implement, without having to define
// how these methods are handled.
// http://www.php.net/manual/en/language.oop5.interfaces.php
// An interface, together with type-hinting, provides a good way to make sure that a
// particular object contains particular methods. See instanceof operator and type hinting.

interface iTemplate // use the keyword "interface", not "class"
{
    public function setVariable($name, $var);
    public function getHtml($template);
}

// Implement the interface
// This will work
class Template implements iTemplate
{
    private $vars = array();

    public function setVariable($name, $var)
    {
        $this->vars[$name] = $var;
    }

    public function getHtml($template)
    {
        foreach($this->vars as $name => $value) {
            $template = str_replace('{' . $name . '}', $value, $template);
        }

        return $template;
    }
}

// This will not work
// Fatal error: Class BadTemplate contains 1 abstract methods (getHtml isn't defined here)
// and must therefore be declared abstract (iTemplate::getHtml)
class BadTemplate implements iTemplate
{
    private $vars = array();

    public function setVariable($name, $var)
    {
        $this->vars[$name] = $var;
    }
}

$myTemplate = new Template();
$originalHtml = '<html><head><title>{title}</title></head><body>You are logged in as: {username}</body></html>';
$myTemplate->setVariable('title', 'Example Interface');
$myTemplate->setVariable('username', 'Clark');
echo $myTemplate->getHtml($originalHtml);

interface MobilePhone
{
    public function dialNum();
    public function call();
    public function hangUp();
    public function takePhoto();
    public function recordVoiceNote();
}

// Interfaces
interface myInterface {
    function test();
}

//class myClass extends myInterface
//{
//    public function test()
//    {
//        echo 'test';
//    }
//}
//function myFunction(myInterface $obj)
//{
//    $obj->test();
//}
$obj = new myClass();
myFunction($obj);

// Abstract classes
// http://www.php.net/manual/en/language.oop5.abstract.php
// When inheriting from an abstract class, all methods marked abstract in the parent's class
// declaration must be defined by the child; additionally, these methods must be defined
// with the same (or a less restricted) visibility. For example, if the abstract method is
// defined as protected, the function implementation must be defined as either protected
// or public, but not private.

abstract class AbstractClass
{
    // Force Extending class to define these methods
    abstract protected function getValue();
    abstract protected function prefixValue($prefix);

    // Common method
    public function printOut() {
        print $this->getValue() . "<br />";
    }
}

class ConcreteClass1 extends AbstractClass
{
    protected function getValue() {
        return "ConcreteClass1";
    }

    public function prefixValue($prefix) {
        return "{$prefix}ConcreteClass1";
    }
}

class ConcreteClass2 extends AbstractClass
{
    public function getValue() {
        return "ConcreteClass2";
    }

    public function prefixValue($prefix) {
        return "{$prefix}ConcreteClass2";
    }
}

$class1 = new ConcreteClass1;
$class1->printOut();
echo $class1->prefixValue('FOO_') ."<br />";

$class2 = new ConcreteClass2;
$class2->printOut();
echo $class2->prefixValue('FOO_') ."<br />";

// Final keyword
// used on classes and methods, NOT on properties
// Some notes for Java developers:
// The final keyword doesn't change the visibility of a property / method, which is public by default.
// the 'final' keyword is not used for class constants in PHP. We use the keyword 'const'.

///// References and Objects
// http://www.php.net/manual/en/language.oop5.references.php
class A {
    public $foo = 1;
}

$a = new A;
$b = $a;     // $a and $b are different identifiers; same instance of the same object 
             // ($a) = ($b) = <id>
$b->foo = 2;
echo $a->foo."<br />";


$c = new A;
$d = &$c;    // $c and $d are references; not necessary in PHP 5
             // ($c,$d) = <id>

$d->foo = 2;
echo $c->foo."<br />";


$e = new A;

function foo($obj) {
    // ($obj) = ($e) = <id>
    $obj->foo = 2;
}

foo($e);
echo $e->foo."<br />";

// Cloning objects, and comparing them
$user1 = new User(9);
$user2 = clone $user1;

echo 'The user objects are' . ($user1 == $user2 ? '' : ' not') . " equivalent.<br />";
echo 'The user objects are' . ($user1 === $user2 ? '' : ' not') . " identical.<br />";

//echo var_dump($user1->clone, $user2->clone);
