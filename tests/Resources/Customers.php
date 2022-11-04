<?php

use Jira\Enums\Transporter\Method;

it('can create a customer', function () {
    $client = mockClient(
        method: Method::POST,
        uri: 'servicedeskapi/customer',
        response: createCustomer()
    );

    $result = $client->customers()
        ->create(body: [
            'fullName' => 'name',
            'email' => 'email',
        ]);

    expect($result)->toBe(createCustomer());
});
