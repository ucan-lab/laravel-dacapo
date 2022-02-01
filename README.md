# Laravel-Dacapo

[![Build Status](https://travis-ci.org/ucan-lab/laravel-dacapo.svg?branch=master)](https://travis-ci.org/ucan-lab/laravel-dacapo)
[![Latest Stable Version](https://poser.pugx.org/ucan-lab/laravel-dacapo/v/stable)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Total Downloads](https://poser.pugx.org/ucan-lab/laravel-dacapo/downloads)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Daily Downloads](https://poser.pugx.org/ucan-lab/laravel-dacapo/d/daily)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
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

#### Dacapo Option

```
# Execute migrate and seeding
$ php artisan dacapo --seed
```

```
# Do not execute migrate
$ php artisan dacapo --no-migrate
```

### Schema file format

- `{}` any value
- `database/schemas/*.yml`
- If it cannot be expressed in YAML, it can be used together with standard migration.
  - `php artisan make:migration`

```
# COMMENT
{TableName}:
  columns:
    {ColumnName}: {ColumnType}
    {ColumnName}:
      type: {ColumnType}
    {ColumnName}:
      unique: true
      nullable: true
      default: {DefaultValue}
      comment: {ColumnName}
      {ColumnModifier}: {ColumnModifierValue}
  indexes:
    - columns: {ColumnName}
      type: {IndexType}
    - columns: [{ColumnName}, {ColumnName}]
      type: {IndexType}
    - columns: {ColumnName}
      type: {IndexType}
      name: {IndexName}
  foreign_keys:
    - columns: {ColumnName}
      references: {ReferenceColumnName}
      table: {ReferenceTableName}
    - columns: {ColumnName}
      references: {ReferenceColumnName}
      table: {ReferenceTableName}
      onUpdate: {ConstraintProperty}
      onDelete: {ConstraintProperty}
    - columns: [{ColumnName}, {ColumnName}]
      references: [{ReferenceColumnName}, {ReferenceColumnName}]
      table: {ReferenceTableName}

{TableName}:
  columns:
    {ColumnName}: {ColumnType}
```

### Dacapo Clear Migrations

```
$ php artisan dacapo:clear
$ php artisan dacapo:clear --all
```

- `--all` Delete including standard migration files.

### Dacapo Stub publish

```
$ php artisan dacapo:stub:publish
```

### Dacapo Uninstall

```
$ php artisan dacapo:uninstall
$ composer remove --dev ucan-lab/laravel-dacapo
```
