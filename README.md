[![Latest Stable Version](https://poser.pugx.org/lezhnev74/prooph-direct-router/v/stable)](https://packagist.org/packages/lezhnev74/prooph-direct-router)
[![Build Status](https://travis-ci.org/lezhnev74/prooph-direct-router.svg?branch=master)](https://travis-ci.org/lezhnev74/prooph-direct-router)
[![License](https://poser.pugx.org/lezhnev74/prooph-direct-router/license)](https://packagist.org/packages/lezhnev74/prooph-direct-router)
[![Total Downloads](https://poser.pugx.org/lezhnev74/prooph-direct-router/downloads)](https://packagist.org/packages/lezhnev74/prooph-direct-router)


# Implicit routing a command to it's handler
A command is routed to the handler with the same name and "Handler" appended under the same namespace:
```php
namespace Some\Space;

// your command
class Command {}

// your command handler 
class CommandHandler {
    function __invoke(Command $cmd) {...} 
}
```

## Benefits

By using conventions (implicit routing) you can easily add commands\queries without constant updating configuration files. Just put both files in the same folder and follow the name convention:
- Handler class must be name exactly as a Command + `Handler` appended at the end
- Both command and a handler must reside under the same namespace

Just a handy tool :)
 
## Installation

```
composer require lezhnev74/prooph-direct-router
```

## Configuration

In case you use config files in your project, visit your `prooph.php` config file and update the "service_bus.command_bus.router.type" field.
If you set up message bus manually, then scroll down to the "Usage" section.

```php
//...
'service_bus' => [
    'command_bus' => [
        'router' => [
            'routes' => [
                // list of commands with corresponding command handler
            ],
            'type' => \DirectRouter\DirectRouter::class
        ],
    ],
//…
```


## Usage
This package uses dependency-container to locate the handler for a given command, 
so you need to install some container package (which supports [ContainerInterface](http://www.php-fig.org/psr/psr-11/))

```php
//
// Manual message bus setup
// 1. Prepare router
$router = new DirectRouter();
$router->attachToMessageBus($commandBus);
// 2. Add service locator (to instantiate the handler). $container is your implementation of PSR-11 ContainerInterface
$locator = new ServiceLocatorPlugin($container);
$locator->attachToMessageBus($bus);

//
// Dispatch command
//
$command = new \Some\Space\Command(...);
$commandBus->dispatch($command);
```

