<?php
declare(strict_types=1);

namespace LesAbstractClient\Requester;

use Override;
use CurlHandle;
use JsonException;
use RuntimeException;
use LesAbstractClient\Authorizer\Authorizer;
use LesAbstractClient\Requester\Response\Response;
use LesAbstractClient\Requester\Response\DataResponse;
use LesAbstractClient\Requester\Response\EmptyResponse;
use LesAbstractClient\Requester\Exception\FailedRequest;

final class CurlRequester implements Requester
{
    private readonly string $baseUri;

    public function __construct(
        string $baseUri,
        private readonly ?Authorizer $authorizer = null,
        private readonly ?string $build = null,
    ) {
        $this->baseUri = rtrim($baseUri, '/');
    }

    /**
     * @throws FailedRequest
     * @throws JsonException
     */
    #[Override]
    public function post(string $path, mixed $data): Response
    {
        $curlHandle = $this->createCurlHandle($path, $data);
        $responseData = curl_exec($curlHandle);

        if (!is_string($responseData)) {
            throw new RuntimeException();
        }

        $responseCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);

        if ((int)floor($responseCode / 100) !== 2) {
            throw new FailedRequest($responseCode, $responseData);
        }

        if ($responseCode === 204) {
            return new EmptyResponse();
        }

        return new DataResponse(
            $responseCode,
            json_decode(
                $responseData,
                true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }

    private function createCurlHandle(string $path, mixed $data): CurlHandle
    {
        $curlHandle = curl_init($this->baseUri . '/' . ltrim($path, '/'));

        if ($curlHandle === false) {
            throw new RuntimeException();
        }

        $headers = ['Accept: application/json'];

        if ($this->authorizer) {
            $headers[] = "Authorization: {$this->authorizer->getAuthorization()}";
        }

        if ($data !== null) {
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($data, JSON_THROW_ON_ERROR));
            $headers[] = 'Content-Type: application/json';
        }

        if ($this->build) {
            $headers[] = "x-headers: {$this->build}";
        }

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);

        return $curlHandle;
    }
}
