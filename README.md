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
# run seeds
php artisan db:seed

# INDEPENDENT SEEDERS ONLY FOR FIRST TIME

# run EventSeeder
# before config .env file at 'APP_MAIN_EVENT_*' keys, after run:
php artisan db:seed EventSeeder

# run ActivitySeeder
php artisan db:seed ActivitySeeder

# run PersonSeeder

/*
before setup put json file into 'public/assets/json', the data file should have the next keys:

names
surnames
nuip
cel
phone
email
institution_name
other_institution
participation_modality
type
stay_type
payment_status
*/

# next, setup .env file at 'APP_PERSON_DATA_PATH' with file path ('json\{file_name}.json')
# next run seeder
php artisan db:seed PersonSeeder

# start server
php artisan serve
npm run dev
```
