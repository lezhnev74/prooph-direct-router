<?php
namespace DirectRouter;

use Prooph\Common\Event\ActionEvent;
use Prooph\ServiceBus\MessageBus;
use Prooph\ServiceBus\Plugin\Router\SingleHandlerRouter;
use Psr\Container\ContainerInterface;

//
// This router is meant to directly map command name to the handler located in the same namespace
// F.e. \A\CommandName => \A\CommandNameHandler
// Handler class must have "handle" method
//
class DirectRouter extends SingleHandlerRouter
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
        $handler_fqcn = get_class($command_fqcn)."Handler";
             
        if ($this->container->has($handler_fqcn)) {
            $handler_instance = $this->container->get($handler_fqcn);
            
            // Check that handler has handle method
            if(!method_exists($handler_instance, 'handle')) {
                return;
            }
                        
            $actionEvent->setParam(
                MessageBus::EVENT_PARAM_MESSAGE_HANDLER,
                [$handler_instance, 'handle']
            );
        }
        
    }
    
    
}