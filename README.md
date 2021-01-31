# Server Project - Backend

## Build Setup

```bash
# install dependencies
$ composer install

# create .env
set env variables based on .env.example

# create database and set name into .env

# set timezone to BuenosAires in MySQL
SELECT now(); displays current timedate
/mysql/my.cnf -> default-time-zone = "-03:00"

# migrate and seed
php artisan migrate --seed

# create storage link
php artisan storage:link

# serve with hot reload at localhost:8000 (omit if served with WAMP, XAMP)
$ php artisan serve
```
