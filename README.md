# ShipSaaS Ready - Your SaaS companion

[![Build & Test](https://github.com/shipsaas/ready/actions/workflows/build.yml/badge.svg)](https://github.com/shipsaas/ready/actions/workflows/build.yml)
[![codecov](https://codecov.io/gh/shipsaas/ready/branch/main/graph/badge.svg?token=9GZ7DKTBIJ)](https://codecov.io/gh/shipsaas/ready)
![License of ShipSaas Ready](https://img.shields.io/github/license/shipsaas/ready)
![Status of ShipSaas Ready](https://img.shields.io/badge/Status-WIP%2FIn--development-yellow)

Starting to build a new freaking SaaS product and deliver great features? 

Allow **ShipSaaS Ready** to become your companion along the way! A strong, helpful and reliable companion.

It got you covered with almost every generic (and must-have) things, let's build awesome products on top of it.

[Documentation Here](https://phattranminh96.gitbook.io/shipsaas-ready/)

## Support

### Laravel
- Laravel 9.x
- Laravel 10.x (upcoming)

### PHP

- 8.1
- 8.2

## Features

**ShipSaaS Ready** covers you up with all these things:

- Controllers
- Constants/Enums
- Models
- Helpers (classes or traits)
- Services

For all of these generic entities (more coming uppp 🥳):

- Countries (with data)
- Currencies (with data)
- Languages (with English)
- Translations (dynamic translations)
- Events (event sourcing)

Once you install the ShipSaaS Ready, you got multiple generic entities under your hands, let's build awesome products.

## Installation

### Install the dependency

After hitting the `laravel new your-super-product`, you would install Ready immediately :wink:

```bash
composer require shipsaas/ready
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

## GUI / Web Interface

Since all the things under ShiSaaS Ready is **RESTFul APIs**. No GUI available on this particular repository.

There will be a separate repository for the GUI. Stay tuned!

## Contribute to the project

- All changes must follow PSR-1 / PSR-12 coding conventions.
- Unit testing is a must, cover things as much as you can.

## This library is useful?

Thank you, please give it a ⭐️⭐️⭐️ to support the project.

Don't forget to share with your friends & colleagues, so they can also build their own SaaS products as well 🚀

### Maintainers & Contributors

- Seth Phat

Join me :wink:

## ChangeLog

Visit: [CHANGELOG](./CHANGELOG.md)

## License

Copyright &copy; by Seth Phat / ShipSaaS 2022 - Under MIT License.
