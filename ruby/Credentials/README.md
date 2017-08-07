# Учетные данные
Для прохождения аутентификации сервисы Hotbox/Icebox обеспечивают вас ключами доступа, известными как:
1) AWS access key ID
2) AWS secret access key
* В AWS SDK пара этих ключей называются ```Credentials``
## Способы подключения учетных данных ```Credentials```
В следующих разделах описываются различные способы установки учетных данных, начиная с самого гибкого подхода
* Использовать файла, содержащего AWS credentials ( используя credential profiles )
* Использовать переменные окружения
* Использовать хеша Aws.config
* Задавать ключи доступа при конфигурации клиента

### Использование файла, содержащего AWS credentials ( используя credential profiles )
В системах на базе Unix, таких как Linux или OS X, этот файл находится в следующем расположении.
```
~/.aws/credentials
```
В Windows этот файл находится в следующем расположении.
```
%HOMEPATH%\.aws\credentials
```

Этот файл должен иметь следующий формат:
```
[default]
aws_access_key_id = your_access_key_id
aws_secret_access_key = your_secret_access_key
```
По умолчанию используется имя профиля конфигурации ```default``` your_access_key_id - это значение вашего ключа доступа.
your_secret_access_key - значение вашего секретного ключа доступа.

### Использование переменных окружения
Установите переменные окружения AWS_ACCESS_KEY_ID и AWS_SECRET_ACCESS_KEY.

Используйте команду export, чтобы установить эти переменные в системах на базе Unix, таких как Linux или OS X.
```
export AWS_ACCESS_KEY_ID=your_access_key_id
export AWS_SECRET_ACCESS_KEY=your_secret_access_key
```

Чтобы установить эти переменные в Windows, используйте команду set:
```
set AWS_ACCESS_KEY_ID=your_access_key_id
set AWS_SECRET_ACCESS_KEY=your_secret_access_key
```

### Использование хеша Aws.config
Задайте учетные данные в своем коде, обновив значения в хэше Aws.config.

В следующем примере задается значение ваших ключей доступа. Любой клиент или ресурс, который вы создаете впоследствии, будет использовать эти учетные данные.

```
Aws.config.update({
   credentials: Aws::Credentials.new('your_access_key_id', 'your_secret_access_key')
})
```

### Задание ключей доступа при конфигурации клиента
Задайте учетные данные в своем коде, указав их при создании клиента AWS.

В следующем примере создается клиент Amazon S3, используя ключ доступа your_access_key_id и секретный ключ доступа your_secret_access_key.

```
s3 = Aws::S3::Client.new(
  access_key_id: 'your_access_key_id',
  secret_access_key: 'your_secret_access_key',
  endpoint: 'https://hb.bizmrg.com'
)
```

Endpoint всегда необходимо указывать при создании S3 клиента.

## Установка региона
Установить регион вы можете несколькими способами
* Используя переменные окружения
* Использовать хеш Aws.config
* Задавать регион при конфигурации клиента

### Использование переменных окружения
Используйте команду export, чтобы установить переменную в системах на базе Unix, таких как Linux или OS X.
```
export AWS_REGION=ru-msk
```
Чтобы установить переменную в Windows, используйте команду set:
```
set AWS_REGION=ru-msk
```
### Использование хеша Aws.config
Задайте учетные данные в своем коде, обновив значения в хэше Aws.config.
```
Aws.config.update({region: 'ru-msk'})
```
### Задание региона при конфигурации клиента
```
s3 = Aws::S3::Resource.new(
    region: 'ru-msk',
    endpoint: 'https://hb.bizmrg.com'
)
```
