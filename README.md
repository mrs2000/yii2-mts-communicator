yii2-mts-communicator
=

Extension for sending SMS through MTS Communicator M2M API

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
'components' => [
    ...
    'mts' => [
        'class' => 'mrssoft\mts\Communicator',
        'login' => '',
        'password' => '',
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