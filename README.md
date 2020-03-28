# Laravel-Dacapo

[![Build Status](https://travis-ci.org/ucan-lab/laravel-dacapo.svg?branch=master)](https://travis-ci.org/ucan-lab/laravel-dacapo)
[![Latest Stable Version](https://poser.pugx.org/ucan-lab/laravel-dacapo/v/stable)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Total Downloads](https://poser.pugx.org/ucan-lab/laravel-dacapo/downloads)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Monthly Downloads](https://poser.pugx.org/ucan-lab/laravel-dacapo/d/monthly)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Daily Downloads](https://poser.pugx.org/ucan-lab/laravel-dacapo/d/daily)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Latest Unstable Version](https://poser.pugx.org/ucan-lab/laravel-dacapo/v/unstable)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![License](https://poser.pugx.org/ucan-lab/laravel-dacapo/license)](https://packagist.org/packages/ucan-lab/laravel-dacapo)

## Introduction

Dacapo is a Laravel migration file creation support library.
Define the table structure in the schema yml file, Always generate the latest and tidy migration file.

This library is intended for use only in the coding phase.
In the operation phase, uninstall and return to normal migration operation.

## Installation

```
$ composer require --dev ucan-lab/laravel-dacapo
```

## Usage

### Generate default schema.yml

```
$ php artisan dacapo:init
```

`database/schemas/default.yml`
By default, a schema file for Laravel7 is generated.  
Reference example of schema yml and output example of migration file: [Example schema.yml](/tests/Storage)

Contents of `database/schemas/default.yml`

```yaml
users:
  columns:
    id: id
    name: string
    email:
      type: string
      unique: true
    email_verified_at:
      type: timestamp
      nullable: true
    password: string
    rememberToken: true
    timestamps: true

failed_jobs:
  columns:
    id: id
    connection: text
    queue: text
    payload: longText
    exception: longText
    failed_at:
      type: timestamp
      useCurrent: true
```

Excecute `php artisan dacapo`, 3 files are generated and migrate fresh.

- [database/migrations/1970_01_01_000000_create_users_table.php](tests/Storage/laravel70_default/migrations/1970_01_01_000000_create_users_table.php)
- [database/migrations/1970_01_01_000000_create_failed_jobs_table.php](tests/Storage/laravel70_default/migrations/1970_01_01_000000_create_failed_jobs_table.php)

## Tips

### Generate Laravel 5.0 〜 5.6 schema.yml

```
$ php artisan dacapo:init --laravel50
```

- [database/migrations/1970_01_01_000000_create_users_table.php](tests/Storage/laravel50_default/migrations/1970_01_01_000000_create_users_table.php)
- [database/migrations/1970_01_01_000000_create_password_resets_table.php](tests/Storage/laravel50_default/migrations/1970_01_01_000000_create_password_resets_table.php)

### Generate Laravel 5.7 〜 5.8 schema.yml

```
$ php artisan dacapo:init --laravel57
```

- [database/migrations/1970_01_01_000000_create_users_table.php](tests/Storage/laravel57_default/migrations/1970_01_01_000000_create_users_table.php)
- [database/migrations/1970_01_01_000000_create_password_resets_table.php](tests/Storage/laravel57_default/migrations/1970_01_01_000000_create_password_resets_table.php)

### Generate Laravel 6.x schema.yml

```
$ php artisan dacapo:init --laravel57
```

- [database/migrations/1970_01_01_000000_create_users_table.php](tests/Storage/laravel60_default/migrations/1970_01_01_000000_create_users_table.php)
- [database/migrations/1970_01_01_000000_create_password_resets_table.php](tests/Storage/laravel60_default/migrations/1970_01_01_000000_create_password_resets_table.php)
- [database/migrations/1970_01_01_000000_create_failed_jobs_table.php](tests/Storage/laravel60_default/migrations/1970_01_01_000000_create_failed_jobs_table.php)

### Generate template models from schema.yml

```
$ php artisan dacapo:models
```
