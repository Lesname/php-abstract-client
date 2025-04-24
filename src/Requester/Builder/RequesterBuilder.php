<?php
declare(strict_types=1);

namespace LesAbstractClient\Requester\Builder;

use LesAbstractClient\Requester\Requester;
use Psr\Container\ContainerInterface;

interface RequesterBuilder
{
    /**
     * @param array<mixed> $config
     */
    public function build(ContainerInterface $container, array $config): Requester;
}
