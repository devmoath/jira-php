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

    /**
     * Creates new customer request in a service project.
     *
     * @see https://docs.atlassian.com/jira-servicedesk/REST/5.2.0/#servicedeskapi/request-createCustomerRequest
     *
     * @param  array{serviceDeskId: string, requestTypeId: string, requestFieldValues: array<string, mixed>, raiseOnBehalfOf: string, requestParticipants?: array<string>}  $parameters
     * @return array{_expands: array<string>, issueId: string, issueKey: string, requestTypeId: string, serviceDeskId: string, createdDate: array<string, mixed>, reporter: array<string, mixed>, requestFieldValues: array<int, array{fieldId: string, label: string, value: string}>, currentStatus: array{status: string, statusDate: array<string, mixed>}, _links: array<string, string>}
     *
     * @throws \Jira\Exceptions\ErrorException
     * @throws \Jira\Exceptions\TransporterException
     * @throws \Jira\Exceptions\UnserializableResponse
     * @throws \JsonException
     */
    public function createCustomerRequest(array $parameters): array
    {
        $payload = new Payload(
            contentType: ContentType::JSON,
            method: Method::POST,
            uri: new ResourceUri('servicedeskapi/request'),
            parameters: $parameters,
        );

        /** @var array{_expands: array<string>, issueId: string, issueKey: string, requestTypeId: string, serviceDeskId: string, createdDate: array<string, mixed>, reporter: array<string, mixed>, requestFieldValues: array<int, array{fieldId: string, label: string, value: string}>, currentStatus: array{status: string, statusDate: array<string, mixed>}, _links: array<string, string>} $result */
        $result = $this->transporter->request($payload);

        return $result;
    }
}
