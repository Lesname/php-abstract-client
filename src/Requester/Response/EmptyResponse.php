<?php
declare(strict_types=1);

namespace LesAbstractClient\Requester\Response;

use Override;

/**
 * @psalm-immutable
 */
final class EmptyResponse implements Response
{
    #[Override]
    public function getCode(): int
    {
        return 204;
    }

    #[Override]
    public function getData(): mixed
    {
        return null;
    }
}
