# Учетные данные
Для прохождения аутентификации сервисы Hotbox/Icebox обеспечивают вас ключами доступа, известными как:
1) AWS access key ID
2) AWS secret access key
##### В AWS SDK пара этих ключей называются ```Credentials```
## Способы подключения credentials
* Использовать переменные окружения
* Использовать файла, содержащего AWS credentials ( используя credential profiles )
* Заносить credentials непосредственно в код
* Использовать credential provider

## 1. Использование переменных окружения

Если вы не предоставите учетные данные объекту клиента во время его создания, SDK попытается найти учетные данные в вашей среде. Первое, что SDK проверит для учетных данных, - это переменные окружения. SDK будет использовать функцию функции getenv () для поиска переменных окружения AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY и AWS_SESSION_TOKEN.
```
export AWS_ACCESS_KEY_ID=6B7hCqne2PnWonbS9wZQie
echo $AWS_ACCESS_KEY_ID
export AWS_SECRET_ACCESS_KEY=5QDoD91JUhqRN88oA1UfDGJJk4F4KGBi6hQfiTqgez8B
echo $AWS_SECRET_ACCESS_KEY
```
* Пример создания credentials с помощью переменных окружения вы можете увидеть в examples/env_credentials.php

## 2. Использование файла, содержащего AWS credentials ( используя credential profiles )
Начиная с AWS SDK для PHP версии 2.6.2, вы можете использовать файл учетных данных AWS, чтобы указать свои учетные данные. Это специальный, INI-форматированный файл, хранящийся в вашем домашнем каталоге, и является хорошим способом управления учетными данными для вашей среды разработки. Файл должен быть помещен в ```~/.aws/credentials```, где ~ представляет ваш каталог HOME.

Использование файла учетных данных AWS предлагает несколько преимуществ:
* Учетные данные ваших проектов хранятся за пределами ваших проектов.
* Вы можете определить несколько наборов учетных данных в одном месте.
* Вы можете легко использовать одни и те же учетные данные между проектами.
* Другие SDK и инструменты AWS поддерживают этот же файл учетных данных. Это позволяет повторно использовать ваши учетные данные с помощью других инструментов.
Формат файла учетных данных AWS должен выглядеть примерно так:
```
[default]
aws_access_key_id = YOUR_AWS_ACCESS_KEY_ID
aws_secret_access_key = YOUR_AWS_SECRET_ACCESS_KEY

[project1]
aws_access_key_id = ANOTHER_AWS_ACCESS_KEY_ID
aws_secret_access_key = ANOTHER_AWS_SECRET_ACCESS_KEY
```
Каждый раздел (например, [default], [project1]) представляет отдельный профиль учетных данных. На профили можно ссылаться из файла конфигурации SDK или при создании экземпляра клиента, используя опцию профиля:
```
<?php

use Aws\S3\S3Client;

// Instantiate a client with the credentials from the project1 profile
$client = S3Client([
    'profile' => 'project1',
    'region'  => 'us-west-2',
    'version' => 'latest',
    'endpoint' => 'http://hb.devmail.ru'
]);
```
* Более подробный пример вы можете увидеть в examples/ini_credentials.php

### 3. Заносить credentials непосредственно в код
```
$s3Client = new S3Client([
    'version'     => 'latest',
    'region'      => 'us-west-2',
    'credentials' => [
        'key'    => 'my-access-key-id',
        'secret' => 'my-secret-access-key',
    ],
    'endpoint' => 'http://hb.devmail.ru'
]);
```
* Более подробный пример вы можете увидеть в  examples/hard_coded_credentials.php
### 4. Использовать credential provider

credential provider - это функция, которая возращаяет GuzzleHttp\Promise\PromiseInterface, который в свою очередь  выполняется с помощью экземпляра Aws\Credentials\CredentialsInterface или отклоняется с помощью исключения Aws\Exception\CredentialsException.

Результат credential provider передается в опцию credentials конструктора клиента.

```
use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;

// Use the default credential provider
$provider = CredentialProvider::defaultProvider();

// Pass the provider to the client.
$client = new S3Client([
    'region'      => 'us-west-2',
    'version'     => '2006-03-01',
    'credentials' => $provider,
     'endpoint' => 'http://hb.devmail.ru'
]);
```
Credential provider вызывается каждый раз, когда выполняется операция API. Если загрузка учетных данных является дорогостоящей задачей (например, загрузка с диска или сетевого ресурса) или если учетные данные не кэшируются вашим провайдером, вам следует рассмотреть возможность переноса вашего поставщика учетных данных в функцию  Aws\Credentials\CredentialProvider::memoize.

#### 1) env provider

Aws\Credentials\CredentialProvider::env пытается загрузить credentials из переменных окружения
```
use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;

$client = new S3Client([
    'region'      => 'us-west-2',
    'version'     => '2006-03-01',
    'credentials' => CredentialProvider::env(),
     'endpoint' => 'http://hb.devmail.ru'
]);
```
#### 2) ini provider
Aws\Credentials\CredentialProvider::ini пытается загрузить credentials из файла  ~/.aws/credentials

```
use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;

$provider = CredentialProvider::ini();
// Cache the results in a memoize function to avoid loading and parsing
// the ini file on every API operation.
$provider = CredentialProvider::memoize($provider);

$client = new S3Client([
    'region'      => 'us-west-2',
    'version'     => '2006-03-01',
    'credentials' => $provider,
    'endpoint'    => 'http://hb.devmail.ru'
]);
```

