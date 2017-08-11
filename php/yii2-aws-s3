# Настройка frostealth/yii2-aws-s3 для работы с HotBox/Icebox

Данный документ описывает как настроить приложение yii2 для работы с HotBox/Icebox с применением плагина [yii2-aws-s3](https://github.com/frostealth/yii2-aws-s3)

* Для коректной работы необходимо указать корректный endpoint, но, к сожалению, плагин не позволяет установить данную опцию через конфиг

#### Cоздание своего сервиса
Для добавления возможности указать endpoint в конфиге необходимо создать свой Service, унаследовав его от Service из плагина

```php
<?php
namespace common\components;
use frostealth\yii2\aws\s3\Service as BaseService;

class S3ServiceMailBiz extends BaseService
{
    public function setEndpoint(string $options)
    {
        $this->clientConfig['endpoint'] = $options;
    }
}
```
#### Настройка endpoint в конфиге
Далее нужно указать в конфиге приложения следующий конфиг

```php
's3' => [
        'class' => 'common\components\S3ServiceMailBiz',
        'region' => 'default', // for mail.biz you can set any region
        'defaultAcl' => 'public-read',
        'defaultBucket' => 'your-backet-name',
        'credentials' => [ // Aws\Credentials\CredentialsInterface|array|callable
        'key' => 'your-key',
        'secret' => 'your-secret',
    ],
    'endpoint' => 'https://hb.bizmrg.com'
],
```
После этого вы можете работать с сервисом так, как вы привыкли
