<?php

use Jira\Enums\Transporter\Method;

it('can update an user', function () {
    $client = mockClient(
        method: Method::PUT,
        uri: 'api/2/user',
        response: updateUser()
    );

    $result = $client->users()
        ->update(body: [
            'name' => 'eddie',
            'emailAddress' => 'eddie@atlassian.com',
            'displayName' => 'Eddie of Atlassian',
        ]);

    expect($result)->toBe(updateUser());
});

it('can create an user', function () {
    $client = mockClient(
        method: Method::POST,
        uri: 'api/2/user',
        response: createUser()
    );

    $result = $client->users()
        ->create(
            body: [
                'name' => 'eddie',
                'password' => 'abracadabra',
                'emailAddress' => 'eddie@atlassian.com',
                'displayName' => 'Eddie of Atlassian',
                'applicationKeys' => [
                    'jira-core',
                ],
            ]
        );

    expect($result)->toBe(createUser());
});

it('can remove an user', function () {
    $client = mockClient(
        method: Method::DELETE,
        uri: 'api/2/user',
    );

    $result = $client->users()
        ->remove(query: [
            'username' => 'eddie',
        ]);

    expect($result)->toBeNull();
});

it('can get an user', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/user',
        response: getUser()
    );

    $result = $client->users()
        ->get(query: [
            'username' => 'eddie',
        ]);

    expect($result)->toBe(getUser());
});
