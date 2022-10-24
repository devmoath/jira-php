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

final class HttpTransporter implements Transporter
{
    /**
     * Creates a new Http Transporter instance.
     */
    public function __construct(
        private readonly ClientInterface $client,
        private readonly BaseUri $baseUri,
        private readonly Headers $headers,
    ) {
        // ..
    }

    /**
     * {@inheritDoc}
     */
    public function request(Payload $payload): ?array
    {
        $request = $payload->toRequest(baseUri: $this->baseUri, headers: $this->headers);

        try {
            $response = $this->client->sendRequest(request: $request);
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException(exception: $clientException);
        }

        if ($response->getStatusCode() === 204 && empty($response->getBody()->getContents())) {
            return null;
        }

        $contents = $response->getBody()->getContents();

        try {
            /** @var array{errorMessage?: string, errorMessages?: array<string>, errors?: array<string, string>} $response */
            $response = json_decode(json: $contents, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse(exception: $jsonException);
        }

        if (! empty($response['errorMessage'])) {
            throw new ErrorException(message: $response['errorMessage']);
        }

        if (! empty($response['errorMessages'])) {
            throw new ErrorException(message: $response['errorMessages'][0]);
        }

        if (! empty($response['errors'])) {
            throw new ErrorException(message: reset($response['errors'])[0]);
        }

        return $response;
    }
}
