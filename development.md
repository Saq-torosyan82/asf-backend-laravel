# Development info #

## Setup environment

Step 1: check the requirements for PHP 8 - https://apiato.io/docs

Step 2: pull the code from repository

Step 3: create laravel folders
```
mkdir storage/framework
mkdir storage/framework/sessions
mkdir storage/framework/views
mkdir storage/framework/cache
```
Step 4: composer install

Step 5: setup DB connection

Step 6: run migrations
```
php artisan migrate
```
Step 7: run seeders
```
php artisan db:seed
```
Step 8: create admin role
```
php artisan apiato:permissions:toRole admin
```
Step 9: install passport
```
php artisan passport:install
```
Get the second client values and set in .eng 
```
CLIENT_WEB_ID=
CLIENT_WEB_SECRET=

CLIENT_MOBILE_ID=
CLIENT_MOBILE_SECRET=
```

Step 10: install packages for generate API documentation
```
npm install
```
    
