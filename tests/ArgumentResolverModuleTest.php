<?php

/**
 * Argument resolver implementation.
 *
 * @author  Maksim Masiukevich <contacts@desperado.dev>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace ServiceBus\ArgumentResolver\Tests;

use PHPUnit\Framework\TestCase;
use ServiceBus\ArgumentResolver\ArgumentResolverModule;
use ServiceBus\ArgumentResolver\ContainerArgumentResolver;
use ServiceBus\ArgumentResolver\ContextArgumentResolver;
use ServiceBus\ArgumentResolver\MessageArgumentResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class ArgumentResolverModuleTest extends TestCase
{
    /**
     * @test
     */
    public function boot(): void
    {
        $containerBuilder = new ContainerBuilder();

        (new ArgumentResolverModule())->boot($containerBuilder);

        self::assertTrue($containerBuilder->hasDefinition(MessageArgumentResolver::class));
        self::assertTrue($containerBuilder->hasDefinition(ContextArgumentResolver::class));
        self::assertTrue($containerBuilder->hasDefinition(ContainerArgumentResolver::class));

        $containerBuilder->compile();

        self::assertTrue($containerBuilder->hasDefinition('service_bus.services_locator'));
        self::assertEquals(
            ServiceLocator::class,
            $containerBuilder->getDefinition('service_bus.services_locator')->getClass()
        );
    }
}
