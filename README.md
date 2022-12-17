# ShipSaaS Ready - Your SaaS companion

[![Build & Test](https://github.com/shipsaas/ready/actions/workflows/build.yml/badge.svg)](https://github.com/shipsaas/ready/actions/workflows/build.yml)
[![codecov](https://codecov.io/gh/shipsaas/ready/branch/main/graph/badge.svg?token=9GZ7DKTBIJ)](https://codecov.io/gh/shipsaas/ready)
![License of ShipSaas Ready](https://img.shields.io/github/license/shipsaas/ready)
![Status of ShipSaas Ready](https://img.shields.io/badge/Status-WIP%2FIn--development-yellow)

Starting to build a new freaking SaaS product and deliver great features? 

Allow **ShipSaaS Ready** to become your companion along the way! Strong, helpful and reliable companion.

It got you covered with almost every generic things, let's build awesome products on top of it.

Documentation: (coming soon)

## Support

### Laravel
- Laravel 9.x
- Laravel 10.x (upcoming)

### PHP
PHP 8.1+

## Features

**ShipSaaS Ready** covers you up with all these things:

- Controllers
- Constants/Enums
- Models
- Helpers (classes or traits)
- Services

For all of these generic entities:

- Countries (with data) - ✅
- Currencies (with data) - ✅
- Languages (with English) - ✅
- Translations (dynamic translations)
- Events (event sourcing) - ✅
- Files
- Roles & Permissions (role-based)
- ...

Once you install the ShipSaaS Ready, you got multiple generic under your hands, let's build awesome products.

## Installation

### Install the dependency

After hitting the `laravel new your-super-product`, you would install Ready immediately :wink:

```bash
composer require sethsandaru/laravel-saas-ready
```

### Publish the configuration

Export the `config` file to change your desired configurations of ShipSaas Ready

```bash
php artisan vendor:publish --tag=saas-ready
```

### First-time boot

```bash
php artisan migrate
```

### GUI

Since all the things under Shi[SaaS Ready is RESTFul APIs. No GUI available on this particular repository.

There will be a separate repository for the GUI. Stay tuned!

## Contribute to the project

- All changes must follow PSR-1 / PSR-12 coding conventions
- Unit testing is a must, cover things as much as you can

### Maintainers

- Seth Phat
- ??

### Contributors

Join me :wink:

## License

Copyright &copy; by Seth Phat 2022 - Under MIT License.
