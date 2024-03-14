# Meow Inventory

A demo application to illustrate how Meow Inventory works.

## Installation

Clone the repo locally:

```sh
git clone https://github.com/meowdevv/meow-inventory.git meow-inventory && cd meow-inventory
```

Install PHP dependencies:

```sh
composer install
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Run database migrations:

```sh
php artisan migrate
```

Create a symlink to the storage:

```sh
php artisan storage:link
```

Create an admin user:

```sh
php artisan make:filament-user
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

Let's connect with me on [instagram](https://instagram.com/mframadann)!
