miladr/jalali
======

This Package helps developers to easily work with Jalali (Shamsi or Iranian) dates in Laravel 4 applications, based on Jalali (Shamsi) DateTime class. This Package is based on a Laravel 3 bundle [sallar/laravel-jdate](https://github.com/sallar/laravel-jdate) by [Sallar Kaboli](http://sallar.me).

<a name="installation"></a>
## Installation

In the `require` key of `composer.json` file add the following

```yml
    "miladr/jalali": "dev-master"
```

Run the Composer update comand

    $ composer update

In your `config/app.php` add `'Miladr\Jalali\JalaliServiceProvider'` to the end of the `$providers` array

```php
    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        ...
        'Miladr\Jalali\JalaliServiceProvider',

    ),
```

<a name="basic-usage"></a>
## Basic Usage
## Examples ##

Some Examples (based on examples provided by Sallar)

```php
// default timestamp is now
$date = jDate::forge();

// pass timestamps
$date = jDate::forge(1333857600);

// pass strings to make timestamps
$date = jDate::forge('last sunday');

// get the timestamp
$date = jDate::forge('last sunday')->time(); // 1333857600

// format the timestamp
$date = jDate::forge('last sunday')->format('%B %d، %Y'); // دی 02، 1391

// get a predefined format
$date = jDate::forge('last sunday')->format('datetime'); // 1391-10-02 00:00:00
$date = jDate::forge('last sunday')->format('date'); // 1391-10-02
$date = jDate::forge('last sunday')->format('time'); // 00:00:00

// amend the timestamp value, relative to existing value
$date = jDate::forge('2012-10-12')->reforge('+ 3 days')->format('date'); // 1391-07-24

// get relative 'ago' format
$date = jDate::forge('now - 10 minutes')->ago() // ۱۰ دقیقه پیش
```


## Formatting ##

For help in building your formats, checkout the [PHP strftime() docs](http://php.net/manual/en/function.strftime.php).

## Notes ##

The class relies on ``strtotime()`` to make sense of your strings, and ``strftime()`` to make the format changes.  Just always check the ``time()`` output to see if you get false timestamps... which means the class couldn't understand what you were telling it.

## License ##
- This bundle is created based on [Laravel-Date](https://github.com/swt83/laravel-date) by [Scott Travis](https://github.com/swt83) (MIT Licensed).  
- [Jalali (Shamsi) DateTime](https://github.com/sallar/jDateTime) class included in the package is created by [Sallar Kaboli](http://sallar.me) and is released under the MIT License. 
- This package was created by [Milad Rey](http://milad.io) and is released under the MIT License.
