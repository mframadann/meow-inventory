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

Run database seeder:

```sh
php artisan db:seed
```

Create a symlink to the storage:

```sh
php artisan storage:link
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit the url in your browser, and login with:

-   **Username:** meowadmin@meow.dev
-   **Password:** password

Let's connect with me on [instagram](https://instagram.com/mframadann)!
