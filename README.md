# Pizza Factory API
API сервис для управления заказами пиццерии. 

## Содержание
- [Технологии](#технологии)
- [Требования](#требования)
- [Установка](#установка)
- [Задачи](#задачи)

## Технологии
- [PHP 8](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/)
- [Symfony routing component](https://packagist.org/packages/symfony/routing)
- ...

## Требования
Для установки приложения ваш сервер должен иметь PHP8+, composer.

## Установка

### Установка зависимостей

После выгрузки репозитория, необходимо установить все зависимости командой
```sh
composer update
```

### Установка способа хранения [/config/app.php](/config/app.php):

```php
return [
    'storageType' => 'database', // file | database
];
```

### Миграции:

Пока что необходимо выполнить "вручную". Дамп базы с тестовыми данными находится в корне репозитория: [pizzafactory_orders.sql](pizzafactory_orders.sql)


## Зачем разработал этот проект?
Чтобы был.

## Задачи
- [x] Маршрутизация с использованием компонента symfony/routing
- [x] Обработка CRUD операций
- [x] Хранение данных в файле
- [x] Хранение данных в базе
- [ ] Описание спецификации HTTP API
- [ ] Соблюдение методологии The Twelve-Factor App
- [ ] Создать Dockerfile для сервиса
- [ ] Добавить сервис и все его зависимости в docker-compose
