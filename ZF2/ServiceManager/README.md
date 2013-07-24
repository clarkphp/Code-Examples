# Code Examples for ZF2 ServiceManager

These examples go from basic to advanced ServiceManager usage. The ServiceManager is really just a locator or retriever of objects or resources (in the general sense, not necessarily PHP resource sense).  Since objects can be considered to perform "services" for the application, this locator is called the "Service" Manager.

You give the ServiceManager the name of a service, and it returns with that service, with any dependencies that service may require, already satisfied.

