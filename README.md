<p align="center">
    <img src="art/example-3-transparent.png" width="800" alt="Jira PHP">
</p>

<p align="center">
    <a href="https://github.com/devmoath/jira-php/actions"><img alt="GitHub Workflow Status (master)" src="https://img.shields.io/github/workflow/status/devmoath/jira-php/Tests/master"></a>
    <a href="https://packagist.org/packages/devmoath/jira-php"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/devmoath/jira-php"></a>
    <a href="https://packagist.org/packages/devmoath/jira-php"><img alt="Latest Version" src="https://img.shields.io/packagist/v/devmoath/jira-php"></a>
    <a href="https://packagist.org/packages/devmoath/jira-php"><img alt="License" src="https://img.shields.io/github/license/devmoath/jira-php"></a>
</p>

---

**Jira PHP** is a supercharged PHP API client that allows you to interact with the [Jira API](https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0) and the [Service Desk API](https://docs.atlassian.com/jira-servicedesk/REST/5.2.0/).

> This project is a work-in-progress. Code and documentation are currently under development and are subject to change.

## Get Started

> **Requires [PHP 8.1+](https://php.net/releases/)**

First, install `devmoath/jira-php` via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require devmoath/jira-php dev-master
```

Then, interact with Jira's APIs:

```php
$client = Jira::client(username: 'USERNAME', password: 'PASSWORD', host: 'jira.domain.com');

$result = $client->issues()->search();

echo $result['issues'][0]['key']; // KEY-1000
```

## Usage

### `Attachments` Resource

#### `get` function

Retrieve the meta-data for an attachment.

```php
$client->attachments()->get(id: '1000');
```

<details>
<summary>response example</summary>

```php
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
];
```

</details>

---

#### `remove` function

Remove an attachment.

```php
$client->attachments()->remove(id: '1000');
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

### `Customers` Resource

#### `create` function

Create a customer that is not associated with a service project.

```php
$client->customers()->create(
    body: [
        'fullName' => 'name',
        'email' => 'name@example.com',
    ],
);
```

<details>
<summary>response example</summary>

```php
[
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
```

</details>

---

### `Groups` Resource

#### `create` function

Create a group by given group parameter.

```php
$client->groups()->create(
    body: [
        'name' => 'group name',
    ],
);
```

<details>
<summary>response example</summary>

```php
[
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
```

</details>

---

#### `remove` function

Delete a group by given group parameter.

```php
$client->groups()->remove(
    query: [
        'name' => 'group name',
    ],
);
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

#### `getUsers` function

Return a paginated list of users who are members of the specified group and its subgroups.

```php
$client->groups()->getUsers(
    query: [
        'groupname' => 'group name',
    ],
);
```

<details>
<summary>response example</summary>

```php
[
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
```

</details>

---

#### `addUser` function

Add given user to a group.

```php
$client->groups()->addUser(
    query: [
        'groupname' => 'group name',
    ],
    body: [
        'name' => 'user name',
    ],
);
```

<details>
<summary>response example</summary>

```php
[
    'name' => 'example',
    'self' => 'url',
    'users' => [],
    'expand' => '',
];
```

</details>

---

#### `removeUser` function

Remove given user from a group.

```php
$client->groups()->removeUser(
    query: [
        'groupname' => 'group name',
        'username' => 'user name',
    ],
);
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

### `Issues` Resource

#### `create` function

Create an issue or a sub-task from a JSON representation.

```php
$client
    ->issues()
    ->create(body: [...]);
```

<details>
<summary>response example</summary>

```php
[
    'id' => '10000',
    'key' => 'TST-24',
    'self' => 'https://www.example.com/jira/rest/api/2/issue/10000',
];
```

</details>

---

#### `bulk` function

Create issues or sub-tasks from a JSON representation.

```php
$client
    ->issues()
    ->bulk(body: [
        [...],
        [...],
        [...]
    ]);
```

<details>
<summary>response example</summary>

```php
[
    'issues' => [
        [
            'id' => '10000',
            'key' => 'TST-24',
            'self' => 'https://www.example.com/jira/rest/api/2/issue/10000',
        ],
        [
            'id' => '10001',
            'key' => 'TST-25',
            'self' => 'https://www.example.com/jira/rest/api/2/issue/10001',
        ],
    ],
    'errors' => [],
];
```

</details>

---

#### `get` function

Return a full representation of the issue for the given issue key.

```php
$client->issues()->get(id: 'KEY-1000', query: [...]);
```

<details>
<summary>response example</summary>

```php
[
    'expand' => 'renderedFields,names,schema,operations,editmeta,changelog,versionedRepresentations',
    'id' => '10002',
    'self' => 'https://www.example.com/jira/rest/api/2/issue/10002',
    'key' => 'EX-1',
    'fields' => [
        'watcher' => [
            'self' => 'https://www.example.com/jira/rest/api/2/issue/EX-1/watchers',
            'isWatching' => false,
            'watchCount' => 1,
            'watchers' => [
                [
                    'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
                    'name' => 'fred',
                    'displayName' => 'Fred F. User',
                    'active' => false,
                ],
            ],
        ],
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
                            'iconUrl' => 'https://www.example.com/jira/images/icons/statuses/open.png',
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
        'issuelinks' => [
            [
                'id' => '10001',
                'type' => [
                    'id' => '10000',
                    'name' => 'Dependent',
                    'inward' => 'depends on',
                    'outward' => 'is depended by',
                ],
                'outwardIssue' => [
                    'id' => '10004L',
                    'key' => 'PRJ-2',
                    'self' => 'https://www.example.com/jira/rest/api/2/issue/PRJ-2',
                    'fields' => [
                        'status' => [
                            'iconUrl' => 'https://www.example.com/jira//images/icons/statuses/open.png',
                            'name' => 'Open',
                        ],
                    ],
                ],
            ],
            [
                'id' => '10002',
                'type' => [
                    'id' => '10000',
                    'name' => 'Dependent',
                    'inward' => 'depends on',
                    'outward' => 'is depended by',
                ],
                'inwardIssue' => [
                    'id' => '10004',
                    'key' => 'PRJ-3',
                    'self' => 'https://www.example.com/jira/rest/api/2/issue/PRJ-3',
                    'fields' => [
                        'status' => [
                            'iconUrl' => 'https://www.example.com/jira//images/icons/statuses/open.png',
                            'name' => 'Open',
                        ],
                    ],
                ],
            ],
        ],
        'worklog' => [
            [
                'self' => 'https://www.example.com/jira/rest/api/2/issue/10010/worklog/10000',
                'author' => [
                    'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
                    'name' => 'fred',
                    'displayName' => 'Fred F. User',
                    'active' => false,
                ],
                'updateAuthor' => [
                    'self' => 'https://www.example.com/jira/rest/api/2/user?username=fred',
                    'name' => 'fred',
                    'displayName' => 'Fred F. User',
                    'active' => false,
                ],
                'comment' => 'I did some work here.',
                'updated' => '2019-02-09T10:08:20.486+0000',
                'visibility' => [
                    'type' => 'group',
                    'value' => 'jira-developers',
                ],
                'started' => '2019-02-09T10:08:20.486+0000',
                'timeSpent' => '3h 20m',
                'timeSpentSeconds' => 12000,
                'id' => '100028',
                'issueId' => '10002',
            ],
        ],
        'updated' => 1,
        'timetracking' => [
            'originalEstimate' => '10m',
            'remainingEstimate' => '3m',
            'timeSpent' => '6m',
            'originalEstimateSeconds' => 600,
            'remainingEstimateSeconds' => 200,
            'timeSpentSeconds' => 400,
        ],
    ],
    'names' => [
        'watcher' => 'watcher',
        'attachment' => 'attachment',
        'sub-tasks' => 'sub-tasks',
        'description' => 'description',
        'project' => 'project',
        'comment' => 'comment',
        'issuelinks' => 'issuelinks',
        'worklog' => 'worklog',
        'updated' => 'updated',
        'timetracking' => 'timetracking',
    ],
    'schema' => [],
];
```

</details>

---

#### `delete` function

Delete an issue.

```php
$client->issues()->delete(id: 'KEY-1000', query: [...]);
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

#### `edit` function

Edit an issue from a JSON representation.

```php
$client->issues()->edit(id: 'KEY-1000', body: [...], query: [...]);
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

#### `archive` function

Archive an issue.

```php
$client->issues()->archive(id: 'KEY-1000');
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

#### `assign` function

Assign an issue to a user.

```php
$client->issues()->assign(id: 'KEY-1000', body: [...]);
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

#### `getComments` function

Return all comments for an issue.

```php
$client->issues()->getComments(id: 'KEY-1000', query: [...]);
```

<details>
<summary>response example</summary>

```php
[
    'startAt' => 0,
    'maxResults' => 1,
    'total' => 1,
    'comments' => [
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
];
```

</details>

---

#### `addComment` function

Add new comment to an issue.

```php
$client->issues()->addComment(id: 'KEY-1000', body: [...], query: [...]);
```

<details>
<summary>response example</summary>

```php
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
];
```

</details>

---

#### `updateComment` function

Update existing comment using its JSON representation.

```php
$client->issues()->updateComment(id: 'KEY-1000', commentId: '10000', body: [...], query: [...]);
```

<details>
<summary>response example</summary>

```php
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
];
```

</details>

---

#### `deleteComment` function

Delete an existing comment.

```php
$client->issues()->deleteComment(id: 'KEY-1000', commentId: '10000', query: [...]);
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

#### `getComment` function

Return a single comment.

```php
$client->issues()->getComment(id: 'KEY-1000', commentId: '10000', query: [...]);
```

<details>
<summary>response example</summary>

```php
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
];
```

</details>

---

#### `getTransitions` function

Get a list of the transitions possible for this issue by the current user, along with fields that are required and their types.

```php
$client->issues()->getTransitions(id: 'KEY-1000', query: [...]);
```

<details>
<summary>response example</summary>

```php
[
    'expand' => 'transitions',
    'transitions' => [
        [
            'id' => '2',
            'name' => 'Close Issue',
            'to' => [
                'self' => 'https://localhost:8090/jira/rest/api/2.0/status/10000',
                'description' => 'The issue is currently being worked on.',
                'iconUrl' => 'https://localhost:8090/jira/images/icons/progress.gif',
                'name' => 'In Progress',
                'id' => '10000',
                'statusCategory' => [
                    'self' => 'https://localhost:8090/jira/rest/api/2.0/statuscategory/1',
                    'id' => 1,
                    'key' => 'in-flight',
                    'colorName' => 'yellow',
                    'name' => 'In Progress',
                ],
            ],
            'fields' => [
                'summary' => [
                    'required' => false,
                    'schema' => [
                        'type' => 'array',
                        'items' => 'option',
                        'custom' => 'com.atlassian.jira.plugin.system.customfieldtypes:multiselect',
                        'customId' => 10001,
                    ],
                    'name' => 'My Multi Select',
                    'hasDefaultValue' => false,
                    'operations' => ['set', 'add'],
                    'allowedValues' => ['red', 'blue'],
                ],
            ],
        ],
        [
            'id' => '711',
            'name' => 'QA Review',
            'to' => [
                'self' => 'https://localhost:8090/jira/rest/api/2.0/status/5',
                'description' => 'The issue is closed.',
                'iconUrl' => 'https://localhost:8090/jira/images/icons/closed.gif',
                'name' => 'Closed',
                'id' => '5',
                'statusCategory' => [
                    'self' => 'https://localhost:8090/jira/rest/api/2.0/statuscategory/9',
                    'id' => 9,
                    'key' => 'completed',
                    'colorName' => 'green',
                ],
            ],
            'fields' => [
                'summary' => [
                    'required' => false,
                    'schema' => [
                        'type' => 'array',
                        'items' => 'option',
                        'custom' => 'com.atlassian.jira.plugin.system.customfieldtypes:multiselect',
                        'customId' => 10001,
                    ],
                    'name' => 'My Multi Select',
                    'hasDefaultValue' => false,
                    'operations' => ['set', 'add'],
                    'allowedValues' => ['red', 'blue'],
                ],
                'colour' => [
                    'required' => false,
                    'schema' => [
                        'type' => 'array',
                        'items' => 'option',
                        'custom' => 'com.atlassian.jira.plugin.system.customfieldtypes:multiselect',
                        'customId' => 10001,
                    ],
                    'name' => 'My Multi Select',
                    'hasDefaultValue' => false,
                    'operations' => ['set', 'add'],
                    'allowedValues' => ['red', 'blue'],
                ],
            ],
        ],
    ],
];
```

</details>

---

#### `doTransition` function

Perform a transition on an issue.

```php
$client->issues()->doTransition(id: 'KEY-1000', body: [...], query: [...]);
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

#### `attach` function

Add one or more attachments to an issue.

```php
$client->issues()->attach(id: 'KEY-1000', body: [...]);
```

<details>
<summary>response example</summary>

```php
[
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
```

</details>

---

#### `search` function

Search for issues using JQL.

```php
$client->issues()->search(query: [...]);
```

<details>
<summary>response example</summary>

```php
[
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
```

</details>

---

### `Requests` Resource

#### `create` function

Create a customer request in a service project.

```php
$client->requests()->create(body: [...]);
```

<details>
<summary>response example</summary>

```php
[
    '_expands' => ['participant', 'status', 'sla', 'requestType', 'serviceDesk'],
    'issueId' => '107001',
    'issueKey' => 'HELPDESK-1',
    'requestTypeId' => '25',
    'serviceDeskId' => '10',
    'createdDate' => [
        'iso8601' => '2015-10-08T14:42:00+0700',
        'jira' => '2015-10-08T14:42:00.000+0700',
        'friendly' => 'Monday 14:42 PM',
        'epochMillis' => 1444290120000,
    ],
    'reporter' => [
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
    ],
    'requestFieldValues' => [
        [
            'fieldId' => 'summary',
            'label' => 'What do you need?',
            'value' => 'Request JSD help via REST',
        ],
        [
            'fieldId' => 'description',
            'label' => 'Why do you need this?',
            'value' => 'I need a new mouse for my Mac',
        ],
    ],
    'currentStatus' => [
        'status' => 'Waiting for Support',
        'statusDate' => [
            'iso8601' => '2015-10-08T14:01:00+0700',
            'jira' => '2015-10-08T14:01:00.000+0700',
            'friendly' => 'Today 14:01 PM',
            'epochMillis' => 1444287660000,
        ],
    ],
    '_links' => [
        'jiraRest' => 'https://host:port/context/rest/api/2/issue/107001',
        'web' => 'https://host:port/context/servicedesk/customer/portal/10/HELPDESK-1',
        'self' => 'https://host:port/context/rest/servicedeskapi/request/107001',
    ],
];
```

</details>

---

### `Users` Resource

#### `update` function

Modify user.

```php
$client->users()->update(body: [...]);
```

<details>
<summary>response example</summary>

```php
[
    'self' => 'https://www.example.com/jira/rest/api/2/user/charlie',
    'key' => 'charlie',
    'name' => 'charlie',
    'emailAddress' => 'charlie@atlassian.com',
    'displayName' => 'Charlie of Atlassian',
];
```

</details>

---

#### `create` function

Create user.

```php
$client->users()->create(body: [...]);
```

<details>
<summary>response example</summary>

```php
[
    'self' => 'https://www.example.com/jira/rest/api/2/user/charlie',
    'key' => 'charlie',
    'name' => 'charlie',
    'emailAddress' => 'charlie@atlassian.com',
    'displayName' => 'Charlie of Atlassian',
];
```

</details>

---

#### `remove` function

Remove user and its references (like project roles associations, watches, history).

```php
$client->users()->remove(query: [...]);
```

<details>
<summary>response example</summary>

```php
null
```

</details>

---

#### `get` function

Return a user.

```php
$client->users()->get(query: [...]);
```

<details>
<summary>response example</summary>

```php
[
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
```

</details>

---

Jira PHP is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
