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
     **
     * @return array<array-key, mixed>
     *
     * @throws ErrorException|UnserializableResponse|TransporterException|JsonException
     */
    public function requestObject(Payload $payload): array;

    /**
     * Sends a content request to a server.
     *
     * @throws ErrorException|TransporterException|JsonException
     */
    public function requestContent(Payload $payload): string;
}
