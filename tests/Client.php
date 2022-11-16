<?php

use Jira\Resources\Attachments;
use Jira\Resources\Customers;
use Jira\Resources\Groups;
use Jira\Resources\Issues;
use Jira\Resources\Requests;
use Jira\Resources\Users;

it('has resources', function (string $function, string $class) {
    $client = Jira::client(username: 'foo', password: 'bar', host: 'jira.example.com');

    expect(call_user_func([$client, $function]))->toBeInstanceOf($class);
})->with(function () {
    yield ['attachments', Attachments::class];
    yield ['customers', Customers::class];
    yield ['groups', Groups::class];
    yield ['issues', Issues::class];
    yield ['requests', Requests::class];
    yield ['users', Users::class];
});
