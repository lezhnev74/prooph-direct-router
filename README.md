[![Latest Stable Version](https://poser.pugx.org/lezhnev74/prooph-direct-router/v/stable)](https://packagist.org/packages/lezhnev74/prooph-direct-router)
[![Build Status](https://travis-ci.org/lezhnev74/prooph-direct-router.svg?branch=master)](https://travis-ci.org/lezhnev74/prooph-direct-router)
[![License](https://poser.pugx.org/lezhnev74/prooph-direct-router/license)](https://packagist.org/packages/lezhnev74/prooph-direct-router)
[![Total Downloads](https://poser.pugx.org/lezhnev74/prooph-direct-router/downloads)](https://packagist.org/packages/lezhnev74/prooph-direct-router)


# Router for implicit mapping command to it's handler (in the same namespace)
Command maps to the same FQCN with "Handler" appended:
```php
namespace Some\Space;

class Command {
...
}

// apply standard invoking strategy
class CommandHandler {
    function __invoke(Command $cmd) {...} 
}
```

## Usage
Router uses DI container to locate handler, so you need some container supporting PSR-11 for this one

```php
//
// Prepare command
//
$command = new \Some\Space\Command(...);

//
// Prepare router
//
$router = new DirectRouter();
$router->attachToMessageBus($commandBus);

//
// Add service locator (to instantiate the handler)
//
$locator = new ServiceLocatorPlugin($container);
$locator->attachToMessageBus($bus);

//
// Dispatch command
//
$commandBus->dispatch($command);
```

## Benefits
By using conventions (implicit routing) you can easily add commands\queries without constant updating configurations.
Just a handy tool.
 
## Install

```
composer require lezhnev74/prooph-direct-router
```