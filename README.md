morilog/jalali
======
- This package compatible with Laravel 5

- This package was forked from [Miladr/Jalali](http://github.com/miladr/jalai) in previous version and fixed bugs and customized by [Morilog](http://morilog.ir)

<a name="installation"></a>
## Installation

Run the Composer update comand

    $ composer require morilog/jalali

In your `config/app.php` add `'Morilog\Jalali\JalaliServiceProvider'` to the end of the `$providers` array

```php
    'providers' => [

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        ...
        'Morilog\Jalali\JalaliServiceProvider',

    ],
    .
    .
    .
    .
    .
    'alias' => [
        ...
        'jDate' => 'Morilog\Jalali\Facades\jDate',
        'jDateTime' => 'Morilog\Jalali\Facades\jDateTime',
    ]
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

//date_parse_from_format for jalali date
$date = jDate::parseFromFormat('Y/m/d', '1393/01/18');
echo $date['year']; //1393
echo $date['month']; //01
echo $date['day']; //18
```


## Formatting ##

For help in building your formats, checkout the [PHP strftime() docs](http://php.net/manual/en/function.strftime.php).

## Notes ##

The class relies on ``strtotime()`` to make sense of your strings, and ``strftime()`` to make the format changes.  Just always check the ``time()`` output to see if you get false timestamps... which means the class couldn't understand what you were telling it.

## License ##
- This bundle is created based on [Laravel-Date](https://github.com/swt83/laravel-date) by [Scott Travis](https://github.com/swt83) (MIT Licensed).  
- [Jalali (Shamsi) DateTime](https://github.com/sallar/jDateTime) class included in the package is created by [Sallar Kaboli](http://sallar.me) and is released under the MIT License.
- This package was created by [Milad Rey](http://milad.io) and is released under the MIT License.
