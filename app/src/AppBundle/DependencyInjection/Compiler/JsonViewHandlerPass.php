<?php

namespace AppBundle\DependencyInjection\Compiler;

use AppBundle\View\JsonViewHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class JsonViewHandlerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('fos_rest.view_handler.default');

        $definition->addMethodCall('registerHandler',
            [
                'json',
                [new Reference(JsonViewHandler::class), 'handle'],
            ]
        );
    }
}
