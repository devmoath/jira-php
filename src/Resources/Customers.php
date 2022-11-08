<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\Transporter\Payload;

final class Customers
{
    use Concerns\Transportable;

    /**
     * Create a customer that is not associated with a service project.
     *
     * @see https://docs.atlassian.com/jira-servicedesk/REST/5.2.0/#servicedeskapi/customer-createCustomer
     *
     * @param  non-empty-array<array-key, mixed>  $body
     * @return non-empty-array<array-key, mixed>
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function create(array $body): array
    {
        $payload = Payload::create(
            uri: 'servicedeskapi/customer',
            method: Method::POST,
            body: $body,
        );

        // @phpstan-ignore-next-line
        return $this->transporter->request(payload: $payload);
    }
}
