# SLIM Swoole

<!-- [![Build Status](https://github.com/POABOB/Slim-4-Framework/actions/workflows/build.yml/badge.svg)](https://github.com/POABOB/Slim-4-Framework/actions)
[![Coverage Status](https://coveralls.io/repos/github/POABOB/Slim-4-Framework/badge.svg?branch=main)](https://coveralls.io/github/POABOB/Slim-4-Framework?branch=main)
[![PHP Version Require](https://poser.pugx.org/poabob/slim-4-framework/require/php)](https://packagist.org/packages/poabob/slim-4-framework)
[![License](https://poser.pugx.org/poabob/slim-4-framework/license)](https://packagist.org/packages/poabob/slim-4-framework) -->

## Introduction

> This project was built with php SLIM 4 framework with ADR mode using swoole, whcich is a compatible resolution of RESTful Api.

### Features

* Framework - [SLIM 4](https://www.slimframework.com/)
* Container - [Docker](https://www.docker.com/)
  * php8 - [Swoole 4.8](https://wiki.swoole.com/#/)
  * Database - [MariaDB](https://mariadb.org/)
* Test - [Codeception](https://codeception.com/)
* Api Document - [Swagger-ui](https://swagger.io/tools/swagger-ui/)
* ORM - [Medoo](https://medoo.in/)
* CI/CD - [Github Actions](https://github.com/features/actions)

### Minimal requirements

* docker/docker-compose
* php: >=8.0
* composer

## Installation


### Config

* Write your Db schema

`init.sql`
```
CREATE DATABASE IF NOT EXISTS Example;
USE Example;
CREATE TABLE IF NOT EXISTS `Example`.`Users` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL, `password` VARCHAR(64) NOT NULL ,  PRIMARY KEY (`id`)) ENGINE = InnoDB;
```

* DB config

> If you use sqlite for your database, juse commit mysql config.

`docker-compose.yml`
```
  mysql:
    ...
    environment:
      - MYSQL_DATABASE={DB}
      - MYSQL_ROOT_PASSWORD={root_password}
      - MYSQL_USER={user}
      - MYSQL_PASSWORD={user_password}
```

* Generate Secret Key for Jwt

```
# Generate PRIVATE KEY
openssl genrsa -out private.pem 2048
# Generate PUBLIC KEY
openssl rsa -in private.pem -outform PEM -pubout -out public.pem
```

* .env configuration

> If you use sqlite for your database, just commit mysql config.

```
# dev/prod/stage/test
MODE=dev
# MYSQL CONFIG
DB_DRIVER=mysql
DB_NAME={DB}
DB_HOST=mysql
DB_USER={user}
DB_PASS={user_password}
DB_CHARSET=utf8mb4

# SQLITE CONFIG
# DB_DRIVER=sqlite
# DB_NAME={./path/Example.db}

# SETTINGS FOR DEBUG (0/1)
# please don't display error details in production environment.
DISPLAY_ERROR_DETAILS=1
LOG_ERROR_DETAILS=1
LOG_ERRORS=1


# JWT SETTINGS
JWT_ISSUER=SLIM_4
JWT_LIFETIME=86400
JWT_PRIVATE_KEY="{PRIVATE KEY}"
JWT_PUBLIC_KEY="{PUBLIC KEY}"
```

## Run

### dev

```
composer install
docker-compose up -d
```

### prod

```
composer install --no-dev --optimize-autoloader
docker-compose -f docker-compose-prd.yaml up -d
```

### test

```
<!-- Before you test, please check out your vendor which was instlled. -->
composer run test
```
