<?php
declare(strict_types=1);

namespace LessAbstractClient\Mezzio;

use LessAbstractClient\Authorizer;

final class ConfigProvider
{
    /**
     * @return array<string, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'aliases' => [
                    Authorizer\Authorizer::class => Authorizer\CacheAuthorizer::class,
                ],
                'invokables' => [
                ],
                'factories' => [
                    Authorizer\CacheAuthorizer::class => Authorizer\CacheAuthorizerFactory::class,
                    Authorizer\LessIdentityAuthorizer::class => Authorizer\LessIdentityAuthorizerFactory::class,
                ],
            ],
        ];
    }
}
