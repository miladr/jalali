<?php

class jDateTimeTest extends PHPUnit_Framework_TestCase
{
    public function testCheckDate()
    {
        $this->assertTrue(\Morilog\Jalali\jDateTime::checkDate(1391, 2, 30, true));
        $this->assertFalse(\Morilog\Jalali\jDateTime::checkDate(1395, 13, 10, true));
        $this->assertFalse(\Morilog\Jalali\jDateTime::checkDate(1395, 12, 31, true));
    }

    public function testToJalali()
    {
        $this->assertTrue(\Morilog\Jalali\jDateTime::toJalali(2016, 5, 7) === [1395, 2, 18]);
        $this->assertFalse(\Morilog\Jalali\jDateTime::toJalali(2015, 5, 7) === [1394, 2, 18]);
    }

    public function testToGregorian()
    {
        $this->assertTrue(\Morilog\Jalali\jDateTime::toGregorian(1395, 2, 18) === [2016, 5, 7]);
        $this->assertFalse(\Morilog\Jalali\jDateTime::toGregorian(1394, 2, 18) === [2015, 5, 7]);
    }

    public function testIsLeapJalaliYear()
    {
        $this->assertTrue(\Morilog\Jalali\jDateTime::isLeapJalaliYear(1395));
        $this->assertFalse(\Morilog\Jalali\jDateTime::isLeapJalaliYear(1394));
    }

    public function testStrftime()
    {
        $this->assertTrue(\Morilog\Jalali\jDateTime::strftime('Y-m-d', strtotime('2016-05-8')) === '1395-02-19');
        $this->assertTrue(\Morilog\Jalali\jDateTime::strftime('Y-m-d', strtotime('2016-05-8'), true) === '۱۳۹۵-۰۲-۱۹');
        $this->assertFalse(\Morilog\Jalali\jDateTime::strftime('Y-m-d', strtotime('2016-05-8'), false) === '۱۳۹۵-۰۲-۱۹');
    }
}
