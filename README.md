# Laravel ActiveCampaign (WIP)

[![Latest Stable Version](https://poser.pugx.org/label84/laravel-active-campaign/v/stable?style=flat-square)](https://packagist.org/packages/label84/laravel-active-campaign)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Quality Score](https://img.shields.io/scrutinizer/g/label84/laravel-active-campaign.svg?style=flat-square)](https://scrutinizer-ci.com/g/label84/laravel-active-campaign)
[![Total Downloads](https://img.shields.io/packagist/dt/label84/laravel-active-campaign.svg?style=flat-square)](https://packagist.org/packages/label84/laravel-active-campaign)

This package provides a simple interface to the ActiveCampaign API v3.

Currently the packages only supports the endpoints `Contacts`, `Custom Fields Values` and `Tags`. Feel free to PR the remaining endpoints.

- [Requirements](#requirements)
- [Laravel support](#laravel-support)
- [Installation](#installation)
- [Usage](#usage)
  - [Contacts](#contacts)
  - [Custom Field Values](#custom-field-values)
  - [Tags](#tags)
- [Tests](#tests)
- [License](#license)

## Requirements

- PHP 8.x
- Laravel 9.x

## Installation

### 1. Install the package via composer

```sh
composer require label84/laravel-active-campaign
```

### 2. Publish the config file

```sh
php artisan vendor:publish --provider="Label84\ActiveCampaign\ActiveCampaignServiceProvider" --tag="config"
```

### 3. Add the base URL and API key to your .env

```env
ACTIVE_CAMPAIGN_BASE_URL=
ACTIVE_CAMPAIGN_API_KEY=
```

## Usage

- [Active Campaign API Documentation](https://developers.activecampaign.com/reference)
- [Active Campaign Contact API Documentation](https://developers.activecampaign.com/reference/contact)

### Contacts

#### Retreive an existing contact by their id

```php
use Label84\ActiveCampaign\ActiveCampaign;

$contact = resolve(ActiveCampaign::class)->contacts()->get(1);
```

#### List all contact, search contacts, or filter contacts by query defined criteria

```php
use Label84\ActiveCampaign\ActiveCampaign;

$contacts = resolve(ActiveCampaign::class)->contacts()->list('email=info@example.com');
```

#### Create a contact and get the contact id

```php
use Label84\ActiveCampaign\ActiveCampaign;

$contactId = resolve(ActiveCampaign::class)->contacts()->create('info@example.com', [
    'firstName' => 'John',
    'lastName' => 'Doe',
    'phone' => '+3112345678',
]);
```

#### Update an existing contact

```php
use Label84\ActiveCampaign\ActiveCampaign;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignContact;

$contact = new ActiveCampaignContact(1, 'info@example.com', '+3112345678', 'John', 'Deer');

$contact = resolve(ActiveCampaign::class)->contacts()->update($contact);
```

#### Delete an existing contact by their id

```php
use Label84\ActiveCampaign\ActiveCampaign;

resolve(ActiveCampaign::class)->contacts()->delete(1);
```

#### Add a tag to contact
```php
use Label84\ActiveCampaign\ActiveCampaign;

resolve(ActiveCampaign::class)->contacts()->tag(id: 1, tag_id: 20);
```

#### Remove a tag from a contact
```php
use Label84\ActiveCampaign\ActiveCampaign;

resolve(ActiveCampaign::class)->contacts()->untag(contact_tag_id: 2340);
```

### Custom Field Values

#### Retreive an existing field value by their id

```php
use Label84\ActiveCampaign\ActiveCampaign;

$fieldValue = resolve(ActiveCampaign::class)->fieldValues()->get(50);
```

#### Create a field value and get the id

```php
use Label84\ActiveCampaign\ActiveCampaign;

$fieldValue = resolve(ActiveCampaign::class)->fieldValues()->create(1, 50, 'active');
```

#### Update an existing field value

```php
use Label84\ActiveCampaign\ActiveCampaign;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignFieldValue;

$fieldValue = new ActiveCampaignFieldValue(1, 50, 'inactive');

$fieldValue = resolve(ActiveCampaign::class)->fieldValues()->update($fieldValue);
```

#### Delete an existing field value by their id

```php
use Label84\ActiveCampaign\ActiveCampaign;

resolve(ActiveCampaign::class)->fieldValues()->delete(50);
```

### Tags

#### Retreive an existing tag by their id

```php
use Label84\ActiveCampaign\ActiveCampaign;

$tag = resolve(ActiveCampaign::class)->tags()->get(100);
```

#### List all tags filtered by name

```php
use Label84\ActiveCampaign\ActiveCampaign;

$tags = resolve(ActiveCampaign::class)->tags()->list('abc');
```

#### Create a tag and get the id

```php
use Label84\ActiveCampaign\ActiveCampaign;

$tag = resolve(ActiveCampaign::class)->tags()->create('test_tag', 'This is a new tag');
```

#### Update an existing tag

```php
use Label84\ActiveCampaign\ActiveCampaign;
use Label84\ActiveCampaign\DataObjects\ActiveCampaignTag;

$tag = new ActiveCampaignTag(100, 'test_tag', 'Another description');

$tag = resolve(ActiveCampaign::class)->tags()->update($tag);
```

#### Delete an existing tag by their id

```php
use Label84\ActiveCampaign\ActiveCampaign;

resolve(ActiveCampaign::class)->tags()->delete(100);
```

## Tests

```sh
./vendor/bin/phpstan analyse
```

## License

[MIT](https://opensource.org/licenses/MIT)
