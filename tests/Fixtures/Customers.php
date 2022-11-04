<?php

function createCustomer(): array
{
    return [
        'name' => 'fred',
        'key' => 'fred',
        'emailAddress' => 'fred@example.com',
        'displayName' => 'Fred F. User',
        'active' => true,
        'timeZone' => 'Australia/Sydney',
        '_links' => [
            'jiraRest' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
            'avatarUrls' => [
                '48x48' => 'https://www.example.com/jira/secure/useravatar?size=large&ownerId=fred',
                '24x24' => 'https://www.example.com/jira/secure/useravatar?size=small&ownerId=fred',
                '16x16' => 'https://www.example.com/jira/secure/useravatar?size=xsmall&ownerId=fred',
                '32x32' => 'https://www.example.com/jira/secure/useravatar?size=medium&ownerId=fred',
            ],
            'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
        ],
    ];
}
