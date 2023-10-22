# Pizza Factory API
API сервис для управления заказами пиццерии.  Предусмотрено 2 способа хранения данных: файл, база данных.

Алгоритм работы пиццерии:
* Клиент создает заказ
* Клиент может добавить товары в заказ
* Повар готовит заказ
* Повар может посмотреть список ожидающих и приготовленных заказов

## Содержание
- [Технологии](#технологии)
- [Требования](#требования)
- [Установка](#установка)
- [Тестирование](#тестирование)
- [Задачи](#задачи)

## Технологии
- [PHP 8](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/)
- [Symfony routing component](https://packagist.org/packages/symfony/routing)
- ...

## Требования
Для установки приложения ваш сервер должен иметь [PHP 8+](https://www.php.net/downloads.php), [Composer](https://getcomposer.org/).

## Установка

### Установка зависимостей

После выгрузки репозитория, необходимо установить все зависимости командой
```sh
composer update
```

### Установка способа хранения:

Для изменения способа хранения данных, достаточно выбрать альтернативный способ в файле конфигурации приложения [/config/app.php](/config/app.php)
```php
return [
    'storageType' => 'database', // file | database
];
```

### Конфигурация базы данных mysql:

Настройки подключения к базе данных хранятся в файле [/config/database.php](/config/database.php)
```php
return [
    'host' => 'localhost',
    'database' => 'pizzafactory',
    'username' => 'root',
    'password' => '',
];
```
Миграции пока что необходимо выполнить "вручную". Дамп базы с тестовыми данными находится в корне репозитория: [pizzafactory_orders.sql](pizzafactory_orders.sql)

## Тестирование

* Postman [коллекция](https://www.postman.com/kirillstan1221/workspace/test/collection/29802884-0ac746ee-0c6b-4ff1-8897-9f55e999d752?action=share&creator=29802884)
* OpenAPI [описание спецификации .yaml](openapi.yaml) (в процессе ...)

## Зачем разработал этот проект?
Чтобы был.

## Задачи
- [x] Маршрутизация с использованием компонента symfony/routing
- [x] Обработка CRUD операций
- [x] Хранение данных в файле
- [x] Хранение данных в базе
- [x] Соблюдение методологии The Twelve-Factor App
- [ ] Описание спецификации HTTP API
- [ ] Создать Dockerfile для сервиса
- [ ] Добавить сервис и все его зависимости в docker-compose
