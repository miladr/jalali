[![Build Status](https://travis-ci.org/morilog/jalali.svg?branch=master)](https://travis-ci.org/morilog/jalali)
morilog/jalali
======
- Jalali calendar is a solar calendar that was used in Persia, variants of which today are still in use in Iran as well as Afghanistan. [Read more on Wikipedia](http://en.wikipedia.org/wiki/Jalali_calendar) or see [Calendar Converter](http://www.fourmilab.ch/documents/calendar/).

- Calendar conversion is based on the [algorithm provided by Kazimierz M. Borkowski](http://www.astro.uni.torun.pl/~kb/Papers/EMP/PersianC-EMP.htm) and has a very good performance.

- CalendarUtils class was ported from [jalaali/jalaali-js](https://github.com/jalaali/jalaali-js)

## Installation Version 3.*
> If you are using version <= 2.*, please read [old docs](https://github.com/morilog/jalali/blob/v2.3.0/README.md)
#### Requirements:
- `php >= 7.0`

Run the Composer update comand

    $ composer require morilog/jalali:3.*

<a name="basic-usage"></a>
## Basic Usage
In current version i introduced `Jalalian` class for manipulating jalali date time
### Jalalian
In version >= 1.1,  You can use `jdate()` instead of `Jalalian::forge()`;
#### `now([$timestamp = null])`
``` php
// default timestamp is now
$date = \Morilog\Jalali\Jalalian::now()
// OR
$date = jdate();

// pass timestamps
$date = Jalalian::forge(1333857600);
// OR
$date = jdate(1333857600);

// pass strings to make timestamps
$date = Jalalian::forge('last sunday');

// get the timestamp
$date = Jalalian::forge('last sunday')->getTimestamp(); // 1333857600
سسس
// format the timestamp
$date = Jalalian::forge('last sunday')->format('%B %d، %Y'); // دی 02، 1391

// get a predefined format
$date = Jalalian::forge('last sunday')->format('datetime'); // 1391-10-02 00:00:00
$date = Jalalian::forge('last sunday')->format('date'); // 1391-10-02
$date = Jalalian::forge('last sunday')->format('time'); // 00:00:00

// amend the timestamp value, relative to existing value
$date = Jalalian::forge('2012-10-12')->reforge('+ 3 days')->format('date'); // 1391-07-24

// get relative 'ago' format
$date = Jalalian::forge('now - 10 minutes')->ago() // 10 دقیقه پیش
// OR
$date = Jalalian::forge('now - 10 minutes')->ago() // 10 دقیقه پیش
```

#### Methods api
---
```php

public static function now(\DateTimeZone $timeZone = null): Jalalian
public static function fromCarbon(Carbon $carbon): Jalalian
public static function fromFormat(string $format, string $timestamp, \DateTimeZone $timeZone = null): Jalalian
public static function forge($timestamp, \DateTimeZone $timeZone = null): Jalalian
public static function fromDateTime($dateTime, \DateTimeZone $timeZone = null): Jalalian
public function getMonthDays()
public function getMonth(): int
public function isLeapYear(): bool
public function getYear()
public function subMonths(int $months = 1): Jalalian
public function subYears(int $years = 1): Jalalian
public function getDay(): int
public function getHour(): int
public function getMinute(): int
public function getSecond(): int
public function getTimezone(): \DateTimeZone
public function addMonths(int $months = 1): Jalalian
public function addYears(int $years = 1): Jalalian
public function getDaysOf(int $monthNumber = 1): int
public function addDays(int $days = 1): Jalalian
public function toCarbon(): Carbon
public function subDays(int $days = 1): Jalalian
public function addHours(int $hours = 1): Jalalian
public function subHours(int $hours = 1): Jalalian
public function addMinutes(int $minutes = 1): Jalalian
public function subMinutes(int $minutes = 1): Jalalian
public function addSeconds(int $secs = 1): Jalalian
public function subSeconds(int $secs = 1): Jalalian
public function equalsTo(Jalalian $other): bool
public function equalsToCarbon(Carbon $carbon): bool
public function greaterThan(Jalalian $other): bool
public function greaterThanCarbon(Carbon $carbon): bool
public function lessThan(Jalalian $other): bool
public function lessThanCarbon(Carbon $carbon): bool
public function greaterThanOrEqualsTo(Jalalian $other): bool
public function greaterThanOrEqualsToCarbon(Carbon $carbon): bool
public function lessThanOrEqualsTo(Jalalian $other): bool
public function lessThanOrEqualsToCarbon(Carbon $carbon): bool
public function isStartOfWeek(): bool
public function isSaturday(): bool
public function isDayOfWeek(int $day): bool
public function isEndOfWeek(): bool
public function isFriday(): bool
public function isToday(): bool
public function isTomorrow(): bool
public function isYesterday(): bool
public function isFuture(): bool
public function isPast(): bool
public function toArray(): array
public function getDayOfWeek(): int
public function isSunday(): bool
public function isMonday(): bool
public function isTuesday(): bool
public function isWednesday(): bool
public function isThursday(): bool
public function getDayOfYear(): int
public function toString(): string
public function format(string $format): string
public function __toString(): string
public function ago(): string
public function getTimestamp(): int
public function getNextWeek(): Jalalian
public function getNextMonth(): Jalalian
```

### CalendarUtils
---


#### `checkDate($year, $month, $day, [$isJalali = true])`
```php
// Check jalali date
\Morilog\Jalali\CalendarUtils::checkDate(1391, 2, 30, true); // true

// Check jalali date
\Morilog\Jalali\CalendarUtils::checkDate(2016, 5, 7); // false

// Check gregorian date
\Morilog\Jalali\CalendarUtils::checkDate(2016, 5, 7, false); // true
```
---
#### `toJalali($gYear, $gMonth, $gDay)`
```php
\Morilog\Jalali\CalendarUtils::toJalali(2016, 5, 7); // [1395, 2, 18]
```
---
#### `toGregorian($jYear, $jMonth, $jDay)`
```php
\Morilog\Jalali\CalendarUtils::toGregorian(1395, 2, 18); // [2016, 5, 7]
```
---
#### `strftime($format, [$timestamp = false, $timezone = null])`
```php
CalendarUtils::strftime('Y-m-d', strtotime('2016-05-8')); // 1395-02-19
```
---
#### `createDateTimeFromFormat($format, $jalaiTimeString)`
```php
$Jalalian = '1394/11/25 15:00:00';

// get instance of \DateTime
$dateTime = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', $Jalalian);

```
---
#### `createCarbonFromFormat($format, $jalaiTimeString)`
```php
$Jalalian = '1394/11/25 15:00:00';

// get instance of \Carbon\Carbon
$carbon = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $Jalalian);

```
---
#### `convertNumbers($string)`
```php
// convert latin to persian
$date = \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime('2016-05-8'); // 1395-02-19
\Morilog\Jalali\CalendarUtils::convertNumbers($date); // ۱۳۹۵-۰۲-۱۹

// convert persian to latin
$dateString = \Morilog\Jalali\CalendarUtils::convertNumbers('۱۳۹۵-۰۲-۱۹', true); // 1395-02-19
\Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y-m-d', $dateString)->format('Y-m-d'); //2016-05-8
```

---
## Formatting ##

For help in building your formats, checkout the [PHP strftime() docs](http://php.net/manual/en/function.strftime.php).

## Notes ##

The class relies on ``strtotime()`` to make sense of your strings, and ``strftime()`` to make the format changes.  Just always check the ``time()`` output to see if you get false timestamps... which means the class couldn't understand what you were telling it.

## License ##
- This bundle is created based on [Laravel-Date](https://github.com/swt83/laravel-date) by [Scott Travis](https://github.com/swt83) (MIT Licensed).
- [Jalali (Shamsi) DateTime](https://github.com/sallar/CalendarUtils) class included in the package is created by [Sallar Kaboli](http://sallar.me) and is released under the MIT License.
-  This package was created and modified by [Morteza Parvini](http://morilog.ir) for Laravel >= 5 and is released under the MIT License.
