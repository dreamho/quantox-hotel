Quantox Hotel

Requirements
- PHP (versions PHP 5.6>=)
- Apache
- Mysql
- Composer
- Enabled mod_rewrite

Installing

- git clone https://github.com/dreamho/quantox-hotel.git
- sudo cp .env.example .env 
- set up database credentials in .env file
- composer install
- php artisan key:generate
- php migrate --seed
- php artisan serve
  
 Setting up JWT Token-based Authentication
- composer require tymon/jwt-auth
- In the config/app.php add the following lines
'providers' => [

    'Tymon\JWTAuth\Providers\JWTAuthServiceProvider',
],
'aliases' => [

    'JWTAuth' => 'Tymon\JWTAuth\Facades\JWTAuth',
        'JWTFactory' => 'Tymon\JWTAuth\Facades\JWTFactory',
]
- php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"
- php artisan jwt:generate


Implemented functionalities:

- Register and login system for users with multiple roles base on JWT Authentication
- Only users with certain roles(admin and dj) can implement CRUD methods on songs