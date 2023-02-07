<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\Transporter\Payload;

class Attachments
{
    use Concerns\Transportable;

    /**
     * Retrieve the meta-data for an attachment.
     *
     * @see https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0/#api/2/attachment-getAttachment
     *
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function get(string $id): array
    {
        $payload = Payload::create(uri: "api/2/attachment/$id");

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
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
            uri: "api/2/attachment/$id",
            method: Method::DELETE,
        );

        $this->transporter->request(payload: $payload);
    }
}
