<?php

declare(strict_types=1);

namespace Jira\ValueObjects\Transporter;

use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;

/**
 * @internal
 */
class Payload
{
    /**
     * @param  array<array-key, mixed>  $body
     * @param  array<array-key, mixed>  $query
     */
    private function __construct(
        private readonly string $uri,
        private readonly Method $method = Method::GET,
        private readonly ContentType $contentType = ContentType::JSON,
        private readonly array $body = [],
        private readonly array $query = []
    ) {
        // ..
    }

    /**
     * @param  array<array-key, mixed>  $body
     * @param  array<array-key, mixed>  $query
     */
    public static function create(
        string $uri,
        Method $method = Method::GET,
        ContentType $contentType = ContentType::JSON,
        array $body = [],
        array $query = []
    ): self {
        return new self(
            uri: $uri,
            method: $method,
            contentType: $contentType,
            body: $body,
            query: $query,
        );
    }

    /**
     * @throws \JsonException
     */
    public function toRequest(BaseUri $baseUri, Headers $headers): Psr7Request
    {
        $body = $this->getBody();

        $query = $this->query !== [] ? '?'.http_build_query(data: $this->query) : '';

        $headers = $headers->withContentType(
            contentType: $this->contentType,
            suffix: $body instanceof MultipartStream ? "; boundary={$body->getBoundary()}" : ''
        );

        return new Psr7Request(
            method: $this->method->value,
            uri: filter_var(value: $this->uri, filter: FILTER_VALIDATE_URL) !== false ? $this->uri.$query : $baseUri.$this->uri.$query,
            headers: $headers->toArray(),
            body: $body,
        );
    }

    private function getBody(): MultipartStream|string|null
    {
        if ($this->body === []) {
            return null;
        }

        if ($this->contentType === ContentType::MULTIPART) {
            return new MultipartStream(elements: $this->body);
        }

        return json_encode(value: $this->body, flags: JSON_THROW_ON_ERROR);
    }
}
