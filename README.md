# Events project

### test

- `touch database/database.sqlite`
- `touch database/database_test.sqlite`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan storage:link`
- `php artisan serve --host=gorizontclub --port=80`

### Деплой

- `php artisan migrate`
- `php artisan config:cache`
- `php artisan route:cache`
- `php artisan view:cache`

### Запуск php artisan serve с proxy

- `php artisan serve --host=gorizontclub --port=80`

