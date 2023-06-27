<?php

function createGroup(): array
{
    return [
        'name' => 'jira-administrators',
        'self' => 'https://www.example.com/jira/rest/api/2/group?groupname=jira-administrators',
        'users' => [
            'size' => 1,
            'items' => [
                [
                    'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
                    'name' => 'fred',
                    'displayName' => 'Fred F. User',
                    'active' => false,
                ],
            ],
            'max-results' => 50,
            'start-index' => 0,
            'end-index' => 0,
        ],
        'expand' => 'users',
    ];
}

function getGroupUsers(): array
{
    return [
        'self' => 'https://www.example.com/jira/rest/api/2/group/member?groupname=jira-administrators&includeInactiveUsers=false&startAt=2&maxResults=2',
        'nextPage' => 'https://www.example.com/jira/rest/api/2/group/member?groupname=jira-administrators&includeInactiveUsers=false&startAt=4&maxResults=2',
        'maxResults' => 2,
        'startAt' => 3,
        'total' => 5,
        'isLast' => false,
        'values' => [
            [
                'self' => 'https://example/jira/rest/api/2/user?username=fred',
                'name' => 'Fred',
                'key' => 'fred',
                'emailAddress' => 'fred@atlassian.com',
                'avatarUrls' => [],
                'displayName' => 'Fred',
                'active' => true,
                'timeZone' => 'Australia/Sydney',
            ],
            [
                'self' => 'https://example/jira/rest/api/2/user?username=barney',
                'name' => 'Barney',
                'key' => 'barney',
                'emailAddress' => 'barney@atlassian.com',
                'avatarUrls' => [],
                'displayName' => 'Barney',
                'active' => false,
                'timeZone' => 'Australia/Sydney',
            ],
        ],
    ];
}

function addUserToGroup(): array
{
    return [
        'name' => 'example',
        'self' => 'url',
        'users' => [],
        'expand' => '',
    ];
}
