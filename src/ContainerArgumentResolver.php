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
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ContainerArgumentResolver implements ArgumentResolver
{
    /**
     * @var ContainerInterface
     */
    private $serviceLocator;

    public function __construct(ContainerInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function supports(MessageHandlerArgument $argument): bool
    {
        return $argument->isObject && $this->serviceLocator->has((string) $argument->typeClass);
    }

    public function resolve(object $message, ServiceBusContext $context, MessageHandlerArgument $argument): object
    {
        /**
         * @noinspection PhpUnnecessaryLocalVariableInspection
         *
         * @var object $object
         */
        $object = $this->serviceLocator->get((string) $argument->typeClass);

        return $object;
    }
}
