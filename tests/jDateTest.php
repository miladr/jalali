<?php

use Morilog\Jalali\jDate;

class jDateTest extends PHPUnit_Framework_TestCase
{
    public function test_jdate_class_must_instantiable()
    {
        $object = new jDate();
        $this->assertTrue(is_a($object, jDate::class));
    }

    public function test_it_must_foregable_and_must_work_fine()
    {
        $object = new jDate();
        $jDate = $object->forge('2015-06-03')->format('Y-m-d');

        $this->assertNotNull($object->forge());
        $this->assertTrue('1394-03-13' === $jDate);
    }

    public function test_it_must_reforgable_most_work_fine()
    {
        $object = new jDate();
        $jDate = $object->forge('2015-06-03')
            ->reforge('+ 3 days')
            ->format('Y-m-d');

        $this->assertTrue('1394-03-16' === $jDate);
    }

    public function test_relative_time()
    {
        $object = new jDate();
        $jDate = $object->forge('- 10 minutes')->ago();

        $this->assertTrue('10 دقیقه پیش' === $jDate);
    }

    public function test_format_with_convert_to_persian()
    {
        $object = new jDate();
        $jDate = $object->forge('2015-06-13')->format('Y-m-d');

        $this->assertTrue('۱۳۹۴-۰۳-۲۳' === \Morilog\Jalali\jDateTime::convertNumbers($jDate));
    }

    public function test_time()
    {
        $time = time();
        $theTime = \Morilog\Jalali\jDate::forge($time)->time();

        $this->assertTrue($time === $theTime);

        $theTime = \Morilog\Jalali\jDate::forge('now')->time();
        $this->assertTrue($theTime === strtotime('now'));
    }
}
