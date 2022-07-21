<?php
declare(strict_types=1);

namespace LessAbstractClient\Authorizer;

use LessAbstractClient\CurlRequester;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class LessIdentityAuthorizerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): LessIdentityAuthorizer
    {
        $config = $container->get('config');
        assert(is_array($config));
        assert(is_array($config[LessIdentityAuthorizer::class]));

        $settings = $config[LessIdentityAuthorizer::class];
        assert(is_string($settings['baseUri']));
        assert(is_string($settings['id']));

        assert(is_string($settings['secret']));
        assert(file_exists($settings['secret']));
        $secret = file_get_contents($settings['secret']);
        assert(is_string($secret));

        return new LessIdentityAuthorizer(
            new CurlRequester($settings['baseUri'], null),
            $settings['id'],
            $secret,
        );
    }
}
