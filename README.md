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
       "qeti/SimplePOData": "dev-master",
       "qeti/Yii2PODataAdapter": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/qeti/POData"
        },
        {
            "type": "vcs",
            "url": "https://github.com/qeti/SimplePOData"
        },
        {
            "type": "vcs",
            "url": "https://github.com/qeti/Yii2PODataAdapter"
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

Set up class map for MetaProvider:

```php
yii::$classMap['iriscrm\Yii2PODataAdapter\implementation\MetadataProvider'] = '@app/models/OData/MetadataProvider.php';
```

Create classes, what describe entities, for example:

```php
namespace app\models\OData\Entities;

use yii\db\ActiveRecord;
use iriscrm\SimplePOData\EntityTrait;

class Request extends ActiveRecord {

    use EntityTrait;

    public $id;
    public $type_code;
    public $status_code;
}
```

Create MetaProvider class, what describe all entities for POData, for example:

```php
namespace iriscrm\Yii2PODataAdapter\implementation;

use POData\Providers\Metadata\Type\EdmPrimitiveType;
use POData\Providers\Metadata\SimpleMetadataProvider;

class MetadataProvider
{
    const MetaNamespace = "Data";

    /**
     * @return IMetadataProvider
     */
    public static function create()
    {
        $metadata = new SimpleMetadataProvider('Data', self::MetaNamespace);

        $requestEntityType = self::createRequestEntityType($metadata);
        $requestResourceSet = $metadata->addResourceSet('Requests', $requestEntityType);

        return $metadata;
    }

    private static function createRequestEntityType(SimpleMetadataProvider $metadata)
    {
        $et = $metadata->addEntityType(new \ReflectionClass('app\models\OData\Entities\Request'), 'Requests', self::MetaNamespace);
        $metadata->addKeyProperty($et, 'id', EdmPrimitiveType::INT64); 
        $metadata->addPrimitiveProperty($et, 'type_code', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($et, 'status_code', EdmPrimitiveType::STRING);
        return $et;
    }

}
```

Try to open links:

 - http://<youproject>/odata.svc/$metadata

 - http://<youproject>/odata.svc/Requests?$format=json&$skip=1&$top=14&$inlinecount=allpages&$filter=status_code eq 'held'

 - http://<youproject>/odata.svc/Requests/$count?&$filter=status_code eq 'held'

 - http://<youproject>/odata.svc/Requests(2465)

For more details about URL format, see [OData documentation](http://www.odata.org/documentation/odata-version-2-0/uri-conventions/).

### Am I free to use this?

This library is open source and licensed under the [MIT License][]. This means that you can do whatever you want
with it as long as you mention my name and include the [license file][license]. Check the [license][] for details.

[MIT License]: http://opensource.org/licenses/MIT

[license]: https://github.com/iriscrm/Yii2PODataAdapter/blob/master/LICENSE

Contact
-------

Feel free to contact me using [email](mailto:mnvx@yandex.ru).
