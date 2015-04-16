Http Authentication
===================
Yii2 Http Authentication extension

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist lajax/yii2-http-auth "*"
```

or add

```
"lajax/yii2-http-auth": "*"
```

to the require section of your `composer.json` file.

Usage
-----

##Config

```php
'bootstrap' => ['httpAuth'],
'components' =>  [
    // ...
    'httpAuth' => [
        'class' => 'lajax\httpauth\Component',
        'allowedIps' => ['127.0.0.1', '127.0.0.2'],
        'users' => [
            'mrsmith' => '123456',
            'mrssmith' => 'e10adc3949ba59abbe56e057f20f883e'
        ]
    ],
    // ...
]
```