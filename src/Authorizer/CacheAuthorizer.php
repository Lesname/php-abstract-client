<?php
declare(strict_types=1);

namespace LessAbstractClient\Authorizer;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

final class CacheAuthorizer implements Authorizer
{
    private const CACHE_KEY = 'client.authorizer';

    public function __construct(
        private readonly Authorizer $proxy,
        private readonly CacheInterface $cache,
        private readonly int $expire,
    ) {}

    /**
     * @throws InvalidArgumentException
     *
     * @psalm-suppress MixedAssignment
     */
    public function getAuthorization(): string
    {
        $authorization = $this->cache->get(self::CACHE_KEY);

        if (!is_string($authorization)) {
            $authorization = $this->proxy->getAuthorization();

            $this->cache->set(self::CACHE_KEY, $authorization, $this->expire);
        }

        return $authorization;
    }
}
