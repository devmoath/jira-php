<?php

use Jira\Enums\Transporter\Method;

it('can create a group', function () {
    $client = mockClient(
        method: Method::POST,
        uri: 'api/2/group',
        response: createGroup()
    );

    $result = $client->groups()
        ->create(body: [
            'name' => 'group name',
        ]);

    expect($result)->toBe(createGroup());
});

it('can remove a group', function () {
    $client = mockClient(
        method: Method::DELETE,
        uri: 'api/2/group',
    );

    $result = $client->groups()
        ->remove(query: [
            'groupname' => 'group name',
        ]);

    expect($result)->toBeNull();
});

it('can get a group users', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/group/member',
        response: getGroupUsers()
    );

    $result = $client->groups()
        ->getUsers(query: [
            'groupname' => 'group name',
        ]);

    expect($result)->toBe(getGroupUsers());
});

it('can add user to a group', function () {
    $client = mockClient(
        method: Method::POST,
        uri: 'api/2/group/user',
        response: addUserToGroup()
    );

    $result = $client->groups()
        ->addUser(
            body: [
                'name' => 'user name',
            ],
            query: [
                'groupname' => 'group name',
            ]
        );

    expect($result)->toBe(addUserToGroup());
});

it('can remove user from a group', function () {
    $client = mockClient(
        method: Method::DELETE,
        uri: 'api/2/group/user',
    );

    $result = $client->groups()
        ->removeUser(query: [
            'groupname' => 'group name',
            'username' => 'user name',
        ]);

    expect($result)->toBeNull();
});
