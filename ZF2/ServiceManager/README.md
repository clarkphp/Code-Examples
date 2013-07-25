# Code Examples for ZF2 ServiceManager

These examples go from basic to advanced ServiceManager usage. The *ServiceManager* is really just a locator or retriever of objects or resources (in the general sense, not necessarily PHP resource sense).  Since objects can be considered to perform "services" for the application, this locator is called the "Service" Manager.

You give the ServiceManager the name of a service, and it returns with that service, with any dependencies that service may require, already satisfied, if you've configured things correctly.

## The Basics - Examples Introducing ServiceManager
1. First, look at `introduction.php` to see some of the methods in the ServiceManager class in action.
2. Second, look at `service-type-invokable.php` to see how to set up and use an invokable service, with and without a configuration array.
3. Third, look at `service-type-service.php` to see how to set up and use an object instance as a service, with and without a configuration array.
