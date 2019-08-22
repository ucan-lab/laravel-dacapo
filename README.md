# Laravel-Dacapo

[![Latest Stable Version](https://poser.pugx.org/ucan-lab/laravel-dacapo/v/stable)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Total Downloads](https://poser.pugx.org/ucan-lab/laravel-dacapo/downloads)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Latest Unstable Version](https://poser.pugx.org/ucan-lab/laravel-dacapo/v/unstable)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![License](https://poser.pugx.org/ucan-lab/laravel-dacapo/license)](https://packagist.org/packages/ucan-lab/laravel-dacapo)

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
