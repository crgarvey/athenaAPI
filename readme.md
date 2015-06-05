# athena API

## Overview

The athena API acts as a data warehouse and processing infrastructure that allows for API calls to manipulate & retrieve
data from the game server securely.

## Authors
Robbie Vaughn

## Requirements

* Laravel 5 requirements
* Composer
* PHP version >=5.4
* Apache 2.x

## Installation
This needs to be updated further.

### Apache Virtual Host
* Please set your DocumentRoot to `/path/to/here/public` (public-folder).

### Composer
* Install Composer via [these instructions](https://getcomposer.org/download/). To easily install, run `curl -sS https://getcomposer.org/installer | php -- --filename=composer`
* Depending on the filename of Composer, run `php composer install`
* This will install all dependencies including Laravel.

### Permissions
* To ensure permissions are correct for logging purposes, run `sudo chmod 0755 ./storage/logs`

### Database environments
There's two database environments:
* Game: *athena game tables
* API: API tables

Create a schema for the API tables in your MySQL server. You'll want to run the migration files via `php artisan migrate`.

### Configuration (.env)
* You'll need to configure your .env file. This is utilized to store all configurations.
* On a *nix environment, use `cp .env.example .env` and configure the file. Basically, make a copy of the example env.
* **PRODUCTION: Make sure the env has APP_DEBUG disabled and the environment set at production**

### Laravel
* Run `php artisan cache:clear` (or: `./vendor/bin/artisan`) to clear the cache.

### Database set-up
* To run all migrations and get up to speed, run `php artisan migrate`.

### (Test environment only) Configure an user ID / key & test the environment is working!
* In API DB table user, run the following query `INSERT INTO user (`id`, `key`) VALUES ('test', 'test')`. Then, on the user_ip table run `INSERT INTO user_ip (user_id, `ip`) VALUES ('test', '127.0.0.1')`
* Then, visit the your API by local domain name (ex: http://mytestenvironment.dev/ping?apiUser=test&apiKey=test).