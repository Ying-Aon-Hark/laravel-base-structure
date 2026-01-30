## Introduction

> API built with Laravel and API Platform using PHP

## Prerequisites

Before starting, you should have:

- PHP v8.0.x
- [Composer](https://getcomposer.org/download/) - A tool for dependency management in PHP (Recommend v2.x).
- MySQL installed or other database engine

## Step 1 — Setting Up .env files

```bash
# Copy `.env` file to `.emv.local`
$ cp .env .env.local

# Configure your `DATABASE`

## Step 2 — Setting Up a Symfony Application

Install dependencies

```bash
$ composer install
```

> After installing all dependencies you should be able to run `php bin/console` command.

Creates the configured database

```bash
$ php artisan migrate
```

Seed for mockup data
```bash
$ php artisan db:seed
```

Clear the cache
```bash
$ php artisan config:clear
$ php artisan cache:clear
```

Run Project
```bash
$ php artisan serve
```
