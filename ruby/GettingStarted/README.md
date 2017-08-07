# Начало Работы
### Шаг 1: Установить AWS SDK для Ruby
Наиболее популярным способом установки является использование ```RubyGems```:
```
gem install aws-sdk
```
Более подробную инструкцию по установке вы можете найти в [установка](https://github.com/mailru/hit-doc/blob/master/ruby/README.md)
### Шаг 2: Сконфигурировать учетные данные
Создайте файл, содержащий credentials (учетные данные).
Для Unix подобных систем ( Linux и тд):
```
~/.aws/credentials
```
Для Windows:
```
%HOMEPATH%\.aws\credentials
```
Содержание файла:
```
[default]
aws_access_key_id = your_access_key_id
aws_secret_access_key = your_secret_access_key
```
Более подробную инструкцию вы можете найти в [учетные данные](https://github.com/mailru/hit-doc/tree/master/ruby/Credentials)
### Шаг 3: Создайте клиента
```
require 'aws-sdk'

s3 = Aws::S3::Client.new(endpoint: "https://hb.bizmrg.com")
```
### Шаг 4: Выполните операции
```
require 'aws-sdk'
require 'pp'

s3 = Aws::S3::Client.new(endpoint: "https://hb.bizmrg.com")

s3.put_object(
    bucket: "bucketname",
    key: "objectname",
    body: "content"
)

resp = s3.get_object(
    bucket: "bucketname",
    key: "objectname",
)
puts "Etag of downloaded file: " + resp["etag"] + "\n"
```
