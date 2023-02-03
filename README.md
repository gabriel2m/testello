## About Testello

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

**1.1. Docker Build without XDebug**

```
docker compose build
```
**1.2. Docker Build with XDebug**

```
docker compose build --build-arg INSTALL_XDEBUG=true
```

**2. Set .env**
```
cp .env.example .env
```

**3. Docker Up**

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

**7.1. Run the migrations (without populate the database)**
```
docker compose exec php artisan migrate
```

**7.2. Run the migrations (populate the database)**
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

**10. Done!**
<br>
Access [http://127.0.0.1:8000/](http://127.0.0.1:8000/)

## Run Tests

```
docker compose exec app php artisan test
```
