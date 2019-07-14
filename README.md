# Laravel-Dacapo

## Installation

```
$ composer require --dev ucan-lab/laravel-dacapo
```

## Publish the schema file

```
$ php artisan vendor:publish --provider="UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider"
```

## Generate migration files from schema.yml

```
$ php artisan dacapo:generate
```

## Laravel <= 5.6.x

### schema.yml

```
users:
  timestamps: true
  rememberToken: true
  columns:
    id: increments
    name:
      type: string
    email:
      type: string
      unique: true
      nullable: true
    password:
      type: string

password_resets:
  columns:
    email:
      type: string
      index: true
    token:
      type: string
    created_at:
      type: timestamp
      nullable: true
```
