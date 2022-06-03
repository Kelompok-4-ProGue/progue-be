# ![Progue Light Logo](public/progue-logo.svg)

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation#installation)

Clone the repository

    git clone git@github.com:Kelompok-4-ProGue/progue-be.git

Switch to the repo folder

    cd progue-be

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Generate a new Passport authentication secret key

    php artisan passport:install

Link storage folder so it can be accessed

    php artisan storage:link

**optional (on server)

Set group permission on vendor & storage folder

    chown -R www-data:www-data /path/to/your/project/vendor
    sudo chown -R www-data:www-data /path/to/your/project/storage

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:Kelompok-4-ProGue/progue-be.git
    cd progue-be
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan passport:install
    php artisan storage:link
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes province, city, permission groups, etc. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    
## Docker

- update soon

## API Documentation

> [Full API Doc](https://documenter.getpostman.com/view/10035045/Uz5GmvCq)

----------

# Code overview

## Dependencies

- update soon

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers` - Contains all the api controllers
- `app/Http/Middleware` - Contains the Passport auth middleware
- `app/Http/Requests` - Contains all the api form requests
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**           | **Value**         |
|---------------|-------------------|-------------------|
| Yes      	    | Content-Type     	| application/json 	|
| Yes      	    | X-Requested-With 	| XMLHttpRequest   	|
| Optional 	    | Authorization    	| Token {Passport}  |

Refer the [api specification](#api-specification) for more info.

----------
 
# Authentication
 
This applications uses Laravel Passport to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The Laravel Passport authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about Laravel Passport.
 
- https://laravel.com/docs/9.x/passport

----------