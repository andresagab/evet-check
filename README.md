<h1 style="color: #1d9ad0;">RESSEEDS-APP</h1>

## Requirements 📝

- Relational database, preferably MySQL or PostgreSQL
- PHP 8.1 interpreter
- Composer

<i>Note: for developers is necessary use npm to install js dependencies</i>

## Installation and Usage 💻

Run next commands in your command prompt to install and execute this web app:

```sh
# clone repository
git clone
cd resseeds-app

# install php dependencies
composer install

# setup .env file
cp .env.example .env
# generate laravel app key
php artisan key:generate
# setup .env file

# install node dependencies
npm install

# run migrations
php artisan migrate
# run seeds
php artisan db:seed

# start server
php artisan serve
npm run dev
```
