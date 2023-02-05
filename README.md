Testello
=========

## Overview
Testello is a software build to perform the following tasks:

- Manage customers with delivery tables
- Import a customer delivery table CSV large file and store it on the deliveries table

It was developed using git Trunk Based Development, TDD and Agile.

## Technologies
- PHP 8.2
- XDebug 3
- Docker
- Laravel 9
- Vue3
- Mysql

## Install

**1.1. Docker build with XDebug (local)**
```
docker compose build --build-arg INSTALL_XDEBUG=true
```

**1.2. Docker build without XDebug (prod)**
```
docker compose build
```

**2. Set .env**
```
cp .env.example .env
```

**3. Docker up**
```
docker compose up
```

**4. Install composer packages**
```
docker compose exec app composer install
```

**5. Install npm packages**
```
docker compose exec app npm install
```

**6. Set app key**
```
docker compose exec php artisan key:generate
```

**7.1. Run migrations (without populate the database)**
```
docker compose exec php artisan migrate
```

**7.2. Run migrations (populate the database)**
```
docker compose exec php artisan migrate --seed
```

**8. Build Vue**
```
docker compose exec app npm run build 
```

**9. Run queue listen**
```
docker compose exec app php artisan queue:listen
```

## Run Tests
```
docker compose exec app php artisan test
```

## Access
Application: [http://127.0.0.1:8000/](http://127.0.0.1:8000/)
<br><br>
Database (phpMyAdmin): [http://127.0.0.1:8002/](http://127.0.0.1:8002/)
<br><br>
Email (MailHog): [http://127.0.0.1:8003/](http://127.0.0.1:8003/)
