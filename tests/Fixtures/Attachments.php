<?php

function retrieveAttachment(): array
{
    return [
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
    ];
}
