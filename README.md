# WrapIt SDK for PHP

[![Build Status](https://travis-ci.org/WrapItDev/php-sdk.svg?branch=master)](https://travis-ci.org/WrapItDev/php-sdk)
[![Packagist](https://img.shields.io/packagist/v/wrapit/php-sdk.svg)](https://packagist.org/packages/wrapit/php-sdk)


## Installation

The WrapIt SDK can be installed with [Composer](https://getcomposer.org/). Run this command:

```sh
composer require wrapit/php-sdk
```

## Usage

Simple GET example to get data of a user profile
```PHP
$wi = new \WrapIt\WrapIt([
    'domain' => '{domain}',
    'client_id' => '{client-id}',
    'client_secret' => '{client-secret}'
]);

// Use the LoginHelper to get an AccessToken

$userhelper = new \WrapIt\Helpers\WrapItUserHelper($wi, "{access-token}");

try {
    $user = $userhelper->getUserData("me");
} catch (\WrapIt\Exceptions\WrapItResponseException $e) {
    echo 'The API returned an error: ' . $e->getMessage();
    exit;
}

echo 'Logged in as ' . $user["name"];
```
