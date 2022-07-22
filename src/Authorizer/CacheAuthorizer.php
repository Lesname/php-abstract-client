<?php
declare(strict_types=1);

namespace LessAbstractClient\Authorizer;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

final class CacheAuthorizer implements Authorizer
{
    public function __construct(
        private readonly Authorizer $proxy,
        private readonly CacheInterface $cache,
        private readonly string $key,
        private readonly int $expire,
    ) {}

    /**
     * @throws InvalidArgumentException
     *
     * @psalm-suppress MixedAssignment
     */
    public function getAuthorization(): string
    {
        $authorization = $this->cache->get($this->key);

        if (!is_string($authorization)) {
            $authorization = $this->proxy->getAuthorization();

            $this->cache->set($this->key, $authorization, $this->expire);
        }

        return $authorization;
    }
}
