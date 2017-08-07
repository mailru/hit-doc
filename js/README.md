# Установка
### В браузере
Чтобы использовать SDK в браузере, просто добавьте следующий тег скрипта на свои HTML-страницы:
```
<Script src = "https://sdk.amazonaws.com/js/aws-sdk-2.94.0.min.js"> </ script>
```
Вы также можете создать собственный SDK для браузера с указанным набором служб AWS. Это может позволить вам уменьшить размер SDK, указать разные версии API-сервисов или использовать службы AWS, которые в настоящее время не поддерживают CORS, если вы работаете в среде, которая не обеспечивает соблюдение CORS. Для начала:
```
http://docs.aws.amazon.com/sdk-for-javascript/v2/developer-guide/building-sdk-for-browsers.html
```
AWS SDK также совместим с  [browserify](http://browserify.org/)
### В Node.js

Предпочтительным способом установки AWS SDK для Node.js является использование диспетчера пакетов npm для Node.js. Просто введите следующее в окно терминала:
```
Npm install aws-sdk
```
### В React Native

Чтобы использовать SDK в соответствующем проекте, сначала установите SDK с помощью npm:
```
Npm install aws-sdk
```
Затем в вашем приложении вы можете ссылаться на встроенную совместимую версию SDK:
```
Var AWS = require ('aws-sdk / dist / aws-sdk-react-native');
```
### Использование Bower

Вы также можете использовать [Bower](https://bower.io/) для установки SDK, введя следующее в окно терминала:
```
Bower install aws-sdk-js
```