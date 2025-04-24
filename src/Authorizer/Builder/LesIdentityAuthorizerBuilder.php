<?php
declare(strict_types=1);

namespace LesAbstractClient\Authorizer\Builder;

use Override;
use LesAbstractClient\Authorizer\Authorizer;
use LesAbstractClient\Authorizer\LesIdentityAuthorizer;
use LesAbstractClient\Requester\Builder\RequesterBuilder;
use Psr\Container\ContainerInterface;

final class LesIdentityAuthorizerBuilder implements AuthorizerBuilder
{
    #[Override]
    public function build(ContainerInterface $container, array $config): Authorizer
    {
        assert(is_array($config['requester']));
        assert(is_string($config['requester']['builder']));
        assert(is_subclass_of($config['requester']['builder'], RequesterBuilder::class));
        $builder = new $config['requester']['builder']();

        assert(is_array($config['requester']['config']));

        $requester = $builder->build($container, $config['requester']['config']);

        assert(is_string($config['idFile']));
        $id = file_get_contents($config['idFile']);
        assert(is_string($id));

        assert(is_string($config['secretFile']));
        $secret = file_get_contents($config['secretFile']);
        assert(is_string($secret));

        return new LesIdentityAuthorizer(
            $requester,
            $id,
            $secret,
        );
    }
}
