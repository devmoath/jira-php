<p align="center">
    <img src="https://raw.githubusercontent.com/devmoath/jira-php/master/art/example-transparent.png" alt="Jira PHP">
    <p align="center">
        <a href="https://github.com/devmoath/jira-php/actions"><img alt="GitHub Workflow Status (master)" src="https://img.shields.io/github/workflow/status/devmoath/jira-php/Tests/master"></a>
        <a href="https://packagist.org/packages/devmoath/jira-php"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/devmoath/jira-php"></a>
        <a href="https://packagist.org/packages/devmoath/jira-php"><img alt="Latest Version" src="https://img.shields.io/packagist/v/devmoath/jira-php"></a>
        <a href="https://packagist.org/packages/devmoath/jira-php"><img alt="License" src="https://img.shields.io/github/license/devmoath/jira-php"></a>
    </p>
</p>

------

**Jira PHP** is a supercharged PHP API client that allows you to interact with the [Jira API](https://docs.atlassian.com/software/jira/docs/api/REST/8.0.0) and the [Service Desk API](https://docs.atlassian.com/jira-servicedesk/REST/5.2.0/).

> This project is a work-in-progress. Code and documentation are currently under development and are subject to change.

## Get Started

> **Requires [PHP 8.1+](https://php.net/releases/)**

First, install `devmoath/jira-php` via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require devmoath/jira-php dev-master
```

Then, interact with Jira's API:

```php
$client = Jira::client('USERNAME', 'PASSWORD', 'jira.domain.com');

$result = $client->issues()->list();

echo $result['issues'][0]['key']; // KEY-1000
```

## Usage

### `Issues` Resource

#### `list`

Lists the currently available issues, and provides information about each one.

```php
$client->issues()->list(parameters: []); // [..., 'issues' => [...], ...]
```

#### `retrieve`

Returns information about a specific issue.

```php
$client->issues()->retrieve(key: 'KEY', parameters: []); // [..., 'fields' => [...], ...]
```

#### `create`

Creates new issue for the provided parameters.

```php
$client->issues()->create(
    parameters: [
        'fields' => [
            'project' => [
                'id' => '1', 
            ],
            /* ... */
        ],
    ]
); // [..., 'key' => 'KEY-1000', ...]
```

#### `edit`

Edit information about a specific issue.

```php
$client->issues()->edit(
    key: 'KEY', 
    parameters: [
        'fields' => [
            'summary' => 'test',
        ],
    ]
);
```

#### `transition`

Perform a transition on a specific issue.

```php
$client->issues()->transition(
    key: 'KEY',
    parameters: [
        'transition' => [
            'id' => 1,
        ],
    ]
);
```

#### `attach`

Attach a file to a specific issue.

```php
$client->issues()->attach(
    key: 'KEY',
    parameters: [
        [
            'name' => 'file',        
            'contents' => 'hi',        
            'filename' => 'hi.txt',        
        ],
        [
            'name' => 'file',        
            'contents' => 'hi again',        
            'filename' => 'hi_again.txt',        
        ],
    ]
); // [0 => ['id' => '1', ...], ...]
```

#### `comment`

Create a new comment to an issue.

```php
$client->issues()->comment(
    key: 'KEY',
    parameters: [
        'body' => 'Kind reminder!',
    ]
); // ['id' => '10000', ...]
```

### `ServiceDesk` Resource

#### `crtearCustomr`

Creates new customer for the provided parameters.

```php
$client->serviceDesk()->createCustomer(
    parameters: [
        'email' => 'email',
        'fullName' => 'name',
    ]
); // [..., 'emailAddress' => 'email', ...]
```

#### `createCustomerRequest`

Creates new customer request in a service project.

```php
$client->serviceDesk()->createCustomerRequest(
    parameters: [
        'serviceDeskId' => '1',
        /* ... */
    ]
); // [..., 'serviceDeskId' => '1', ...]
```

### `Attachments` Resource

#### `retrieve`

Retrieve the meta-data for an attachment.

```php
$client->attachments()->retrieve(id: '10000'); // [..., 'filename' => 'name.png', ...]
```

#### `remove`

Remove an attachment.

```php
$client->attachments()->remove(id: '10000');
```

---

Jira PHP is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
