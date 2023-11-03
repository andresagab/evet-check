<h1 style="color: #1d9ad0;">EVENT-CHECK</h1>

## Requirements 📝

- Relational database, preferably MySQL or PostgreSQL
- PHP interpreter
- Composer

<i>Note: for developers is necessary use npm to install js dependencies</i>

## Installation and Usage 💻

Run next commands in your command prompt to install and execute this web app:

```sh
# clone repository
git clone
cd event-check

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

# start server
php artisan serve
npm run dev
```
