# Quickbooks OAuth2 with Laravel

Simple way to implement Quickbooks OAuth2 without using any providers.

## Requirements

**[Composer](https://getcomposer.org/download/)**
**[PHP 7.3](https://www.apachefriends.org/download.html)**
<!-- **[MariaDB](https://www.apachefriends.org/download.html)** -->
<!-- **[NPM](https://www.npmjs.com/get-npm)** -->

## Installation

Use composer to install a new Laravel Project. This example uses Laravel 7

```bash
composer create-project laravel/laravel="7.*" Quickbooks-OAuth
```

After installing the new project, download the OAuth Library inside the new laravel project

```bash
composer require quickbooks/v3-php-sdk
```

## Usage

1. Create a Controller for Quickbooks OAuth then add the functions from this [file](https://getcomposer.org/download/)

```bash
php artisan make:controller Auth/Quickbook
```

2. Create a [Quickbooks Online application here](https://developer.intuit.com/app/developer/myapps). Then generate Client ID and Client Secret.

3. Add the generated Client ID, Client Secret and callback URI to the .env file.

```bash
QUICKBOOKS_CLIENT_ID=****************************************
QUICKBOOKS_CLIENT_SECRET=************************************
QUICKBOOKS_REDIRECT_URI=*************************************
```

4. Set the Quickbooks Data Service in [app.php](https://github.com/JosephSuyam/Quickbooks-OAuth2/blob/main/config/app.php)
```bash
'aliases' => [
    'QuickbooksService' => QuickBooksOnline\API\DataService\DataService::class,
],
```

5. Add the blades. Follow these [file path](https://github.com/JosephSuyam/Quickbooks-OAuth2/blob/main/resources/views/panel/quickbooks.blade.php)

## For Proper Quickbooks Documentation
[OAuth 2.0](https://developer.intuit.com/app/developer/qbo/docs/develop/authentication-and-authorization/oauth-2.0)

## 
