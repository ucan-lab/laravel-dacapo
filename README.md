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
By default, a schema file for Laravel8 is generated.

```yaml
users:
  columns:
    id: bigIncrements
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

password_resets:
  columns:
    email:
      type: string
      index: true
    token: string
    created_at:
      type: timestamp
      nullable: true

failed_jobs:
  columns:
    id: true
    uuid:
      type: string
      unique: true
    connection: text
    queue: text
    payload: longText
    exception: longText
    failed_at:
      type: timestamp
      useCurrent: true
```

### Generate migration files

```
$ php artisan dacapo
```

3 files are generated and migrate fresh.

- 1970_01_01_000001_create_failed_jobs_table.php
- 1970_01_01_000001_create_password_resets_table.php
- 1970_01_01_000001_create_users_table.php
