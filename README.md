[![Build Status](https://travis-ci.org/morilog/jalali.svg?branch=master)](https://travis-ci.org/morilog/jalali)
morilog/jalali
======
- This package compatible with Laravel `>=5` & `< 6.0`

- This package was forked from [Miladr/Jalali](http://github.com/miladr/jalai) in previous version and fixed bugs a

- Jalali calendar is a solar calendar that was used in Persia, variants of which today are still in use in Iran as well as Afghanistan. [Read more on Wikipedia](http://en.wikipedia.org/wiki/Jalali_calendar) or see [Calendar Converter](http://www.fourmilab.ch/documents/calendar/).

- Calendar conversion is based on the [algorithm provided by Kazimierz M. Borkowski](http://www.astro.uni.torun.pl/~kb/Papers/EMP/PersianC-EMP.htm) and has a very good performance.

- jDateTime class was ported from [jalaali/jalaali-js](https://github.com/jalaali/jalaali-js)

## Installation Version 2.0
> If you are using version < 2.0, please read [old docs](https://github.com/morilog/jalali/blob/v1.1/README.md)

Run the Composer update comand

    $ composer require morilog/jalali

In your `config/app.php` add `'Morilog\Jalali\JalaliServiceProvider'` to the end of the `$providers` array

```php
'providers' => [

    Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
    Illuminate\Auth\AuthServiceProvider::class,
    ...
    Morilog\Jalali\JalaliServiceProvider::class,

],


'alias' => [
    ...
    'jDate' => Morilog\Jalali\Facades\jDate::class
]
```

<a name="basic-usage"></a>
## Basic Usage

### jDate
In version >= 1.1,  You can use `jdate()` instead of `jDate::forge()`;
#### `forge([$str = ''])`
``` php
// default timestamp is now
$date = \Morilog\Jalali\jDate::forge();
// OR
$date = jdate();

// pass timestamps
$date = jDate::forge(1333857600);
// OR
$date = jdate(1333857600);

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
$date = jDate::forge('now - 10 minutes')->ago() // 10 دقیقه پیش
// OR
$date = jdate('now - 10 minutes')->ago() // 10 دقیقه پیش
```

### jDateTime
---


#### `checkDate($year, $month, $day, [$isJalali = true])`
```php
// Check jalali date
\Morilog\Jalali\jDateTime::checkDate(1391, 2, 30, true); // true

// Check jalali date
\Morilog\Jalali\jDateTime::checkDate(2016, 5, 7); // false

// Check gregorian date
\Morilog\Jalali\jDateTime::checkDate(2016, 5, 7, false); // true
```
---
#### `toJalali($gYear, $gMonth, $gDay)`
```php
\Morilog\Jalali\jDateTime::toJalali(2016, 5, 7); // [1395, 2, 18]
```
---
#### `toGregorian($jYear, $jMonth, $jDay)`
```php
\Morilog\Jalali\jDateTime::toGregorian(1395, 2, 18); // [2016, 5, 7]
```
---
#### `strftime($format, [$timestamp = false])`
```php
jDateTime::strftime('Y-m-d', strtotime('2016-05-8'); // 1395-02-19
```
---
#### `createDateTimeFromFormat($format, $jalaiTimeString)`
```php
$jdate = '1394/11/25 15:00:00';

// get instance of \DateTime
$dateTime = \Morilog\Jalali\jDatetime::createDatetimeFromFormat('Y/m/d H:i:s', $jdate);

```
---
#### `createCarbonFromFormat($format, $jalaiTimeString)`
```php
$jdate = '1394/11/25 15:00:00';

// get instance of \Carbon\Carbon
$carbon = \Morilog\Jalali\jDatetime::createDatetimeFromFormat('Y/m/d H:i:s', $jdate);

```
---
#### `convertNumbers($string)`
```php
$date = \Morilog\Jalali\jDateTime::strftime('Y-m-d', strtotime('2016-05-8'); // 1395-02-19
\Morilog\Jalali\jDateTime::convertNumbers($date); // ۱۳۹۵-۰۲-۱۹
```
---
## Formatting ##

For help in building your formats, checkout the [PHP strftime() docs](http://php.net/manual/en/function.strftime.php).

## Notes ##

The class relies on ``strtotime()`` to make sense of your strings, and ``strftime()`` to make the format changes.  Just always check the ``time()`` output to see if you get false timestamps... which means the class couldn't understand what you were telling it.

## License ##
- This bundle is created based on [Laravel-Date](https://github.com/swt83/laravel-date) by [Scott Travis](https://github.com/swt83) (MIT Licensed).
- [Jalali (Shamsi) DateTime](https://github.com/sallar/jDateTime) class included in the package is created by [Sallar Kaboli](http://sallar.me) and is released under the MIT License.
-  This package was created and modified by [Morteza Parvini](http://morilog.ir) for Laravel >= 5 and is released under the MIT License.
