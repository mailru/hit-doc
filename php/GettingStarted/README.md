## Начало работы
В этом руководстве основное внимание уделяется основным шаблонам использования AWS SDK для PHP. В этом руководстве предполагается, что вы уже загрузили и установили SDK и получили ключи доступа AWS.

### Шаг 1: Включение sdk
Независимо от того, какой метод вы использовали для установки SDK, вы можете включить SDK в свой код только одним требованием. Пожалуйста, обратитесь к следующей таблице для кода PHP, который наилучшим образом соответствует вашей методике установки. 
Пожалуйста, замените все экземпляры ```/path/to/``` фактическим путем в вашей системе.
* Используя Composer
```
require '/path/to/vendor/autoload.php';
```
Более подробную инструкцию вы можете найти в [установка aws sdk](https://github.com/mailru/hit-doc/blob/master/php/README.md)
### Шаг 2:  Сконфигурировать учетные данные (credentials)
Добавьте ваши ключи доступа в переменные окружения
```
export AWS_ACCESS_KEY_ID=<your_aws_access_key_id>
echo $AWS_ACCESS_KEY_ID
export AWS_SECRET_ACCESS_KEY=<your_aws_secret_access_key>
echo $AWS_SECRET_ACCESS_KEY
```
Более подробную инструкцию вы можете найти в [конфигурирование учетных данных](https://github.com/mailru/hit-doc/blob/master/php/Credentials/README.md)

### Шаг 3: Создать клиента
Основной шаблон использования SDK заключается в том, что вы создаете экземпляр объекта ```s3Client``` для службы AWS, с которой хотите взаимодействовать.```s3Client``` имеет методы, которые соответствуют методам API . Чтобы выполнить определенную операцию, вы вызываете ее соответствующий метод, который либо возвращает объект, похожий на массив в случае  успеха, либо генерирует исключение при ошибке.

#### 1. Создание клиента S3
Вы можете создать клиента, передав ассоциативный массив параметров конструктору клиента.
```
<?php
// Include the SDK using the Composer autoloader
require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',
     'endpoint' => 'http://hb.devmail.ru'
]);
```
Обратите внимание, что мы явно не предоставляем учетные данные (ключи доступа) для создания клиента. Это связано с тем, что учетные данные должны быть обнаружены SDK через
* переменные окружения (через AWS_ACCESS_KEY_ID и AWS_SECRET_ACCESS_KEY)
* AWS credential INI file -  идентификационный файл, находящийся в папке HOME 
* AWS Identity
* IAM
* Credential providers
Все общие параметры конфигурации клиента подробно описаны в руководстве по конфигурации. Массив параметров, предоставляемых клиенту, может варьироваться в зависимости от того, какой клиент вы создаете. 

#### 2. Создание клиента при помощи класса sdk 
Класс ```Aws\Sdk``` действует как фабрика клиентов и используется для управления общими параметрам для нескольких клиентов.
```
// Use the us-west-2 region and latest version of each client.
// There are not regions in Hotbox but you must include any region to work with aws-sdk client 
$sharedConfig = [
    'region'  => 'us-west-2',
    'version' => 'latest',
     'endpoint' => 'http://hb.devmail.ru'
];

// Create an SDK class used to share configuration across clients.
$sdk = new Aws\Sdk($sharedConfig);

// Create an Amazon S3 client using the shared configuration data.
$client = $sdk->createS3();
```
###  Шаг 4: Выполнение операций
* Пример работы данного скрипта вы можете увидеть в examples/sdlclent.php
Такие методы как putObject, все принимают один аргумент - ассоциативный массив, представляющий параметры операции. Структура этого массива (и структура объекта результата) определена для каждой операции в документации API SDK (API_Doc/putObject).
```
// Use an Aws\Sdk class to create the S3Client object.
$s3Client = $sdk->createS3();

// Send a PutObject request and get the result object.
$result = $s3Client->putObject([
    'Bucket' => 'my-bucket',
    'Key'    => 'my-key',
    'Body'   => 'this is the body!'
]);

// Download the contents of the object.
$result = $s3Client->getObject([
    'Bucket' => 'my-bucket',
    'Key'    => 'my-key'
]);

// Print the body of the result by indexing into the result object.
echo $result['Body'];
```
