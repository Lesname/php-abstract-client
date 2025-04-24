<?php
declare(strict_types=1);

namespace LesAbstractClient\Authorizer\Builder;

use Override;
use LesAbstractClient\Authorizer\Authorizer;
use LesAbstractClient\Authorizer\CacheAuthorizer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\CacheInterface;

final class CacheAuthorizerBuilder implements AuthorizerBuilder
{
    /**
     * @param array<mixed> $config
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Override]
    public function build(ContainerInterface $container, array $config): Authorizer
    {
        assert(is_array($config['proxy']));
        assert(is_string($config['proxy']['builder']));
        assert(is_subclass_of($config['proxy']['builder'], AuthorizerBuilder::class));
        $builder = new $config['proxy']['builder']();

        assert(is_array($config['proxy']['config']));
        $proxy = $builder->build($container, $config['proxy']['config']);

        $cache = $container->get(CacheInterface::class);
        assert($cache instanceof CacheInterface);

        assert(is_string($config['key']));
        assert(is_int($config['expire']));

        return new CacheAuthorizer(
            $proxy,
            $cache,
            $config['key'],
            $config['expire'],
        );
    }
}
