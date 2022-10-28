<?php

use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\ResourceUri;

it('can create a customer', function () {
    $client = mockClient(
        method: Method::POST,
        uri: ResourceUri::create('servicedeskapi/customer'),
        response: createCustomer()
    );

    $result = $client->serviceDesk()
        ->createCustomer(parameters: [
            'fullName' => 'name',
            'email' => 'email',
        ]);

    expect($result)->toBe(createCustomer());
});

it('can create a customer request', function () {
    $client = mockClient(
        method: Method::POST,
        uri: ResourceUri::create('servicedeskapi/request'),
        response: createCustomerRequest()
    );

    $result = $client->serviceDesk()
        ->createCustomerRequest(parameters: [
            'serviceDeskId' => 1,
        ]);

    expect($result)->toBe(createCustomerRequest());
});
