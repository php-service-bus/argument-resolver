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

use ServiceBus\Common\Context\ServiceBusContext;
use ServiceBus\Common\MessageHandler\MessageHandlerArgument;

final class ChainArgumentResolver
{
    /**
     * @var ArgumentResolver[]
     */
    private $resolvers;

    /**
     * @psalm-param list<ArgumentResolver> $resolvers
     */
    public function __construct(array $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    /**
     * @psalm-param \SplObjectStorage<MessageHandlerArgument, null> $arguments
     */
    public function resolve(\SplObjectStorage $arguments, object $message, ServiceBusContext $context): array
    {
        $preparedArguments = [];

        /** @var MessageHandlerArgument $argument */
        foreach ($arguments as $argument)
        {
            foreach ($this->resolvers as $argumentResolver)
            {
                if ($argumentResolver->supports($argument))
                {
                    $preparedArguments[] = $argumentResolver->resolve(
                        message: $message,
                        context: $context,
                        argument: $argument
                    );
                }
            }
        }

        return $preparedArguments;
    }
}
