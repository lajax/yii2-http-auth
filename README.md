# Yii2 HTTP authentication extension

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

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
