<?php

use Jira\Enums\Transporter\Method;

it('can get a project', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/project/10000',
        response: getProject()
    );

    $result = $client->issues()->get(
        id: '10000'
    );

    expect($result)->toBe(getProject());
});

it('can get all projects', function () {
    $client = mockClient(
        method: Method::GET,
        uri: 'api/2/project',
        response: getAllProjects()
    );

    $result = $client->projects()->getAll();

    expect($result)->toBe(getProject());
});
