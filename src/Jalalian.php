<?php

namespace Morilog\Jalali;

use Assert\Assertion;
use Carbon\Carbon;

class Jalalian
{
    /**
     * @var int
     */
    private $year;

    /**
     * @var int
     */
    private $month;

    /**
     * @var int
     */
    private $day;

    /**
     * @var int
     */
    private $hour;

    /**
     * @var int
     */
    private $minute;

    /**
     * @var int
     */
    private $second;

    /**
     * @var \DateTimeZone
     */
    private $timezone;

    public function __construct(
        int $year,
        int $month,
        int $day,
        int $hour = 0,
        int $minute = 0,
        int $second = 0,
        \DateTimeZone $timezone = null
    ) {

        Assertion::between($year, 1000, 3000);
        Assertion::between($month, 1, 12);
        Assertion::between($day, 1, 31);

        if ($month > 6) {
            Assertion::between($day, 1, 30);
        }

        if (!CalendarUtils::isLeapJalaliYear($year) && $month === 12) {
            Assertion::between($day, 1, 29);
        }
        Assertion::between($hour, 0, 24);
        Assertion::between($minute, 0, 59);
        Assertion::between($second, 0, 59);

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
        $this->timezone = $timezone;
    }

    public static function now(\DateTimeZone $timeZone = null)
    {
        return static::fromCarbon(Carbon::now($timeZone));
    }

    /**
     * @param Carbon $carbon
     * @return Jalalian
     */
    public static function fromCarbon(Carbon $carbon)
    {
        $jDate = CalendarUtils::toJalali($carbon->year, $carbon->month, $carbon->day);

        return new static($jDate[0], $jDate[1], $jDate[2], $carbon->hour, $carbon->minute, $carbon->second,
            $carbon->getTimezone());
    }

    /**
     * @param \DateTimeInterface| string $dateTime
     * @return Jalalian
     */
    public static function fromDateTime($dateTime)
    {
        return static::fromCarbon(new Carbon($dateTime));
    }

    public static function fromFormat(string $format, string $timestamp, \DateTimeZone $timeZone = null)
    {
        return static::fromCarbon(CalendarUtils::createCarbonFromFormat($format, $timestamp, $timeZone));
    }

    public function addYears(int $years = 1)
    {
        Assertion::greaterOrEqualThan($years, 1);

        return new static(
            $this->getYear() + $years,
            $this->getMonth(),
            $this->getDay(),
            $this->getHour(),
            $this->getMinute(),
            $this->getSecond(),
            $this->getTimezone()
        );
    }

    public function addMonths(int $months = 1)
    {
        Assertion::greaterOrEqualThan($months, 1);

        $years = (int)($months / 12);
        $date = $years > 0 ? $this->addYears($years) : clone $this;

        $months = ($months % 12) + $date->getMonth();
        $days = 0;

        for ($i = $date->getMonth() + 1; $i <= $months; $i++) {
            $days += $date->getDaysOf($i);
            if ($i === 12) {
                $i = 1;
                $months = $months - 12;
            }
        }


        return $date->addDays($days);
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return int
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @return int
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @return int
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @return \DateTimeZone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    public function getMonthDays()
    {
        if ($this->getMonth() <= 6) {
            return 31;
        }

        if ($this->getMonth() < 12 || $this->isLeapYear()) {
            return 30;
        }

        return 29;
    }

    public function isLeapYear(): bool
    {
        return CalendarUtils::isLeapJalaliYear($this->getYear());
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    public function subYears(int $years = 1)
    {
        Assertion::greaterOrEqualThan($years, 1);

        return new static(
            $this->getYear() - $years,
            $this->getMonth(),
            $this->getDay(),
            $this->getHour(),
            $this->getMinute(),
            $this->getSecond(),
            $this->getTimezone()
        );
    }

    /**
     * @return Carbon
     */
    public function toCarbon()
    {
        $gDate = CalendarUtils::toGregorian($this->getYear(), $this->getMonth(), $this->getDay());
        $carbon = Carbon::createFromDate($gDate[0], $gDate[1], $gDate[2], $this->getTimezone());

        $carbon->setTime($this->getHour(), $this->getMinute(), $this->getSecond());

        return $carbon;
    }

    public function subMonths(int $months = 1)
    {
        Assertion::greaterOrEqualThan($months, 1);

        $years = (int)($months / 12);
        $date = $years > 0 ? $this->subYears($years) : clone $this;

        $diff = abs($this->getMonth() - $months + 12);

        return $date->subYears(1)->addMonths($diff);
    }

    public function subDays(int $days = 1)
    {
        return static::fromCarbon($this->toCarbon()->subDays($days));
    }

    public function addHours(int $hours = 1)
    {
        return static::fromCarbon($this->toCarbon()->addHours($hours));
    }

    public function subHours(int $hours = 1)
    {
        return static::fromCarbon($this->toCarbon()->subHours($hours));
    }

    public function addMinutes(int $minutes = 1)
    {
        return static::fromCarbon($this->toCarbon()->addMinutes($minutes));
    }

    public function subMinutes(int $minutes = 1)
    {
        return static::fromCarbon($this->toCarbon()->subMinutes($minutes));
    }

    public function addSeconds(int $secs = 1)
    {
        return static::fromCarbon($this->toCarbon()->addSeconds($secs));
    }

    public function subSeconds(int $secs = 1)
    {
        return static::fromCarbon($this->toCarbon()->subSeconds($secs));
    }

    public function equalsTo(Jalalian $other): bool
    {
        return $this->equalsToCarbon($other->toCarbon());
    }

    public function equalsToCarbon(Carbon $carbon): bool
    {
        return $this->toCarbon()->equalTo($carbon);
    }

    public function greaterThan(Jalalian $other): bool
    {
        return $this->greaterThanCarbon($other->toCarbon());
    }

    public function greaterThanCarbon(Carbon $carbon): bool
    {
        return $this->toCarbon()->greaterThan($carbon);
    }

    public function lessThan(Jalalian $other): bool
    {
        return $this->lessThanCarbon($other->toCarbon());
    }

    public function lessThanCarbon(Carbon $carbon): bool
    {
        return $this->toCarbon()->lessThan($carbon);
    }

    public function greaterThanOrEqualsTo(Jalalian $other): bool
    {
        return $this->greaterThanOrEqualsToCarbon($other->toCarbon());
    }

    public function greaterThanOrEqualsToCarbon(Carbon $carbon): bool
    {
        return $this->toCarbon()->greaterThanOrEqualTo($carbon);
    }

    public function lessThanOrEqualsTo(Jalalian $other): bool
    {
        return $this->lessThanOrEqualsToCarbon($other->toCarbon());
    }

    public function lessThanOrEqualsToCarbon(Carbon $carbon): bool
    {
        return $this->toCarbon()->lessThanOrEqualTo($carbon);
    }

    public function isStartOfWeek(): bool
    {
        return $this->isSaturday();
    }

    public function isSaturday(): bool
    {
        return $this->isDayOfWeek(Carbon::SATURDAY);
    }

    public function isDayOfWeek(int $day): bool
    {
        Assertion::between($day, 0, 6);
        return $this->toCarbon()->isDayOfWeek($day);
    }

    public function isEndOfWeek(): bool
    {
        return $this->isFriday();
    }

    public function isFriday(): bool
    {
        return $this->isDayOfWeek(Carbon::FRIDAY);
    }

    public function isToday(): bool
    {
        return $this->toCarbon()->isToday();
    }

    public function isTomorrow(): bool
    {
        return $this->toCarbon()->isTomorrow();
    }

    public function isYesterday(): bool
    {
        return $this->toCarbon()->isYesterday();
    }

    public function isFuture(): bool
    {
        return $this->toCarbon()->isFuture();
    }

    public function isPast(): bool
    {
        return $this->toCarbon()->isPast();
    }

    public function toArray()
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'dayOfWeek' => $this->getDayOfWeek(),
            'dayOfYear' => $this->getDayOfYear(),
            'hour' => $this->hour,
            'minute' => $this->minute,
            'second' => $this->second,
            'micro' => $this->toCarbon()->micro,
            'timestamp' => $this->toCarbon()->timestamp,
            'formatted' => $this->toString(),
            'timezone' => $this->timezone,
        ];
    }

