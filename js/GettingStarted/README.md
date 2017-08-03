# Начало работы в Node.js
### Шаг 1: Установить SDK  и зависимости
```
git clone https://github.com/awslabs/aws-nodejs-sample.git
```
Находясь в директории ```aws-nodejs-sample```, введите:
```
npm install
```
Более подробную инструкции можно найти в [установка aws sdk](https://github.com/mailru/hit-doc/blob/master/js/README.md)
### Шаг 2: Сконфигурируйте  Учетные данные (credentilas)
1. Создайте файл учетных данных в ```~/.aws /credentials```
Для Unix подобных систем - в директории ```home```
Для  Windows - в директории ```C:\Users\USER_NAME\```
2. Добавьте ключи доступа в файл
```
[default]
aws_access_key_id = YOUR_ACCESS_KEY_ID
aws_secret_access_key = YOUR_SECRET_ACCESS_KEY
```
Более подробную инструкции можно найти в [конфигрурирование учетных данных](https://github.com/mailru/hit-doc/blob/master/js/Credentials/README.md)
### Шаг 3: Загрузите SDK
После установки SDK вы можете загрузить пакет AWS, используя require.
```
var AWS = require('aws-sdk');
```
### Шаг 4: Загрузите Учетные данные (credentials) и создайте клиента
```
var AWS = require('aws-sdk');
var S3     = require('aws-sdk/clients/s3');

AWS.config.update({
    region: 'ru-msk',
    endpoint: 'http://hb.devmail.ru',
});

var s3 = new AWS.S3();
```
### Шаг 5: Выполните операции
Создав клиента S3 вы можете выполнять API запросы
* Получить тело объекта
```
s3.getObject({Bucket: 'bucketName', Key: 'keyName'}, function(err, data){
    if (err) console.log(err, err.stack); // an error occurred
    else     console.log(data);           // successful response
});
```
* Положить объект
```
s3.putObject({
    Body: <Binary String>,
    Bucket: "examplebucket",
    Key: "HappyFace.jpg",
}, function(err, data){
    if (err) console.log(err, err.stack); // an error occurred
    else     console.log(data);           // successful response
}
```

