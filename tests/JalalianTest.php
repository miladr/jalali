<?php

namespace Morilog\Jalali\Tests;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use PHPUnit\Framework\TestCase;

final class JalalianTest extends TestCase
{
    public function testCreateFromConstructor()
    {
        $jDate = new Jalalian(1397, 1, 25);
        $this->assertTrue($jDate instanceof Jalalian);
        $this->assertEquals($jDate->getDay(), 25);
        $this->assertEquals($jDate->getYear(), 1397);
        $this->assertEquals($jDate->getMonth(), 1);

        $this->assertEquals($jDate->format('Y-m-d H:i:s'), '1397-01-25 00:00:00');
    }

    public function testGetDayOfYear()
    {
        $jDate = new Jalalian(1397, 1, 25);
        $this->assertEquals($jDate->getDayOfYear(), 25);

        $jDate = new Jalalian(1397, 5, 20);
        $this->assertEquals($jDate->getDayOfYear(), 144);

        $jDate = new Jalalian(1397, 7, 3);
        $this->assertEquals($jDate->getDayOfYear(), 189);

        $jDate = new Jalalian(1397, 12, 29);
        $this->assertEquals($jDate->getDayOfYear(), 365);

        $jDate = new Jalalian(1395, 12, 30);
        $this->assertTrue($jDate->isLeapYear());
        $this->assertEquals($jDate->getDayOfYear(), 366);
    }

    public function testModifiers()
    {
        $jDate = new Jalalian(1397, 1, 18);

        $this->assertEquals($jDate->addYears()->getYear(), 1398);
        $this->assertEquals($jDate->addMonths(11)->getMonth(), 12);
        $this->assertEquals($jDate->addMonths(11)->addDays(20)->getMonth(), 1);
        $this->assertEquals($jDate->subDays(8)->getNextMonth()->getMonth(), 2);

        $jDate = Jalalian::fromCarbon(Carbon::createFromDate(2019, 1, 1));
        $this->assertEquals($jDate->addMonths(4)->getYear(), 1398);

        $jDate = new Jalalian(1397, 1, 31);
        $this->assertEquals($jDate->addMonths(1)->getDay(), 31);
        $this->assertEquals($jDate->addYears(3)->getDay(), 31);
        $this->assertEquals($jDate->addMonths(36)->toString(), $jDate->addYears(3)->toString());
        $this->assertEquals($jDate->subYears(10)->toString(), (new Jalalian(1387, 1, 31))->toString());
        $this->assertTrue($jDate->subYears(2)->subMonths(34)->equalsTo(new Jalalian(1392, 03, 31)));

        $jDate = (new Jalalian(1397, 6, 11))->subMonths(1);
        $this->assertEquals($jDate->getMonth(), 5);

        $this->assertEquals((new Jalalian(1397, 7, 1))->subMonths(1)->getMonth(), 6);

        $jDate = Jalalian::now();
        $month = $jDate->getMonth();
        if ($month > 1) {
            $this->assertEquals($month - 1, $jDate->subMonths()->getMonth());
        }


        $jDate = Jalalian::fromFormat('Y-m-d', '1397-12-12');
        $this->assertEquals('1398-01-12', $jDate->addMonths(1)->format('Y-m-d'));

        $jDate = Jalalian::fromFormat('Y-m-d', '1397-11-30');
        $this->assertEquals('1397-12-29', $jDate->addMonths(1)->format('Y-m-d'));

        $jDate = Jalalian::fromFormat('Y-m-d', '1397-06-30');
        $this->assertEquals('1397-07-30', $jDate->addMonths(1)->format('Y-m-d'));

        $jDate = Jalalian::fromFormat('Y-m-d', '1397-06-31');
        $this->assertEquals('1397-07-30', $jDate->addMonths(1)->format('Y-m-d'));

        $jDate = Jalalian::fromFormat('Y-m-d', '1395-12-30');
        $this->assertEquals('1399-12-30', $jDate->addMonths(48)->format('Y-m-d'));

        $jDate = Jalalian::fromFormat('Y-m-d', '1395-12-30');
        $this->assertEquals('1398-12-29', $jDate->addMonths(36)->format('Y-m-d'));
    }

    public function testForge()
    {
        $jDate = Jalalian::forge(strtotime('now'));
        $this->assertTrue($jDate instanceof Jalalian);
        $this->assertTrue($jDate->getTimestamp() === strtotime('now'));

        $jDate = Jalalian::forge(1333857600);
        $this->assertEquals($jDate->toString(), '1391-01-20 04:00:00');

        $jDate = Jalalian::forge('last monday');
        $this->assertTrue($jDate instanceof Jalalian);

        $jDate = Jalalian::forge(1552608000);
        $this->assertEquals('1397-12-24', $jDate->format('Y-m-d'));
    }
}
