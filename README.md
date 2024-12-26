# User balances

A small application for manipulating users' balance

Base tech:

- PHP 8.4
- MySQL 8.2
- Redis 7.4.1
- Laravel 11.36.1
- Vue 3.5.13
- Bootstrap 5.3.3

Features:

- Event sourcing for Balance operations
- Base architecture for laravel projects: Service, Repository, DTO, Resources, Requests etc.
- Jobs for balance operations

## Launch Backend
### Copy env file
```bash
cp .env.example .env
```

### Docker
```dockerfile
docker-compose up -d
```

### Laravel

Open app container terminal
```shell
docker-compose exec app bash
```

Then use artisan commands:
```shell
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan queue:work
```

Make commands:
1. Create user with step-by-step command:
```shell
php artisan app:user-create
```
2. Balance operations:
```shell
php artisan app:balance {login} {operation} {amount} {description}
```
Balance operation types:
- balance_credited - increase balance
- balance_debited - decrease balance

## Launch Frontend

Enter frontend folder && install packages:
```shell
cd frontend && npm install
cd frontend || npm install (Windows)
```

Run development:
```shell
npm run dev
```