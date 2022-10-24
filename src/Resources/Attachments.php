<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\ResourceUri;
use Jira\ValueObjects\Transporter\Payload;

final class Attachments
{
    use Concerns\Transportable;

    /**
     * Retrieve the meta-data for an attachment.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/attachment-getAttachment
     *
     * @return array{self: string, filename: string, author: array<string, mixed>, created: string, size: int, mimeType: string, content: string, thumbnail: string}
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function retrieve(string $id): array
    {
        $payload = Payload::create(
            contentType: ContentType::JSON,
            method: Method::GET,
            uri: ResourceUri::create("api/2/attachment/$id"),
        );

        /** @var array{self: string, filename: string, author: array<string, mixed>, created: string, size: int, mimeType: string, content: string, thumbnail: string} $result */
        $result = $this->transporter->request(payload: $payload);

        return $result;
    }

    /**
     * Remove an attachment.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/attachment-removeAttachment
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function remove(string $id): void
    {
        $payload = Payload::create(
            contentType: ContentType::JSON,
            method: Method::DELETE,
            uri: ResourceUri::create("api/2/attachment/$id"),
        );

        $this->transporter->request(payload: $payload);
    }
}
