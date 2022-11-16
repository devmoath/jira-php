<?php

use Jira\Enums\Transporter\Method;

it('can create a customer request', function () {
    $client = mockClient(
        method: Method::POST,
        uri: 'servicedeskapi/request',
        response: createCustomerRequest()
    );

    $result = $client->requests()
        ->create(body: [
            'serviceDeskId' => 1,
        ]);

    expect($result)->toBe(createCustomerRequest());
});
