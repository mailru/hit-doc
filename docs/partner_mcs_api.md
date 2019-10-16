# Описание Партнерского апи
# Блокировка и разблокировка клиентов партнера
### Описание
Партнер имеет возможность заблокировать и разблокировать своего клиента.
### Запрос
```
POST /api/v1/partners/mcs1799088242/clients/mcs9040223949/block HTTP/2
Host: mcs.mail.ru
Content-type:application/json
Authorization: Bearer TOKEN
```
Body:
```
{"enabled":true}
```
##### Параметры запроса
* mcs1799088242 - пид партнерского проекта
* mcs9040223949 - пид клиентского проекта, над которым производится действие. Важно понимать, что блокируется именно проект. То есть, если партнер привязал клиента с несколькими проектами, то ему необходимо заблокировать каждый из них отдельно.
* enabled - при значении равном true клиентский проект разблокируется, при значении равном false проект заблокируется.

### Ответ при валидном запросе
```
HTTP/2 200
Content-Type: application/json
date: Wed, 16 Oct 2019 17:27:16 GMT
X-req-id: 2NrqrYuki
```
```
{
	"ctime":"1571133061.74047",
	"owner":{
		"email":"suslova_vichka+1011@mail.ru",
		"uid":3268134864,
		"name":"vika2"
	},
	"phone":0,
	"attr":{
		"client_id":"vika2"
	},
	"pid":"mcs9040223949",
	"verified":{
		"fraud":{
			"status":"APPROVE"
		}
	},
	"title":"mcs9040223949",
	"partner":{
		"pid":"mcs1799088242",
		"title":"mcs1799088242",
		"attr":{
			"partner_approved":true
		}
	},
	"is_partner":false,
	"enabled":true
}
```
##### Описание JSON-элементов
* owner.email - емейл клиента партнера
* phone   - телефон клиента партнера
* attr.client_id - уникальныйй идентификатор клиента партнера
* pid   - пид ( уникальный идентификатор ) проекта клиента партнера
* title - имя проекта клиента партнера
* partner.pid - пид партнерского проекта
* partner.title - имя партнерского проекта
* enabled - флаг, отображающий заблокирован клиентский проект или нет

### Ответ при попытке заблокировать/разблокировать не своего клиента
```
HTTP/2 403
Content-Type: application/json
date: Wed, 16 Oct 2019 17:27:16 GMT
X-req-id: 2NrqrYuki
```
```
{
	"value":"mcs1799088242",
	"error":"ACCESS_DENIED",
	"message":"Project=mcs6852018272 is not partnered with given partner",
	"key":"partner"
}
```
