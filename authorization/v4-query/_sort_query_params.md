#### Данная функция
- принимает
```
строку
```
- отдает
```
строку
```
#### Данная функция выполняет
```
X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=EncodedCredentialString&X-Amz-Date=timeStamp&X-Amz-Expires=Expires&X-Amz-SignedHeaders=EncodedSignedHeaders
```
-  делит строку на массив из отдельных элементов query параметров
```
array:
  - X-Amz-Algorithm=AWS4-HMAC-SHA256
  - X-Amz-Credential=EncodedCredentialString
  - X-Amz-Date=timeStamp
  - X-Amz-Expires=Expires
  - X-Amz-SignedHeaders=EncodedSignedHeaders  
```
- делит каждый элемент массива на ключ и значение
- анескейпит и эскейпит каждый ключ и значение
- заменяет все плюсы на пробелы

- собирается обратно в строку
```
X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=EncodedCredentialString&X-Amz-Date=timeStamp&X-Amz-Expires=Expires&X-Amz-SignedHeaders=EncodedSignedHeaders
```

#### Пример функции на perl

```
sub _sort_query_string {
	return '' unless length $_[0];
	my @params;
	for my $param (split /&/, $_[0] ) {
		my ( $key, $value ) =
			map { tr/+/ /; uri_escape( uri_unescape( $_ ) ) }
			split /=/, $param;
		push @params, join '=', $key, $value;
	}
	return join '&', sort @params;
}

```
