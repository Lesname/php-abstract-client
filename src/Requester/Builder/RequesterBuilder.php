<?php
declare(strict_types=1);

namespace LessAbstractClient\Requester\Builder;

use LessAbstractClient\Requester\Requester;
use Psr\Container\ContainerInterface;

interface RequesterBuilder
{
    /**
     * @param array<mixed> $config
     */
    public function build(ContainerInterface $container, array $config): Requester;
}
