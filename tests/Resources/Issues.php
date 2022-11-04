<?php

use Jira\Enums\Transporter\Method;

it('can create an issue', function () {
    $client = mockClient(
        method: Method::POST,
        uri: 'api/2/issue',
        response: createIssue()
    );

    $result = $client->issues()
        ->create(body: [
            'project' => [
                'id' => '10000',
            ],
        ]);

    expect($result)->toBe(createIssue());
});

it('can create bulk of issues', function () {
    $client = mockClient(
        method: Method::POST,
        uri: 'api/2/issue/bulk',
        response: createBulkIssues()
    );

    $result = $client->issues()
        ->bulk(body: [
            'issueUpdates' => [
                [
                    'fields' => [
                        'project' => [
                            'id' => '10000',
                        ],
                    ],
                ],
                [
                    'fields' => [
                        'project' => [
                            'id' => '10000',
                        ],
                    ],
                ],
            ],
        ]);

    expect($result)->toBe(createBulkIssues());
});

it('can get an issue', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/issue/KEY-1000',
        response: getIssue()
    );

    $result = $client->issues()->get(
        key: 'KEY-1000',
        query: [
            'fields' => '*all',
        ]
    );

    expect($result)->toBe(getIssue());
});

it('can delete an issue', function () {
    $client = mockClient(
        method: Method::DELETE,
        uri: 'api/2/issue/KEY-1000',
    );

    $result = $client->issues()->delete(key: 'KEY-1000');

    expect($result)->toBeNull();
});

it('can edit an issue', function () {
    $client = mockClient(
        method: Method::PUT,
        uri: 'api/2/issue/KEY-1000',
    );

    $result = $client->issues()->edit(
        key: 'KEY-1000',
        body: [
            'fields' => [
                'description' => 'edited!',
            ],
        ]
    );

    expect($result)->toBeNull();
});

it('can archive an issue', function () {
    $client = mockClient(
        method: Method::PUT,
        uri: 'api/2/issue/KEY-1000/archive',
    );

    $result = $client->issues()->archive(key: 'KEY-1000');

    expect($result)->toBeNull();
});

it('can assign an issue to a user', function () {
    $client = mockClient(
        method: Method::PUT,
        uri: 'api/2/issue/KEY-1000/assignee',
    );

    $result = $client->issues()->assign(
        key: 'KEY-1000',
        body: [
            'name' => 'user name',
        ]
    );

    expect($result)->toBeNull();
});

it('can get issue comments', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/issue/KEY-1000/comment',
        response: getIssueComments()
    );

    $result = $client->issues()->getComments(key: 'KEY-1000');

    expect($result)->toBe(getIssueComments());
});

it('can add comment to an issue', function () {
    $client = mockClient(
        method: Method::POST,
        uri: 'api/2/issue/KEY-1000/comment',
        response: addCommentToIssue()
    );

    $result = $client->issues()->addComment(
        key: 'KEY-1000',
        body: [
            'body' => 'Kind reminder!',
        ]
    );

    expect($result)->toBe(addCommentToIssue());
});

it('can update a comment', function () {
    $client = mockClient(
        method: Method::PUT,
        uri: 'api/2/issue/KEY-1000/comment/1',
        response: updateComment()
    );

    $result = $client->issues()->updateComment(
        key: 'KEY-1000',
        id: '1',
        body: [
            'body' => 'Kind reminder!',
        ]
    );

    expect($result)->toBe(updateComment());
});

it('can delete a comment', function () {
    $client = mockClient(
        method: Method::DELETE,
        uri: 'api/2/issue/KEY-1000/comment/1',
        response: updateComment()
    );

    $result = $client->issues()->deleteComment(key: 'KEY-1000', id: '1');

    expect($result)->toBeNull();
});

it('can get issue comment', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/issue/KEY-1000/comment/1',
        response: getComment()
    );

    $result = $client->issues()->getComment(key: 'KEY-1000', id: '1');

    expect($result)->toBe(getComment());
});

it('can get issue transitions', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/issue/KEY-1000/transitions',
        response: getIssueTransitions()
    );

    $result = $client->issues()->getTransitions(key: 'KEY-1000');

    expect($result)->toBe(getIssueTransitions());
});

it('can transition an issue', function () {
    $client = mockClient(
        method: Method::POST,
        uri: 'api/2/issue/KEY-1000/transitions',
    );

    $result = $client->issues()->doTransition(
        key: 'KEY-1000',
        body: [
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
        uri: 'api/2/issue/KEY-1000/attachments',
        response: attachFiles()
    );

    $result = $client->issues()->attach(
        key: 'KEY-1000',
        body: [
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

it('can search for an issues', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/search',
        response: searchIssues()
    );

    $result = $client->issues()->search();

    expect($result)->toBe(searchIssues());
});
