<?php
namespace DirectRouterTests\TestCommand;

class TestCommandHandler
{
    function __invoke(TestCommand $command): void {
        echo $command->getData();
    }
}