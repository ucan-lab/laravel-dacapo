# Laravel-Dacapo

## Installation

```
$ composer require --dev ucan-lab/laravel-dacapo
```

## Generate default schema.yml

```
$ php artisan dacapo:init
```

### Laravel <= 5.6

```
$ php artisan dacapo:init --legacy
```

`database/schemas/default.yml`

## Generate migration files from schema.yml

```
$ php artisan dacapo:generate
```
