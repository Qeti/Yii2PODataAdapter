Adapter POData-Yii2
===================

What is this? <a name="what"></a>
-------------

Adapter for using [OData](http://www.odata.org/) in [Yii2](http://www.yiiframework.com) with library [POData](https://github.com/POData/POData).

### Who is using it?

- It's instrument for developers, who using [Yii2 framework](http://www.yiiframework.com).


Installation <a name="installation"></a>
------------

[PHP 5.4 or higher](http://www.php.net/downloads.php) is required to use it.
[Yii2 framework](http://www.yiiframework.com) is required to use it.

Installation is recommended to be done via [composer][]. Add the following to the `require` and `repositories` sections in `composer.json` of Yii2 project:

```json
    "require": {
       "POData/POData": "dev-master",
       "iriscrm/Yii2PODataAdapter": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/POData/POData"
        },
        {
            "type": "vcs",
            "url": "https://github.com/iriscrm/Yii2PODataAdapter"
        }
    ]
```

Run `composer update` afterwards.

[composer]: https://getcomposer.org/ "The PHP package manager"


Usage <a name="usage"></a>
-----

### In your basic Yii2 project

Add the following to the configuration file `web.php`:

```php
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'iriscrm\Yii2PODataAdapter\ODataUrlRule'],
            ],
        ],
    ],
    'controllerMap' => [
        'o-data' => 'iriscrm\Yii2PODataAdapter\implementation\ODataController',
    ],

```




### Am I free to use this?

This library is open source and licensed under the [MIT License][]. This means that you can do whatever you want
with it as long as you mention my name and include the [license file][license]. Check the [license][] for details.

[MIT License]: http://opensource.org/licenses/MIT

[license]: https://github.com/iriscrm/Yii2PODataAdapter/blob/master/LICENSE

Contact
-------

Feel free to contact me using [email](mailto:mnvx@yandex.ru).