    public function getDayOfWeek()
    {
        if ($this->isSaturday()) {
            return 0;
        }

        if ($this->isSunday()) {
            return 1;
        }

        if ($this->isMonday()) {
            return 2;
        }

        if ($this->isTuesday()) {
            return 3;
        }

        if ($this->isWednesday()) {
            return 4;
        }

        if ($this->isThursday()) {
            return 5;
        }

        return 6;
    }

    public function isSunday(): bool
    {
        return $this->isDayOfWeek(Carbon::SUNDAY);
    }

    public function isMonday(): bool
    {
        return $this->isDayOfWeek(Carbon::MONDAY);
    }

    public function isTuesday(): bool
    {
        return $this->isDayOfWeek(Carbon::TUESDAY);
    }

    public function isWednesday(): bool
    {
        return $this->isDayOfWeek(Carbon::WEDNESDAY);
    }

    public function isThursday(): bool
    {
        return $this->isDayOfWeek(Carbon::THURSDAY);
    }

    public function getDayOfYear()
    {
        $dayOfYear = 0;
        for ($m = 1; $m < $this->getMonth(); $m++) {
            if ($m <= 6) {
                $dayOfYear += 31;
                continue;
            }

            if ($m < 12) {
                $dayOfYear += 30;
                continue;
            }
        }

        return $dayOfYear + $this->getDay();
    }

    public function toString()
    {
        return $this->format('Y-m-d H:i:s');
    }

    public function format(string $format)
    {
        return CalendarUtils::strftime($format, $this->toCarbon());
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function ago()
    {
        $now = time();
        $time = $this->toCarbon()->getTimestamp();

        // catch error
        if (!$time) {
            return false;
        }

        // build period and length arrays
        $periods = ['ثانیه', 'دقیقه', 'ساعت', 'روز', 'هفته', 'ماه', 'سال', 'قرن'];
        $lengths = [60, 60, 24, 7, 4.35, 12, 10];

        // get difference
        $difference = $now - $time;

        // set descriptor
        if ($difference < 0) {
            $difference = abs($difference); // absolute value
            $negative = true;
        }

        // do math
        for ($j = 0; $difference >= $lengths[$j] and $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        // round difference
        $difference = intval(round($difference));

        // return
        return number_format($difference) . ' ' . $periods[$j] . ' ' . (isset($negative) ? '' : 'پیش');
    }

    public function getNextWeek()
    {
        return $this->addDays(7);
    }

    public function addDays(int $days = 1)
    {
        return static::fromCarbon($this->toCarbon()->addDays($days));
    }

    public function getNextMonth()
    {
        return $this->addMonths(1);
    }

    public function getDaysOf(int $monthNumber = 1)
    {
        Assertion::between($monthNumber, 1, 12);

        $months = [
            1 => 31,
            2 => 31,
            3 => 31,
            4 => 31,
            5 => 31,
            6 => 31,
            7 => 30,
            8 => 30,
            9 => 30,
            10 => 30,
            11 => 30,
            12 => $this->isLeapYear() ? 30 : 29,
        ];

        return $months[$monthNumber];
    }
}
