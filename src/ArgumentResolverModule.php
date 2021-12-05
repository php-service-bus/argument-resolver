<?php

/**
 * Argument resolver implementation.
 *
 * @author  Maksim Masiukevich <contacts@desperado.dev>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=0);

namespace ServiceBus\ArgumentResolver;

use ServiceBus\Common\Module\ServiceBusModule;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class ArgumentResolverModule implements ServiceBusModule
{
    public function boot(ContainerBuilder $containerBuilder): void
    {
        if ($containerBuilder->hasDefinition('service_bus.services_locator') === false)
        {
            $definition = (new Definition(ServiceLocator::class, [[]]))->setPublic(true);

            $containerBuilder->addDefinitions(['service_bus.services_locator' => $definition]);
        }

        $containerBuilder->addDefinitions(
            [
                /** Passing message to arguments */
                MessageArgumentResolver::class   => new Definition(MessageArgumentResolver::class),
                /** Passing context to arguments */
                ContextArgumentResolver::class   => new Definition(ContextArgumentResolver::class),
                /** Autowiring of registered services in arguments */
                ContainerArgumentResolver::class => (new Definition(
                    class: ContainerArgumentResolver::class,
                    arguments: ['$serviceLocator' => new Reference('service_bus.services_locator')]
                ))->addTag('service_bus_argument_resolver', [])
            ]
        );
    }
}
