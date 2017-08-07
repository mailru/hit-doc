# Начало работы

## Шаг 1: Установить aws sdk go
Для того чтобы установить sdk go c зависимостями выполните команду:
```
go get -u github.com/aws/aws-sdk-go/...
```
Боле подробную информацию можете найти в [установка aws sdk go](https://github.com/mailru/hit-doc/blob/master/go/README.md)
## Шаг 2: Сконфигурировать учетные данные (credentials)
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
Более подробную информацию вы можете найти в [конфигурирование учетных данных](https://github.com/mailru/hit-doc/blob/master/go/Credentials/README.md)
## Шаг 3: Загрузить пакет и создать клиента
Чтобы создать экземпляр клиента службы, используйте функцию ```NewSession()```. В следующем примере создается клиент службы Amazon S3.
```
import "github.com/aws/aws-sdk-go/service/s3"
sess := session.Must(session.NewSession(&aws.Config{
    Region: aws.String("ru-msk"),
    Endpoint: aws.String("http://hb.bizmrg.com"),
}))
svc := s3.New(sess)
```
## Шаг 4: Выполнить операции
* Получить тело объекта
```
svc.GetObject(&s3.GetObjectInput{
    Bucket: aws.String("bucketName"),
    Key:    aws.String("keyName"),
})
```
* Положить объект
```
svc.PutObject(&s3.PutObjectInput{
        Bucket: aws.String(bucket),
        Key:    aws.String(key),
        Body:   strings.NewReader(content),
    })
```