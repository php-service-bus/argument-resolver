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
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ArgumentResolverModuleTest extends TestCase
{
    /**
     * @test
     */
    public function boot(): void
    {
        $containerBuilder = new ContainerBuilder();

        (new ArgumentResolverModule())->boot($containerBuilder);

        $containerBuilder->compile();

        self::assertTrue(true);
    }
}
