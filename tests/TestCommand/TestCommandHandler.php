<?php
namespace DirectRouterTests\TestCommand;

class TestCommandHandler
{
    function handle(TestCommand $command): void {
        echo $command->getData();
    }
}