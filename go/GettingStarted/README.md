# Начало работы

В AWS SDK для Go сеанс - это объект, содержащий информацию о конфигурации клиентов. Всякий раз, когда вы создаете клиент службы, вы должны указать сеанс.

Сеансы могут быть доступны для всех клиентов службы, которые используют одну и ту же базовую конфигурацию. Сеанс построен из конфигурации SDK по умолчанию и обработчиков запросов.

При необходимости следует кэшировать сеансы. Это связано с тем, что при создании нового сеанса каждый раз, когда создается сеанс, загружаются все значения конфигурации из среды и файлов конфигурации. Совместное использование значения сеанса для всех ваших клиентов службы гарантирует, что конфигурация загружается наименьшее количество раз.