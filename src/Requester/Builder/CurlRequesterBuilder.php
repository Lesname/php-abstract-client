<?php
declare(strict_types=1);

namespace LesAbstractClient\Requester\Builder;

use Override;
use LesAbstractClient\Authorizer\Builder\AuthorizerBuilder;
use LesAbstractClient\Requester\CurlRequester;
use LesAbstractClient\Requester\Requester;
use Psr\Container\ContainerInterface;

final class CurlRequesterBuilder implements RequesterBuilder
{
    /**
     * @param array<mixed> $config
     */
    #[Override]
    public function build(ContainerInterface $container, array $config): Requester
    {
        assert(is_string($config['baseUri']));

        if (isset($config['authorizer'])) {
            assert(is_array($config['authorizer']));

            assert(is_string($config['authorizer']['builder']));
            assert(is_subclass_of($config['authorizer']['builder'], AuthorizerBuilder::class));
            $builder = new $config['authorizer']['builder']();

            assert(is_array($config['authorizer']['config']));

            $authorizer = $builder->build($container, $config['authorizer']['config']);
        } else {
            $authorizer = null;
        }

        $build = isset($config['build']) && is_string($config['build'])
            ? $config['build']
            : null;

        return new CurlRequester($config['baseUri'], $authorizer, $build);
    }
}
