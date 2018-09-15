<?php

namespace Morilog\Jalali\Tests;

use DateTime;
use DateTimeZone;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\jDate;
use PHPUnit\Framework\TestCase;

class CalendarUtilsTest extends TestCase
{
    public function testCheckDate()
    {
        $this->assertTrue(CalendarUtils::checkDate(1391, 2, 30, true));
        $this->assertFalse(CalendarUtils::checkDate(1395, 13, 10, true));
        $this->assertFalse(CalendarUtils::checkDate(1395, 12, 31, true));
        $this->assertFalse(CalendarUtils::checkDate(2015, 12, 31, true));
    }

    public function testToJalali()
    {
        $this->assertTrue(CalendarUtils::toJalali(2016, 5, 7) === [1395, 2, 18]);
        $this->assertFalse(CalendarUtils::toJalali(2015, 5, 7) === [1394, 2, 18]);
    }

    public function testToGregorian()
    {
        $this->assertTrue(CalendarUtils::toGregorian(1395, 2, 18) === [2016, 5, 7]);
        $this->assertFalse(CalendarUtils::toGregorian(1394, 2, 18) === [2015, 5, 7]);
    }

    public function testIsLeapJalaliYear()
    {
        $this->assertTrue(CalendarUtils::isLeapJalaliYear(1395));
        $this->assertFalse(CalendarUtils::isLeapJalaliYear(1394));
    }

    public function testStrftime()
    {
        $this->assertTrue(CalendarUtils::strftime('Y-m-d', strtotime('2016-05-8')) === '1395-02-19');
        $this->assertTrue(CalendarUtils::convertNumbers(CalendarUtils::strftime('Y-m-d',
                strtotime('2016-05-8'))) === '۱۳۹۵-۰۲-۱۹');

        $dateString = CalendarUtils::convertNumbers('۱۳۹۵-۰۲-۱۹', true); // 1395-02-19
        $this->assertTrue(CalendarUtils::createCarbonFromFormat('Y-m-d',
                $dateString)->format('Y-m-d') === '2016-05-08');
        $this->assertFalse(CalendarUtils::strftime('Y-m-d', strtotime('2016-05-8')) === '۱۳۹۵-۰۲-۱۹');
    }

    public function test_parseFromPersian()
    {
        $jalaliDate = '1393/03/27';
        $date = CalendarUtils::parseFromFormat('Y/m/d', $jalaliDate);

        $this->assertEquals(1393, $date['year']);
        $this->assertEquals(03, $date['month']);
        $this->assertEquals(27, $date['day']);

        $date = CalendarUtils::parseFromFormat('Y-m-d H:i:s', '1395-03-15 21:00:00');
        $this->assertEquals(21, $date['hour']);
        $this->assertEquals(0, $date['minute']);
        $this->assertEquals(0, $date['second']);
    }

    public function testCreateDateTimeFormFormat()
    {
        $jdate = '1394/11/25 15:00:00';
        $gDateTime = CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', $jdate);

        $this->assertTrue($gDateTime instanceof \DateTime);

        $this->assertTrue('2016-02-14 15:00:00' === $gDateTime->format('Y-m-d H:i:s'));
    }

    public function testCreateCarbonFormFormat()
    {
        $jdate = '1394/11/25 15:00:00';
        $carbon = CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $jdate);

        $this->assertTrue($carbon instanceof \Carbon\Carbon);
        $this->assertTrue($carbon->day === 14);
        $this->assertTrue('2016-02-14 15:00:00' === $carbon->format('Y-m-d H:i:s'));

        $jalaiDateFormatted = Jalalian::fromDateTime($carbon->toDateString())->format('Y-m-d H:i:s');
        $jalaiDateTimeFormatted = Jalalian::fromDateTime($carbon->toDateTimeString())->format('Y-m-d H:i:s');
        $this->assertFalse($jalaiDateFormatted === '1394-11-25 15:00:00');
        $this->assertTrue($jalaiDateTimeFormatted === '1394-11-25 15:00:00');

    }

    public function testTimezone()
    {
        date_default_timezone_set('Asia/Tehran');
        $tehranDate = Jalalian::now();
        $tehranHour = $tehranDate->format('H');
        $tehranMin = $tehranDate->format('i');

        date_default_timezone_set('UTC');
        $utcDate = Jalalian::now();
        $utcHour = $utcDate->format('H');
        $utcMin = $utcDate->format('i');

        $tzOffset = $this->getTimeZoneOffset('Asia/Tehran', 'UTC');

        $this->assertTrue((((($utcHour * 60) + $utcMin) * 60) - ((($tehranHour * 60) + $tehranMin) * 60)) === $tzOffset);

    }


    private function getTimeZoneOffset($remote_tz, $origin_tz = null)
    {
        if ($origin_tz === null) {
            if (!is_string($origin_tz = date_default_timezone_get())) {
                return false; // A UTC timestamp was returned -- bail out!
            }
        }
        $origin_dtz = new DateTimeZone($origin_tz);
        $remote_dtz = new DateTimeZone($remote_tz);
        $origin_dt = new DateTime("now", $origin_dtz);
        $remote_dt = new DateTime("now", $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);

        return $offset;
    }
}
