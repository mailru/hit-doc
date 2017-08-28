#### Данная функция
- принимает в качестве аргументов
```
все заголовки, которые вы включаете в запрос
```
- возвращает две ссылки
```
  - одна содержит  CanonicalHeaders
  - вторая содержит SignedHeaders
```
#### В данной функции вы должны:
- включать в canonical headers и signed headers только те заголовка которые не будут меняться и гарантированно передаются
- все заголовки должны быть в lowercase
- значения всех заголовков должны подчиняться правилам
  - группа идущих подряд пробелов/табов заменяется на один пробел
  - пробелы/табы в начале и в конце удаляются
####  Формирование canonicalheaders и signedheaders
- canonicalHeaders формируются путем объединения подписываемых заголовков и их значений через ":". Каждая такая пара заголовок-значение разделяются "\n"
Например:
имеются заголовки
```
headers:
  "X-amz-date" = "20170801T000000Z"
  "Host"       = "bucketname.cldmail.ru"
  "X-amz-acl"  = "public"
  "Connection"   = "close"
```
вы должны получить
```
CanonicalHeaders =  "x-amz-date:20170801T000000Z\nhost:bucketname.cldmail.ru\nx-amz-acl:public"
SignedHeaders    = "x-amz-date;host;x-amz-acl"
```
####  В качестве примера прилагается перловая функция вычисляющая canonicalheaders и signedheaders
```
sub _canonicalize_headers_aws4 {
    my $hdr = shift;                                                  # принимаемые функцией параметры - заголовки
    my ($CanonicalHeaders,@SignedHeaders, %new_hdr)
    my @headers = grep(!/user-agent|Accept|x-real-ip|accept-language|connection|INTERNAL_REQUEST_ID/i,
        keys %$hdr);                                                     # исключение из заголовков тех которые могут меняться/не передаваться
    for my $header_name (@headers){                                    # копирование всех хедеров и их значений в новый хеш "%new_hdr"
        $new_hdr{$header_name} = $hdr->{$header_name};
    }

    for my $key (sort keys %new_hdr){                                  # все заголовки сортируются и при этом
        $new_hdr{$key} =~ s/[\s\t]+/ /g;                                 # группа пробелов/табов заменяется единичным пробелом
        $new_hdr{$key} =~ s/^\s?(.+)\s?$/$1/;                            # пробелы с начала ис  конца значения заголовка удаляются

        $CanonicalHeaders .= "$key:$new_hdr{$key}\n";                  # конкатенация  "заголовок:значение\n" к canonicalheaders
        push @SignedHeaders, $key;                                     # добавление заголовка в массив signedheaders
    }
    my $headers = join (";",@SignedHeaders);                           # превращение массива signedheaders в строку состаяющую из элементов этого массива, объндиненных через ";"
    return $CanonicalHeaders, $headers;                                # возвращение canonicalheaders и signedheaders
}
```