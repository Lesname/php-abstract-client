<?php
declare(strict_types=1);

namespace LessAbstractClient\Authorizer;

use LessAbstractClient\Requester\Requester;
use RuntimeException;

final class LessIdentityAuthorizer implements Authorizer
{
    public function __construct(
        private readonly Requester $requester,
        private readonly string $id,
        private readonly string $secret,
    ) {}

    public function getAuthorization(): string
    {
        $response = $this
            ->requester
            ->post(
                'key.token.issue',
                [
                    'id' => $this->id,
                    'secret' => $this->secret,
                ],
            );

        $data = $response->getData();

        if (!is_array($data)) {
            throw new RuntimeException();
        }

        if (!isset($data['token'])) {
            throw new RuntimeException();
        }

        if (!is_string($data['token'])) {
            throw new RuntimeException();
        }

        return "Bearer {$data['token']}";
    }
}
