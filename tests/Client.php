<?php

use Jira\Resources\Attachments;
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

it('has attachments', function () {
    $client = Jira::client('foo', 'bar', 'jira.example.com');

    expect($client->attachments())->toBeInstanceOf(Attachments::class);
});
