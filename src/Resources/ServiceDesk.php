<?php

declare(strict_types=1);

namespace Jira\Resources;

use Jira\Enums\Transporter\ContentType;
use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\ResourceUri;
use Jira\ValueObjects\Transporter\Payload;

final class ServiceDesk
{
    use Concerns\Transportable;

    /**
     * Creates new customer for the provided parameters.
     *
     * @see https://docs.atlassian.com/jira-servicedesk/REST/5.2.0/#servicedeskapi/customer-createCustomer
     *
     * @param  array{email: string, fullName: string}  $parameters
     * @return array{name: string, key: string, emailAddress: string, displayName: string, active: bool, timeZone: string, _links: array{jiraRest: string, avatarUrls: array<string, string>, self: string}}
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function createCustomer(array $parameters): array
    {
        $payload = new Payload(
            contentType: ContentType::JSON,
            method: Method::POST,
            uri: new ResourceUri('servicedeskapi/customer'),
            parameters: $parameters,
        );

        /** @var array{name: string, key: string, emailAddress: string, displayName: string, active: bool, timeZone: string, _links: array{jiraRest: string, avatarUrls: array<string, string>, self: string}} $result */
        $result = $this->transporter->request($payload);

        return $result;
    }
}
