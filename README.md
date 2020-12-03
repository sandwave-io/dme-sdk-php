# DNS Made Easy PHP Client Library

This is an API client library for the [DNS Made Easy](https://www.dnsmadeeasy.com) API.

More information about the API may be found in the [official API documentation](https://api-docs.dnsmadeeasy.com/).

 - [Installation](#installation)
 - [Usage](#usage)
 - [Examples](#examples)
 - [License](#license)

## Installation

The easiest way to install and use this client library is using Composer. The following command will add the library to your application and install it from Packagist.

```bash
composer require tiggee/dnsmadeeasy-client
```

## Getting Started

You will need a DNS Made Easy account and API credentials. You can get an account at the [DNS Made Easy website](https://www.dnsmadeeasy.com). There is an API sandbox available, you can create a [new account here](https://sandbox.dnsmadeeasy.com/account/new).

If you are using Composer, you should be running Composer's autoload to load libraries:

```php
require_once 'vendor/_autoload.php';
```

With the libraries loaded, you just need to create the client and set the API key and secret key.

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
// Load the library and dependencies
require_once 'vendor/_autoload.php';

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

There's more examples further down of using the API client SDK.

## Configuration

There's additional configuration options you can use with the client as well as just specifying the sandbox.

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
// Include composer libraries
require_once 'vendor/_autoload.php';

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
$record->type = \DnsMadeEasy\Enums\RecordType::A();
$record->name = 'www';
$record->value = '192.0.2.1';
$record->save();

// Get a list of all domains
$domains = $client->domains->paginate();
foreach ($domains as $domain) {
    print_r(json_encode($domain, JSON_PRETTY_PRINT));
}
```

## License

The MIT License (MIT)

Copyright (c) 2020 DNS Made Easy, a subsidiary of Tiggee LLC.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.