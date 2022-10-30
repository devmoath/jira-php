<?php

use Jira\Enums\Transporter\Method;
use Jira\ValueObjects\ResourceUri;

it('can create an issue', function () {
    $client = mockClient(
        method: Method::POST,
        uri: ResourceUri::create('api/2/issue'),
        response: createIssue()
    );

    $result = $client->issues()
        ->create(parameters: [
            'project' => [
                'id' => '10000',
            ],
        ]);

    expect($result)->toBe(createIssue());
});

it('can list issues', function () {
    $client = mockClient(
        method: Method::GET,
        uri: ResourceUri::create('api/2/search'),
        response: listIssues()
    );

    $result = $client->issues()->list();

    expect($result)->toBe(listIssues());
});

it('can retrieve an issue', function () {
    $client = mockClient(
        method: Method::GET,
        uri: ResourceUri::create('api/2/issue/KEY-1000'),
        response: retrieveIssue()
    );

    $result = $client->issues()->retrieve(key: 'KEY-1000');

    expect($result)->toBe(retrieveIssue());
});

it('can comment to an issue', function () {
    $client = mockClient(
        method: Method::POST,
        uri: ResourceUri::create('api/2/issue/KEY-1000/comment'),
        response: commentIssue()
    );

    $result = $client->issues()->comment(key: 'KEY-1000', parameters: [
        'body' => 'Kind reminder!',
    ]);

    expect($result)->toBe(commentIssue());
});

it('can edit an issue', function () {
    $client = mockClient(
        method: Method::PUT,
        uri: ResourceUri::create('api/2/issue/KEY-1000'),
        response: null
    );

    /** @noinspection PhpVoidFunctionResultUsedInspection */
    $result = $client->issues()->edit(
        key: 'KEY-1000',
        parameters: [
            'fields' => [
                'description' => 'edited!',
            ],
        ]
    );

    expect($result)->toBeNull();
});

it('can transition an issue', function () {
    $client = mockClient(
        method: Method::POST,
        uri: ResourceUri::create('api/2/issue/KEY-1000/transitions'),
        response: null
    );

    /** @noinspection PhpVoidFunctionResultUsedInspection */
    $result = $client->issues()->transition(
        key: 'KEY-1000',
        parameters: [
            'transition' => [
                'id' => 1000,
            ],
        ]
    );

    expect($result)->toBeNull();
});

it('can attach files to an issue', function () {
    $client = mockClient(
        method: Method::POST,
        uri: ResourceUri::create('api/2/issue/KEY-1000/attachments'),
        response: attachFiles()
    );

    $result = $client->issues()->attach(
        key: 'KEY-1000',
        parameters: [
            [
                'name' => 'file',
                'contents' => 'hi',
                'filename' => 'hi.txt',
            ],
            [
                'name' => 'file',
                'contents' => 'hi again',
                'filename' => 'hi_again.txt',
            ],
        ]
    );

    expect($result)->toBe(attachFiles());
});
