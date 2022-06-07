# Запуск сервера

### Собираем контейнеры

Убедитесь перед началом сборки, что локальные порты ```80```, ```3306``` и ```9000``` не заняты другими сервисами

```bash
docker-compose up -d --build --force-recreate
```

### Подтягиваем зависимости в php контейнере

```bash
docker-compose exec php-fpm sh
composer install --optimize-autoloader
composer dump-autoload --classmap-authoritative --optimize
```
Выходим из контейнера при необходимости ```exit```

Контейнер web-сервера слушает порт `80`, можно проверить в браузере http://localhost