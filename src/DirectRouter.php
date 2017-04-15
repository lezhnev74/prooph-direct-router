<?php

namespace DirectRouter;

use Prooph\Common\Event\ActionEvent;
use Prooph\ServiceBus\MessageBus;
use Prooph\ServiceBus\Plugin\AbstractPlugin;
use Prooph\ServiceBus\Plugin\Router\MessageBusRouterPlugin;
use Psr\Container\ContainerInterface;

//
// This router is meant to directly map command name to the handler located in the same namespace
// F.e. \A\CommandName => \A\CommandNameHandler
// Handler class must have "handle" method
//
class DirectRouter extends AbstractPlugin implements MessageBusRouterPlugin
{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function onRouteMessage(ActionEvent $actionEvent): void
    {
        // Find handler in the same namespace
        $command_fqcn = $actionEvent->getParam(MessageBus::EVENT_PARAM_MESSAGE);
        $handler_fqcn = get_class($command_fqcn) . "Handler";
        
        if ($this->container->has($handler_fqcn)) {
            $actionEvent->setParam(
                MessageBus::EVENT_PARAM_MESSAGE_HANDLER,
                $handler_fqcn
            );
        }
        
    }
    
    public function attachToMessageBus(MessageBus $messageBus): void
    {
        $this->listenerHandlers[] = $messageBus->attach(
            MessageBus::EVENT_DISPATCH,
            [$this, 'onRouteMessage'],
            MessageBus::PRIORITY_ROUTE
        );
    }
    
    
}