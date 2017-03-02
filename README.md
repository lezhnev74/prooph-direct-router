# Router for implicit mapping command to it's handler
Command maps to the same FQCN with "Handler" appended:
```php
namespace Some\Space;

class Command {
...
}

class CommandHandler {
    function handle(Command $cmd) {...}
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
$router = new DirectRouter($container);
$router->attachToMessageBus($commandBus);

//
// Dispatch command
//
$commandBus->dispatch($command);
```

## Benefits
By using conventions (implicit routing) you can easily add commands\queries without constant updating configurations.
Just a handy tool. 