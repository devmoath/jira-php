<?php

declare(strict_types=1);

namespace Jira\Contracts;

use Jira\ValueObjects\Transporter\Payload;

/**
 * @internal
 */
interface Transporter
{
    /**
     * @return non-empty-array<array-key, mixed>|null
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function request(Payload $payload): ?array;

    /**
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \JsonException
     */
    public function requestContent(Payload $payload): string;
}
