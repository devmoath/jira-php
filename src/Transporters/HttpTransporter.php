<?php

declare(strict_types=1);

namespace Jira\Transporters;

use Jira\Contracts\Transporter;
use Jira\Exceptions\ErrorException;
use Jira\Exceptions\TransporterException;
use Jira\Exceptions\UnserializableResponse;
use Jira\ValueObjects\Transporter\BaseUri;
use Jira\ValueObjects\Transporter\Headers;
use Jira\ValueObjects\Transporter\Payload;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

/**
 * @internal
 */
class HttpTransporter implements Transporter
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly BaseUri $baseUri,
        private readonly Headers $headers,
    ) {
        // ..
    }

    public function request(Payload $payload): ?array
    {
        $request = $payload->toRequest(baseUri: $this->baseUri, headers: $this->headers);

        try {
            $response = $this->client->sendRequest(request: $request);
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException(clientException: $clientException);
        }

        $contents = (string) $response->getBody();

        if (trim($contents) === '') {
            return null;
        }

        try {
            /** @var non-empty-array<array-key, mixed> $response */
            $response = json_decode(json: $contents, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse(jsonException: $jsonException);
        }

        $this->hasErrors($response);

        return $response;
    }

    public function requestContent(Payload $payload): string
    {
        $request = $payload->toRequest($this->baseUri, $this->headers);

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException($clientException);
        }

        $contents = (string) $response->getBody();

        try {
            /** @var non-empty-array<array-key, mixed> $response */
            $response = json_decode(json: $contents, associative: true, flags: JSON_THROW_ON_ERROR);

            $this->hasErrors($response);
        } catch (JsonException) {
            // ..
        }

        return $contents;
    }

    /**
     * @param  non-empty-array<array-key, mixed>  $response
     *
     * @throws \Jira\Exceptions\ErrorException
     */
    private function hasErrors(array $response): void
    {
        if (isset($response['errorMessage']) && $response['errorMessage'] !== '') {
            // @phpstan-ignore-next-line
            throw new ErrorException(message: $response['errorMessage']);
        }

        if (isset($response['errorMessages']) && $response['errorMessages'] !== []) {
            throw new ErrorException(message: $response['errorMessages'][0]);
        }

        if (isset($response['errors']) && $response['errors'] !== []) {
            throw new ErrorException(message: reset($response['errors']));
        }
    }
}
