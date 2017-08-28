#### SignatureCalculating

##### 1. Формирование CanonicalRequest
Необходимо объединить в 1 строку следующие элементы через  "\n"
- CanonicalUri - Uri пропущенный через функцию канонаколизации [смотри файл](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/_uri_encode.md)
- CanonicalQuery query параметры урла после пропущенные через функцию [_sort_query_string](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/_sort_query_params.md)
- описание остальных параметров смотри в [ основные параметры ](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/README.md)
```
method
CanonicalURI
CanonicalQueryString
CanonicalHeaders
SignedHeaders
HashedPlayload
```
##### 2. Формирование Scope
Необходимо объединить в 1 строку следующие элементы через  "\n"
- описание параметров смотри в [ основные параметры ](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/README.md)
```
dateStamp
region
service
"aws4_request"

```
##### 3. Формирование String2Sign
Необходимо объединить в 1 строку следующие элементы через  "\n"
- Scope - смотри пункт 2
- описание остальных параметров смотри в [ основные параметры ](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/README.md)
```
"AWS4-HMAC-SHA256",
timeStamp,
Scope,
sha256_hex(CanonicalRequest)
```
##### 4. Формирование Signature
 1. Формирование $kSigning
 ```
my $kSecret   = encode('UTF-8', "AWS4".$secret_key);
my $kDate     = hmac_sha256($dateStamp, $kSecret);
my $kRegion   = hmac_sha256($region, $kDate);
my $kService  = hmac_sha256($service, $kRegion);
my $kSigning  = hmac_sha256("aws4_request", $kService);
 ```
2. Формирование $Signature
- String2Sign - смотри пункт 3
- kSigning    -  смотри пункт 4 часть 1
```
	my $Signature = hmac_sha256_hex( String2Sign, $kSigning);
```
##### 5. Формирование Url
теперь необходимо присоединить параметр с вычисленной signature из пункта 4 в конец урла:
```
url?query_param1&auth_query_params&X-Amz-Signature=Signature"
```
- query_param1 - любые параметры относящиеся к запросу  (acl и  тд)
- auth_query_params = (смотри пункт 11 [параметры авторизации](https://github.com/mailru/hit-doc/blob/master/authorization/v4-query/README.md))
```
"X-Amz-Algorithm=AWS4-HMAC-SHA256"
"X-Amz-Credential=EncodedCredentialString"
"X-Amz-Date=timeStamp"
"X-Amz-Expires=Expires"
"X-Amz-SignedHeaders=EncodedSignedHeaders"
```



