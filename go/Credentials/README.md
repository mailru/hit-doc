# Credentials

Для AWS SDK для Go требуются учетные данные (ключ доступа и секретный ключ доступа) для подписывания запросов на AWS. Вы можете указать свои учетные данные в нескольких разных местах, в зависимости от вашего конкретного варианта использования.

Когда вы инициализируете новый клиент службы без предоставления каких-либо аргументов полномочий, SDK использует цепочку поставщиков учетных данных по умолчанию, чтобы найти учетные данные AWS. Учетные данные ищутся в следующем порядке:

* Переменные окружения
* Файл, содержащий AWS credentials

В качестве наилучшей практики AWS рекомендует указывать учетные данные в следующем порядке:

* Файл, содержащий AWS credentials
* Переменные окружения
* Ключи доступа, вписанные непосредственно в код

## Использование файла, содержащего AWS credentials

Если у вас нет общего файла учетных данных (.aws / credentials), вы можете использовать любой текстовый редактор для его создания в своем домашнем каталоге. Добавьте в свой файл учетных данных следующий контент, заменив <YOUR_ACCESS_KEY_ID> и <YOUR_SECRET_ACCESS_KEY> своими учетными данными.

```
[default]
aws_access_key_id = <YOUR_ACCESS_KEY_ID>
aws_secret_access_key = <YOUR_SECRET_ACCESS_KEY>
```
Заголовок ```[default]``` определяет учетные данные для профиля по умолчанию, который будет использовать SDK, если вы не настроите его на использование другого профиля.

Вы можете включить несколько ключей доступа в один и тот же файл конфигурации, связав каждый набор ключей доступа с профилем. Например, в вашем файле учетных данных вы можете объявить несколько профилей, как показано ниже.
```
Copy
[default]
aws_access_key_id = <YOUR_DEFAULT_ACCESS_KEY_ID>
aws_secret_access_key = <YOUR_DEFAULT_SECRET_ACCESS_KEY>

[test-account]
aws_access_key_id = <YOUR_TEST_ACCESS_KEY_ID>
aws_secret_access_key = <YOUR_TEST_SECRET_ACCESS_KEY>
```

По умолчанию SDK проверяет переменную среды AWS_PROFILE, чтобы определить, какой профиль использовать. Если переменная AWS_PROFILE не установлена, SDK использует профиль по умолчанию.
```
$ AWS_PROFILE=test-account
```


Вы также можете использовать SDK для выбора профиля, указав ``` os.Setenv("AWS_PROFILE", test-account) ``` перед созданием клиента или указать вручную:
```
sess, err := session.NewSession(&aws.Config{
    Region:      aws.String("us-west-2"),
    Credentials: credentials.NewSharedCredentials("", "test-account"),
})
```
## Использование переменных окружения
По умолчанию SDK обнаруживает учетные данные AWS, установленные в вашей среде, и использует их для подписи запросов к AWS. Таким образом, вам не нужно управлять учетными данными в ваших приложениях.

SDK ищет учетные данные в следующих переменных среды:
* AWS_ACCESS_KEY_ID
* AWS_SECRET_ACCESS_KEY
##### Linux, OS X, or Unix
```
$ export AWS_ACCESS_KEY_ID=YOUR_AKID
$ export AWS_SECRET_ACCESS_KEY=YOUR_SECRET_KEY
```
##### Windows
```
> set AWS_ACCESS_KEY_ID=YOUR_AKID
> set AWS_SECRET_ACCESS_KEY=YOUR_SECRET_KEY
```
## Заносить credentials непосредственно в код

Вы можете жестко запрограммировать учетные данные в своем приложении, передав ключи доступа экземпляру конфигурации, как показано в следующем фрагменте.
```
sess, err := session.NewSession(&aws.Config{
    Region:      aws.String("ru-msk"),
    Credentials: credentials.NewStaticCredentials("AKID", "SECRET_KEY"),
    endpoint: aws.String('https://hb.bizmrg.com')
})
```
