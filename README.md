# Yii2 HTTP authentication extension

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This extension can be used to protect your Yii2 application with HTTP authentication against
unauthorized access. For example you can use it to prevent users seeing your development environment. 

## Installation

Via [Composer](http://getcomposer.org/download/)

```
composer require lajax/yii2-http-auth
```

## Usage

You need to `bootstrap` the component on the start of the application. 

On execution the component will check the IP address of the user. If the IP address is not in the
`allowedIps` list, a HTTP authentication will be performed.

With the `users` option you can specify username and password pairs for accessing the application.
The value can be either an actual password, or an MD5 hash of the password. 


### Config

```php
'bootstrap' => ['httpAuth'],
'components' =>  [
    // ...
    'httpAuth' => [
        'class' => 'lajax\httpauth\Component',
        'allowedIps' => ['127.0.0.1', '127.0.0.2'],
        'users' => [
            // Actual password:
            'mrsmith' => '123456',
            // MD5 hash of the password:
            'mrssmith' => 'e10adc3949ba59abbe56e057f20f883e',
        ],
        'errorAction' => 'site/error',
    ],
    // ...
]
```

## Coding style

The project uses the PSR-2 coding standard. Related commands:

 - `composer cs-fix`: Fix coding style issues.
 - `composer cs-check`: Check for coding style issues.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The 3-Clause BSD License. Please see [License File](LICENSE.md) for more information.


[ico-version]: https://img.shields.io/packagist/v/lajax/yii2-http-auth.svg?style=flat
[ico-license]: https://img.shields.io/badge/license-BSD3-brightgreen.svg?style=flat
[ico-downloads]: https://img.shields.io/packagist/dt/lajax/yii2-http-auth.svg?style=flat

[link-packagist]: https://packagist.org/packages/lajax/yii2-http-auth
[link-downloads]: https://packagist.org/packages/lajax/yii2-http-auth