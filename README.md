yii2-mts-communicator
=

Extension for sending SMS through MTS Communicator M2M API

[![Latest Stable Version](https://img.shields.io/packagist/v/mrssoft/yii2-mts-communicator.svg)](https://packagist.org/packages/mrssoft/yii2-mts-communicator)
![PHP](https://img.shields.io/packagist/php-v/mrssoft/yii2-mts-communicator.svg)
![Total Downloads](https://img.shields.io/packagist/dt/mrssoft/yii2-mts-communicator.svg)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mrssoft/yii2-mts-communicator "*"
```

or add

```
"mrssoft/yii2-mts-communicator": "*"
```

to the require section of your `composer.json` file.

Usage
-----

Configuration:

```php
// API MTS Communicator version 2.1
'components' => [
    ...
    'mts' => [
        'class' => 'mrssoft\mts\Communicator',
        'token' => '',
        'naming' => 'BRAND'
    ]
    ....
]
```

Usage:

```php
$mts = new Communicator();

$mts->sendMessage('Message', '79830000000');
$mts->sendMessages('Message', ['79830000000', '79830000001']);
```