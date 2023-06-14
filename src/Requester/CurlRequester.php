<?php
declare(strict_types=1);

namespace LessAbstractClient\Requester;

use CurlHandle;
use JsonException;
use RuntimeException;
use LessAbstractClient\Authorizer\Authorizer;
use LessAbstractClient\Requester\Response\Response;
use LessAbstractClient\Requester\Response\DataResponse;
use LessAbstractClient\Requester\Response\EmptyResponse;
use LessAbstractClient\Requester\Exception\FailedRequest;

final class CurlRequester implements Requester
{
    private readonly string $baseUri;

    public function __construct(
        string $baseUri,
        private readonly ?Authorizer $authorizer = null,
    ) {
        $this->baseUri = rtrim($baseUri, '/');
    }

    /**
     * @throws FailedRequest
     * @throws JsonException
     */
    public function post(string $path, mixed $data): Response
    {
        $curlHandle = $this->createCurlHandle($path, $data);
        $responseData = curl_exec($curlHandle);

        if (!is_string($responseData)) {
            throw new RuntimeException();
        }

        $responseCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        assert(is_int($responseCode));

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

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);

        return $curlHandle;
    }
}
