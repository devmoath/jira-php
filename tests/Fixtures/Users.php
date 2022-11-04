<?php

function updateUser(): array
{
    return [
        'self' => 'https://www.example.com/jira/rest/api/2/user/charlie',
        'key' => 'charlie',
        'name' => 'charlie',
        'emailAddress' => 'charlie@atlassian.com',
        'displayName' => 'Charlie of Atlassian',
    ];
}
function createUser(): array
{
    return updateUser();
}

function getUser(): array
{
    return [
        'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
        'name' => 'fred',
        'emailAddress' => 'fred@example.com',
        'avatarUrls' => [
            '48x48' => 'https://www.example.com/jira/secure/useravatar?size=large&ownerId=fred',
            '24x24' => 'https://www.example.com/jira/secure/useravatar?size=small&ownerId=fred',
            '16x16' => 'https://www.example.com/jira/secure/useravatar?size=xsmall&ownerId=fred',
            '32x32' => 'https://www.example.com/jira/secure/useravatar?size=medium&ownerId=fred',
        ],
        'displayName' => 'Fred F. User',
        'active' => true,
        'timeZone' => 'Australia/Sydney',
        'groups' => [
            'size' => 3,
            'items' => [
                [
                    'name' => 'jira-user',
                    'self' => 'https://www.example.com/jira/rest/api/2/group?groupname=jira-user',
                ],
                [
                    'name' => 'jira-admin',
                    'self' => 'https://www.example.com/jira/rest/api/2/group?groupname=jira-admin',
                ],
                [
                    'name' => 'important',
                    'self' => 'https://www.example.com/jira/rest/api/2/group?groupname=important',
                ],
            ],
        ],
        'applicationRoles' => [
            'size' => 1,
            'items' => [],
        ],
        'expand' => 'groups,applicationRoles',
    ];
}
