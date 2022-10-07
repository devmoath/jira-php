<?php

declare(strict_types=1);

namespace Jira\Contracts;

use Jira\Exceptions\ErrorException;
use Jira\Exceptions\TransporterException;
use Jira\Exceptions\UnserializableResponse;
use Jira\ValueObjects\Transporter\Payload;
use JsonException;

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
     * @throws ErrorException|UnserializableResponse|TransporterException|JsonException
     */
    public function request(Payload $payload): ?array;
}
