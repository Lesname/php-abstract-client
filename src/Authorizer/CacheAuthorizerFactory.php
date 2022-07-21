<?php
declare(strict_types=1);

namespace LessAbstractClient\Authorizer;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\CacheInterface;

final class CacheAuthorizerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): Authorizer
    {
        $config = $container->get('config');
        assert(is_array($config));

        assert(is_array($config[CacheAuthorizer::class]));
        $settings = $config[CacheAuthorizer::class];

        assert(is_string($settings['proxy']));
        assert(is_int($settings['expire']));

        $cache = $container->get(CacheInterface::class);
        assert($cache instanceof CacheInterface);

        $proxy = $container->get($settings['proxy']);
        assert($proxy instanceof Authorizer);

        return new CacheAuthorizer($proxy, $cache, $settings['expire']);
    }
}
