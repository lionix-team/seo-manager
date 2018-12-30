# Seo Manager Package for Laravel

`lionix/seo-manager` package will provide 
you an interface from where you can manage all your pages
metadata separately and get dynamically changing content.
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

In `config/seo-manager.php` file you can do the following configurations:

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

After finishing with all configurations run `php artisan migrate` to create SEO manager table.

That's it, now your SEO manager will be available 
from /seo-manager URL (or, if you changed route config, 
by that config URL) 

## Usage

After visiting your dashboard URL you have to import your routes to start to manage them.

![routes import](https://lh6.googleusercontent.com/YSbFt8jvV6swodjBE4xi6UCP0h6sNxw01kEhg7YueMnsuIQxmeWoEjBagiY=w2400)

Route importing will store all your GET routes into the database ( except the ones which specified in "except_routes" configs).

![imported routes](https://lh5.googleusercontent.com/Dn-tuphYqMN9bmN_WzcWmTgOCzuzg3m3_TcWlzbb7Nf7zbVHrHTBkXc4O4E=w2400)

### Let the fun begin! 

**Mapping**

![](https://lh4.googleusercontent.com/fxvoOPQUG9GNiOqAj6C2z7_ZolMMJSV-53M_Q6sPqt3fp1TdYp-9blL3DQ8=w2400)

To get dynamically changing metadata you should map your route params to the correct Models.

*Param: Route param*

*Model: Eloquent Model which you are using to get the record by route param*

*Find By: Database table column name which you are using to get the record by route param*

*Use Columns: Database table columns which we should use for further mapping*


> **Note**: If you have appended attributes inside your model via `protected $appends` and you want to use them in mapping
you have to use `Lionix\SeoManager\Traits\Appends;` trait inside your model.

*Mapping available only if your route has params*

Next steps you can do, is to set Keywords, Description, Title, URL, Author, Title Dynamic, OpenGraph Data.

**About "Title Dynamic":**

Here you can drag & drop your mapped params, your title and write custom text to generate the dynamic title for your page.
Every time your "title" will be changed or your mapped params value changed, the dynamic title will be changed automatically.

![](https://lh3.googleusercontent.com/VgalM88QnjH8iB9-bEc2iike_14Lb_cF7JEyilBwqBTuuDOfoeJvR-n655M=w2400)

**About "Open Graph":**

Here you can write your open graph data or map your fields to mapping based on params.

![](https://lh6.googleusercontent.com/Z93-NUUKLFOleZbj4oYwfE59MMyGxhu9SHxE-0iAKNwatWHm9w5LfZ_h5rg=w2400)

## Example Usage

## Via `SeoManager` Facade

```php
use Lionix\SeoManager\Facades\SeoManager;
```
##### This will return an array with all your SEO Manager data
```
SeoManager::metaData();
```
*Example:*
```php
array:13 [▼
  "keywords" => "First Keyword, Second, Third"
  "description" => "Test Description"
  "title" => "Test Titile"
  "url" => "http://example.com/users/1"
  "author" => "Sergey Karakhanyan"
  "title_dynamic" => "Test Titile - Custom Text - Test User Name "
  "og:url" => "http://example.com/users/1"
  "og:type" => "website"
  "og:image:url" => "https://wallpaperbrowse.com/media/images/3848765-wallpaper-images-download.jpg"
  "og:title" => "Test Titile - Custom Open Graph Text"
  "og:locale" => "en_GB"
  "og:site_name" => "Seo Manager Package"
  "og:description" => "Open Graph Description"
]
```

`SeoManager::metaData();` method can receive property variable 
to get the value of some property 

*Example:*

`SeoManager::metaData('keywords');` will return  `"First Keyword, Second, Third"`


##### To get only OpenGraph data array: 
```php
SeoManager::metaData('og_data');
```
*Example*

```php
array:7 [▼
  "og:url" => "http://example.com/users/1"
  "og:type" => "website"
  "og:image:url" => "https://wallpaperbrowse.com/media/images/3848765-wallpaper-images-download.jpg"
  "og:title" => "Test Titile - Custom Open Graph Text"
  "og:locale" => "en_GB"
  "og:site_name" => "Seo Manager Package"
  "og:description" => "Open Graph Description"
]
```
##### Aliases
`SeoManager::metaKeywords()`

`SeoManager::metaTitle()`

`SeoManager::metaDescription()`

`SeoManager::metaUrl()`

`SeoManager::metaAuthor()`

`SeoManager::metaTitleDynamic()`

`SeoManager::metaOpenGraph()` - Can receive property variable to get the value of some OG property

*Example*

`SeoManager::metaOpenGraph('og:image:url)`

Will return
`"https://wallpaperbrowse.com/media/images/3848765-wallpaper-images-download.jpg"`


## Via `helper` functions

`metaData()`

`metaKeywords()`

`metaTitle()`

`metaDescription()`

`metaUrl()`

`metaAuthor()`

`metaTitleDynamic()`

`metaOpenGraph()`

## Via @Blade directives

You can use this blade directives in your view files to get metadata. 

`@meta`

*Output Example*

```html
<meta property="keywords" content="First Keyword, Second, Third">
<meta property="description" content="Test Description">
<meta property="title" content="Test Titile">
<meta property="url" content="http://packages.loc/users/1">
<meta property="author" content="Sergey Karakhanyan">
<meta property="title_dynamic" content="Test Titile - Custom Text - Test User Name ">
<meta property="og:url" content="http://packages.loc/users/1">
<meta property="og:type" content="website">
<meta property="og:image:url" content="https://wallpaperbrowse.com/media/images/3848765-wallpaper-images-download.jpg">
<meta property="og:title" content="Test Titile - Custom Open Graph Text">
<meta property="og:locale" content="en_GB">
<meta property="og:site_name" content="Seo Manager Package">
<meta property="og:description" content="Open Graph Description">
```

`@meta` can receive property param

`@meta('description')`

*Output Example*

```html
<meta property="description" content="Test Description">
```
>**Note:**
You can't add open graph properties to `@meta()` like `@meta('og:url')`
But you can get only OpenGraph meta data by `@meta('og_data')`.
If you want to get concrete OG param meta tag you can use `@openGraph` (*similar to `@meta('og_data')`*)
and pass param there like `@openGraph('og:url)`

>**Note #2:** If you want to do modifications in your og data and display it manually, you should do that before `@meta`

*Example:*
```html
<meta property="og:image:url" content="{{ asset(metaOpenGraph('og:image:url')) }}">
@meta
```
##### Aliases

`@keywords`

`@url`

`@author`

`@description`

`@title`

`@openGraph`

`@titleDynamic` - will return dynamically generated title which you can use inside your `<title></title>` tags.



## Credits

- [Sergey Karakhanyan](https://github.com/karakhanyans)
- [Lionix Team](https://github.com/lionix-team)


