<?php

use Jira\Resources\Issues;
use Jira\Resources\ServiceDesk;

it('has issues', function () {
    $client = Jira::client('foo', 'bar', 'jira.example.com');

    expect($client->issues())->toBeInstanceOf(Issues::class);
});

it('has service desk', function () {
    $client = Jira::client('foo', 'bar', 'jira.example.com');

    expect($client->serviceDesk())->toBeInstanceOf(ServiceDesk::class);
});
