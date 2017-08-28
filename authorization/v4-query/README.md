####  Для функции создания сигнатуры вам необходимы следующие параметры:
##### 1) Method:
```
GET и тд
```
##### 2) Credentials:
```
    - access_key = "you-access-key"
    - secret_key = "you-secret-key"
    - region = "ru-msk"
```
##### 3) Service:
```
"s3"
```
##### 4) HashedPlayload
```
UNSIGNED-PAYLOAD
```
##### 5, 6) timeStamp и dateStamp
Если есть заголовок 'x-amz-date'
```
timeStamp = содержание заголовка 'x-amz-date'
dateStamp = часть отображающая время в заголовке 'x-amz-date'
```
Например:
```
'x-amz-date' = 20170609T120101Z
timeStamp = 20170609T120101Z
dateStamp = 20170609
```
Если нет заголовока 'x-amz-date', но  есть заголовок 'date'

* преобразуем заголовок 'date' в заголовок в формате 'x-amz-date' и далее из этой новой переменной вычисляем значения timeStamp и dateStamp
как указано выше, заголовок 'x-amz-date' не добавляем, передаем как и был 'date' в том же формате который был изначально

##### 7) CanonicalHeaders

смотри файл [_get_canonical_and_signed_headers](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/_get_canonical_and_signed_headers.md)

##### 8) SignedHeaders
смотри файл [_get_canonical_and_signed_headers](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/_get_canonical_and_signed_headers.md)
##### 9) Credential (не хеш с ключами доступа а строка включающаяся url в 'x-amz-credentials') - объединяются в одну строку через "\n"
```
access_key
dateStamp
region
service
"aws4_request"
```
##### 10) Expires
```
Содержание заголовка 'x-amz-expires' - число в секундах или дефолтное значение 86400
```
##### 11) URI
1. До начала вычисления подписи необходимо добавить в query параметры урла все параметры авторизации кроме сигнатуры
2. Если в урле уже содержатся query параметры, то параметры авторизации дописываются после них
3. Данные параметры добавляются через "&"

- timeStamp - смотри 5 пункт
- EncodedCredentialString - Credential из пункта 9 с заэнкожеными символами (смотри файл  [_uri_encode](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/_uri_encode.md))
- Expires - смотри 10 пункт
- EncodedSignedHeaders - SignedHeaders из пункта 8  с заэнкожеными символами (смотри файл  [_uri_encode](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/_uri_encode.md))
```
"X-Amz-Algorithm=AWS4-HMAC-SHA256"
"X-Amz-Credential=EncodedCredentialString"
"X-Amz-Date=timeStamp"
"X-Amz-Expires=Expires"
"X-Amz-SignedHeaders=EncodedSignedHeaders"
```

### Следуйте в файл  [SignatureCalculating](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/SignatureCalculating.md)
