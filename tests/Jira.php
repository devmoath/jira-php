<?php

use Jira\Client;

it('may create a client', function () {
    $client = Jira::client('foo', 'bar', 'jira.example.com');

    expect($client)->toBeInstanceOf(Client::class);
});
