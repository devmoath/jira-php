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
     * Sends a request to a server.
     *
     * @return array<array-key, mixed>|null
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function request(Payload $payload): ?array;
}
