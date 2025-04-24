<?php
declare(strict_types=1);

namespace LesAbstractClient\Authorizer\Builder;

use LesAbstractClient\Authorizer\Authorizer;
use Psr\Container\ContainerInterface;

interface AuthorizerBuilder
{
    /**
     * @param array<mixed> $config
     */
    public function build(ContainerInterface $container, array $config): Authorizer;
}
