<?php

declare(strict_types=1);

namespace Jira\ValueObjects\Transporter;

use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\ResourceUri;

/**
 * @internal
 */
final class Payload
{
    /**
     * Creates a new Request value object.
     *
     * @param  array<string, mixed>  $parameters
     */
    private function __construct(
        private readonly ContentType $contentType,
        private readonly Method $method,
        private readonly ResourceUri $uri,
        private readonly array $parameters = [],
    ) {
        // ..
    }

    /**
     * Creates a new Request value object.
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function create(ContentType $contentType, Method $method, ResourceUri $uri, array $parameters = []): self
    {
        return new self(
            contentType: $contentType,
            method: $method,
            uri: $uri,
            parameters: $parameters,
        );
    }

    /**
     * Creates a new Psr 7 Request instance.
     *
     * @throws \JsonException
     */
    public function toRequest(BaseUri $baseUri, Headers $headers): Psr7Request
    {
        $body = null;
        $query = null;

        if (in_array(needle: $this->method, haystack: [Method::POST, Method::PUT], strict: true)) {
            $body = $this->contentType === ContentType::MULTIPART
                ? new MultipartStream(elements: $this->parameters)
                : json_encode(value: $this->parameters, flags: JSON_THROW_ON_ERROR);
        } else {
            $query = '?'.http_build_query(data: $this->parameters);
        }

        $headers = $headers->withContentType(
            contentType: $this->contentType,
            suffix: $body instanceof MultipartStream ? "; boundary={$body->getBoundary()}" : ''
        );

        return new Psr7Request(
            method: $this->method->value,
            uri: $baseUri.$this->uri.$query,
            headers: $headers->toArray(),
            body: $body,
        );
    }
}
