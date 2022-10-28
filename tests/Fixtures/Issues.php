<?php

/**
 * @return array<string, string>
 */
function createIssue(): array
{
    return [
        'id' => '10000',
        'key' => 'TST-24',
        'self' => 'https://www.example.com/jira/rest/api/2/issue/10000',
    ];
}

/**
 * @return array<string, mixed>
 */
function retrieveIssue(): array
{
    return [
        'expand' => 'renderedFields,names,schema,operations,changelog,versionedRepresentations',
        'id' => '10002',
        'self' => 'https://www.example.com/jira/rest/api/2/issue/10002',
        'key' => 'EX-1',
        'fields' => [
            'attachment' => [
                [
                    'self' => 'https://www.example.com/jira/rest/api/2.0/attachments/10000',
                    'filename' => 'picture.jpg',
                    'author' => [
                        'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
                        'name' => 'fred',
                        'avatarUrls' => [
                            '48x48' => 'https://www.example.com/jira/secure/useravatar?size=large&ownerId=fred',
                            '24x24' => 'https://www.example.com/jira/secure/useravatar?size=small&ownerId=fred',
                            '16x16' => 'https://www.example.com/jira/secure/useravatar?size=xsmall&ownerId=fred',
                            '32x32' => 'https://www.example.com/jira/secure/useravatar?size=medium&ownerId=fred',
                        ],
                        'displayName' => 'Fred F. User',
                        'active' => false,
                    ],
                    'created' => '2019-02-09T10:08:20.478+0000',
                    'size' => 23123,
                    'mimeType' => 'image/jpeg',
                    'content' => 'https://www.example.com/jira/attachments/10000',
                    'thumbnail' => 'https://www.example.com/jira/secure/thumbnail/10000',
                ],
            ],
            'sub-tasks' => [
                [
                    'id' => '10000',
                    'type' => [
                        'id' => '10000',
                        'name' => '',
                        'inward' => 'Parent',
                        'outward' => 'Sub-task',
                    ],
                    'outwardIssue' => [
                        'id' => '10003',
                        'key' => 'EX-2',
                        'self' => 'https://www.example.com/jira/rest/api/2/issue/EX-2',
                        'fields' => [
                            'status' => [
                                'iconUrl' => 'https://www.example.com/jira//images/icons/statuses/open.png',
                                'name' => 'Open',
                            ],
                        ],
                    ],
                ],
            ],
            'description' => 'example bug report',
            'project' => [
                'self' => 'https://www.example.com/jira/rest/api/2/project/EX',
                'id' => '10000',
                'key' => 'EX',
                'name' => 'Example',
                'avatarUrls' => [
                    '48x48' => 'https://www.example.com/jira/secure/projectavatar?size=large&pid=10000',
                    '24x24' => 'https://www.example.com/jira/secure/projectavatar?size=small&pid=10000',
                    '16x16' => 'https://www.example.com/jira/secure/projectavatar?size=xsmall&pid=10000',
                    '32x32' => 'https://www.example.com/jira/secure/projectavatar?size=medium&pid=10000',
                ],
                'projectCategory' => [
                    'self' => 'https://www.example.com/jira/rest/api/2/projectCategory/10000',
                    'id' => '10000',
                    'name' => 'FIRST',
                    'description' => 'First Project Category',
                ],
            ],
            'comment' => [
                [
                    'self' => 'https://www.example.com/jira/rest/api/2/issue/10010/comment/10000',
                    'id' => '10000',
                    'author' => [
                        'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
                        'name' => 'fred',
                        'displayName' => 'Fred F. User',
                        'active' => false,
                    ],
                    'body' => 'Lorem ipsum dolor sit amet.',
                    'updateAuthor' => [
                        'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
                        'name' => 'fred',
                        'displayName' => 'Fred F. User',
                        'active' => false,
                    ],
                    'created' => '2019-02-09T10:08:20.180+0000',
                    'updated' => '2019-02-09T10:08:20.181+0000',
                    'visibility' => [
                        'type' => 'role',
                        'value' => 'Administrators',
                    ],
                ],
            ],
        ],
    ];
}

/**
 * @return array<string, mixed>
 */
function listIssues(): array
{
    return [
        'expand' => 'names,schema',
        'startAt' => 0,
        'maxResults' => 50,
        'total' => 1,
        'issues' => [
            [
                'expand' => '',
                'id' => '10001',
                'self' => 'https://www.example.com/jira/rest/api/2/issue/10001',
                'key' => 'HSP-1',
            ],
        ],
    ];
}

/**
 * @return array<int, array<string, mixed>>
 */
function attachFiles(): array
{
    return [
        [
            'self' => 'https://www.example.com/jira/rest/api/2.0/attachments/10000',
            'filename' => 'picture.jpg',
            'author' => [
                'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
                'name' => 'fred',
                'avatarUrls' => [
                    '48x48' => 'https://www.example.com/jira/secure/useravatar?size=large&ownerId=fred',
                    '24x24' => 'https://www.example.com/jira/secure/useravatar?size=small&ownerId=fred',
                    '16x16' => 'https://www.example.com/jira/secure/useravatar?size=xsmall&ownerId=fred',
                    '32x32' => 'https://www.example.com/jira/secure/useravatar?size=medium&ownerId=fred',
                ],
                'displayName' => 'Fred F. User',
                'active' => false,
            ],
            'created' => '2019-02-09T10:08:20.478+0000',
            'size' => 23123,
            'mimeType' => 'image/jpeg',
            'content' => 'https://www.example.com/jira/attachments/10000',
            'thumbnail' => 'https://www.example.com/jira/secure/thumbnail/10000',
        ],
        [
            'self' => 'https://www.example.com/jira/rest/api/2.0/attachments/10001',
            'filename' => 'dbeuglog.txt',
            'author' => [
                'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
                'name' => 'fred',
                'avatarUrls' => [
                    '48x48' => 'https://www.example.com/jira/secure/useravatar?size=large&ownerId=fred',
                    '24x24' => 'https://www.example.com/jira/secure/useravatar?size=small&ownerId=fred',
                    '16x16' => 'https://www.example.com/jira/secure/useravatar?size=xsmall&ownerId=fred',
                    '32x32' => 'https://www.example.com/jira/secure/useravatar?size=medium&ownerId=fred',
                ],
                'displayName' => 'Fred F. User',
                'active' => false,
            ],
            'created' => '2019-02-09T10:08:20.478+0000',
            'size' => 2460,
            'mimeType' => 'text/plain',
            'content' => 'https://www.example.com/jira/attachments/10001',
            'thumbnail' => 'https://www.example.com/jira/secure/thumbnail/10002',
        ],
    ];
}
