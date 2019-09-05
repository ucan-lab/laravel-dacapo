# Laravel-Dacapo

[![Build Status](https://travis-ci.org/ucan-lab/laravel-dacapo.svg?branch=master)](https://travis-ci.org/ucan-lab/laravel-dacapo)
[![Latest Stable Version](https://poser.pugx.org/ucan-lab/laravel-dacapo/v/stable)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Total Downloads](https://poser.pugx.org/ucan-lab/laravel-dacapo/downloads)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Monthly Downloads](https://poser.pugx.org/ucan-lab/laravel-dacapo/d/monthly)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Daily Downloads](https://poser.pugx.org/ucan-lab/laravel-dacapo/d/daily)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![Latest Unstable Version](https://poser.pugx.org/ucan-lab/laravel-dacapo/v/unstable)](https://packagist.org/packages/ucan-lab/laravel-dacapo)
[![License](https://poser.pugx.org/ucan-lab/laravel-dacapo/license)](https://packagist.org/packages/ucan-lab/laravel-dacapo)

## Installation

```
$ composer require --dev ucan-lab/laravel-dacapo
```

## Generate default schema.yml

`database/schemas/default.yml`

```
$ php artisan dacapo:init
```

### Laravel 5.0 〜 5.6

```
$ php artisan dacapo:init --laravel50
```

### Laravel 5.7 〜 5.8

```
$ php artisan dacapo:init --laravel57
```

## Generate migration files from schema.yml

```
$ php artisan dacapo:generate
```

## Generate template models from schema.yml

```
$ php artisan dacapo:models
```
