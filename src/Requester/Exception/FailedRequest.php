<?php
declare(strict_types=1);

namespace LessAbstractClient\Requester\Exception;

use Exception;

final class FailedRequest extends Exception
{
    public function __construct(
        public readonly int $httpCode,
        public readonly string $response,
    ) {
        parent::__construct(
            "Request failed with http code {$httpCode}",
            $this->httpCode,
        );
    }
}
