<?php
namespace DirectRouterTests;

use DI\ContainerBuilder;
use DirectRouter\DirectRouter;
use DirectRouterTests\TestCommand\TestCommand;
use PHPUnit\Framework\TestCase;
use Prooph\ServiceBus\CommandBus;

class DirectRouterTest extends TestCase
{
    
    function test_handler_is_located_and_called() {
        $container = ContainerBuilder::buildDevContainer();
        $commandBus = new CommandBus();
    
        //
        // Define command
        //
        $output_text = "some text";
        $command = new TestCommand($output_text);
    
        //
        // Prepare router
        //
        $router = new DirectRouter($container);
        $router->attachToMessageBus($commandBus);
        
        //
        // Dispatch command
        //
        ob_start();
        $commandBus->dispatch($command);
        $buffered = ob_get_clean();
        
        //
        // Assert handler was located and called
        //
        $this->assertEquals($output_text, $buffered);
    }
    
}