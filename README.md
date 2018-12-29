# Seo Manager Package for Laravel

`lionix/seo-manager` package will provide 
you an interface from where you can manage all your pages
meta data separately and get dynamically changing content.
Let's see how.

## Installation
You can install the package via composer:

```bash
composer require lionix/seo-manager
```
Publishing package files
```bash
php artisan vendor:publish --provider="Lionix\SeoManager\SeoManagerServiceProvider"
```
This command will create `config/seo-manager.php` 
file and will copy package assets directory to `public/vendor/lionix`.

#### Configurations

In `config/seo-manager.php` file you can do following configurations:

```php
return [
    /**
     * Database table name where your manager data will be stored
     */
    'database' => [
        'table' => 'seo_manager'
    ],

    /**
     * Path where your eloquent models are
     */
    'models_path' => '',

    /**
     * Route from which your Dashboard will be available
     */
    'route' => 'seo-manager',

    /**
     * Middleware array for dashboard
     * to prevent unauthorized users visit the manager
     */
    'middleware' => [
        //  'auth',
    ],

    /**
     * Routes which shouldn't be imported to seo manager
     */
    'except_routes' => [
        'seo-manager',
        'admin'
        //
    ],

    /**
     * Columns which shouldn't be used ( in mapping )
     */
    'except_columns' => [
        // "created_at",
        // "updated_at",
    ],

    /**
     * Set this parameter to true
     * if you want to have "$metaData" variable
     * shared between all views in "web" middleware group
     */
    'shared_meta_data' => false
];
```

After finishing with all configurations run `php artisan migrate` to create seo manager table.

That's it, now your seo manager will be available 
from /seo-manager url (or,if you changed route config, 
by that config url) 

## Usage

After visiting your dashboard url you have to import your routes to start manage them.

![routes import](https://lh6.googleusercontent.com/YSbFt8jvV6swodjBE4xi6UCP0h6sNxw01kEhg7YueMnsuIQxmeWoEjBagiY=w2400)

Route importing will store all your GET routes into database ( except the ones which specified in "except_routes" configs).

![imported routes](https://lh5.googleusercontent.com/Dn-tuphYqMN9bmN_WzcWmTgOCzuzg3m3_TcWlzbb7Nf7zbVHrHTBkXc4O4E=w2400)

### Let the fun begin! 

**Mapping**

![](https://lh4.googleusercontent.com/fxvoOPQUG9GNiOqAj6C2z7_ZolMMJSV-53M_Q6sPqt3fp1TdYp-9blL3DQ8=w2400)

To get dynamically changing meta data you should map your route params to the correct Models.

*Param: Route param*

*Model: Eloquent Model which you are using to get record by route param*

*Find By: Database table column name which you are using to get record by route param*

*Use Columns: Database table columns which we should use for further mapping*




