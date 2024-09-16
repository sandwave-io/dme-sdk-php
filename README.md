[![](https://user-images.githubusercontent.com/60096509/91668964-54ecd500-eb11-11ea-9c35-e8f0b20b277a.png)](https://sandwave.io)

# DNS Made Easy PHP Client Library

[![Codecov](https://codecov.io/gh/sandwave-io/dme-sdk-php/branch/main/graph/badge.svg?token=CDT60O8O03)](https://app.codecov.io/gh/sandwave-io/dme-sdk-php)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/sandwave-io/dme-sdk-php/test.yml?branch=main)](https://github.com/sandwave-io/dme-sdk-php/actions)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/sandwave-io/dns-made-easy)](https://packagist.org/packages/sandwave-io/dns-made-easy)
[![Packagist PHP Version Support](https://img.shields.io/packagist/v/sandwave-io/dns-made-easy)](https://packagist.org/packages/sandwave-io/dns-made-easy)
[![Packagist Downloads](https://img.shields.io/packagist/dt/sandwave-io/dns-made-easy)](https://packagist.org/packages/sandwave-io/dns-made-easy)

This package is a fork from the original <a href="https://github.com/DNSMadeEasy/dme-php-sdk">DNSMadeEasy/dme-php-sdk</a>.

This is an API client library for the [DNS Made Easy](https://www.dnsmadeeasy.com) API.

More information about the API may be found in the [official API documentation](https://api-docs.dnsmadeeasy.com/).

- [Installation](#installation)
- [Usage](#usage)
- [Examples](#examples)

## Installation

The easiest way to install and use this client library is using Composer. The following command will add the library to your application and install it from Packagist.

```bash
composer require sandwave-io/dns-made-easy
```

## Getting Started

You will need a DNS Made Easy account and API credentials. You can get an account at the [DNS Made Easy website](https://www.dnsmadeeasy.com). There is an API sandbox available, you can create a [new account here](https://sandbox.dnsmadeeasy.com/account/new).

With the package installed through composer, you just need to create the client and set the API key and secret key.

```php
$client = new \DnsMadeEasy\Client;
$client->setApiKey(API_KEY);
$client->setSecretKey(SECRET_KEY);
```

You may now use the client to query the API retrieve objects. Usage is documented in GitHub in the docs directory.

### Using the Sandbox

You can tell the client to use the sandbox API endpoint by using the `setEndpoint` method:

```php
$client->setEndpoint('https://api.sandbox.dnsmadeeasy.com/V2.0');
```

### Putting it all together

Putting this together, it's time for the API equivalent of Hello World. Let's get a list of your domains.

```php
<?php

// Create a new client and set our credentials
$client = new \DnsMadeEasy\Client;
$client->setApiKey("Your API Key");
$client->setSecretKey("Your Secret Key");

// Configure it to use the Sandbox
$client->setEndpoint('https://api.sandbox.dnsmadeeasy.com/V2.0');

// Create a new domain
$domain = $client->domains->create();
$domain->name = 'mydomain.example.com';
$domain->save();

// Print out our domain
echo json_encode($domain, JSON_PRETTY_PRINT);

// Now fetch a list of our domains
$domains = $client->domains->paginate();
foreach ($domains as $domain) {
    echo json_encode($domain, JSON_PRETTY_PRINT);
}
```

There are more examples further down of using the API client SDK.

## Configuration

There are additional configuration options you can use with the client as well as just specifying the sandbox.

### Logging

You can specify a logger that implements the [PSR-3 Logger](https://www.php-fig.org/psr/psr-3/) specification such as MonoLog. The client is a `LoggerAwareInterface` and the logger can be specified either in the constructor or via a method call.

```php
$client = new \DnsMadeEasy\Client(null, null, $myLogger);
```

```php
$client->setLogger($myLogger);
```

If no logger is specified then a null logger that does nothing will be used.

### Custom HTTP Client

If you need additional configuration for HTTP requests in your application, for example to specify a proxy server or if you want to use your own HTTP client matching the [PSR-18 HTTP Client](https://www.php-fig.org/psr/psr-18/) specification.

You can specify the client using either the constructor or via a method call.

```php
$client = new \DnsMadeEasy\Client($myClient);
```

```php
$client->setHttpClient($myClient);
```

## Examples

Full documentation of the library methods are in the docs folder.

### Managers

Managers are used for managing your access to resources on the API, including creating new resources and fetching existing ones from the API. These can be accessed as properties on the client.

```php
// Fetch our manager
$domainsManager = $client->domains;
// Ask our manager for the domain
$domain = $domainsManager->get(1234);
```

Manages are also used to create new objects.

```php
// Create a new domain
$domain = $client->domains->create();
$domain->name = 'example.com';

// Save the domain
$domain->save();
```

The domain is not saved on the API until you call `$domain->save()`.

Multiple objects can be fetched using the `paginate()` method on the manager. You can specify the page number and the number of items per page.

```php
// Return the 4th page of results with the default page size
$client->domains->paginate(4);

// Return the first page of 50 results
$client->domains->paginate(1, 50);
```

### Models

The models themselves follow an Active Record pattern. Properties can be updated and `save()` called on the model to update the API.

```php
// Fetch an existing domain with the ID 1234
$domain = $client->domains->get(1234);
// Update the gtdEnabled property
$domain->gtdEnabled = true;
// Save the domain object on the API
$domain->save();
```

You can delete an object by calling `delete()` on it:

```php
$domain = $client->domains->get(1234);
$domain->delete();
```

### Creating a domain and records

This example creates a new domain and adds records to it.

```php
// Create the client
$client = new \DnsMadeEasy\Client;
$client->setApiKey(API_KEY);
$client->setSecretKey(SECRET_KEY);

// Create the domain
$domain = $client->domains->create();
$domain->name = 'example.com';
$domain->save();

// Create a record on the domain
$record = $domain->records->create();
$record->type = \DnsMadeEasy\Enums\RecordType::A;
$record->name = 'www';
$record->value = '192.0.2.1';
$record->save();

// Get a list of all domains
$domains = $client->domains->paginate();
foreach ($domains as $domain) {
    print_r(json_encode($domain, JSON_PRETTY_PRINT));
}
```

## Contributing

When contributing to this project, you can run the following quality checks:

```bash
$ vendor/bin/phpstan
```

```bash
$ vendor/bin/phpunit
```

```bash
$ vendor/bin/php-cs-fixer fix
```

