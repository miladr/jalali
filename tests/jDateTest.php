<?php

class jDateTest extends PHPUnit_Framework_TestCase
{
    public function test_jdate_class_must_instantiable()
    {
        $object = new \Morilog\Jalali\jDate();
        $this->assertTrue(is_a($object, \Morilog\Jalali\jDate::class));
    }

    public function test_it_must_foregable_and_must_work_fine()
    {
        $object = new \Morilog\Jalali\jDate();
        $jDate = $object->forge('2015-06-03')->format('Y-m-d');

        $this->assertNotNull($object->forge());
        $this->assertTrue('1394-03-13' === $jDate);
    }

    public function test_it_must_reforgable_most_work_fine()
    {
        $object = new \Morilog\Jalali\jDate();
        $jDate = $object->forge('2015-06-03')
            ->reforge('+ 3 days')
            ->format('Y-m-d');

        $this->assertTrue('1394-03-16' === $jDate);
    }

    public function test_relative_time()
    {
        $object = new \Morilog\Jalali\jDate();
        $jDate = $object->forge('- 10 minutes')->ago();

        $this->assertTrue('10 دقیقه پیش' === $jDate);
    }

    public function test_format_with_convert_to_persian()
    {
        $object = new \Morilog\Jalali\jDate();
        $jDate = $object->forge('2015-06-13')->format('Y-m-d', true);

        $this->assertTrue('۱۳۹۴-۰۳-۲۳' === $jDate);
    }

    public function test_parseFromPersian()
    {
        $jalaliDate = '1393/03/27';
        $date = \Morilog\Jalali\jDate::parseFromFormat('Y/m/d', $jalaliDate);

        $this->assertEquals(1393, $date['year']);
        $this->assertEquals(03, $date['month']);
        $this->assertEquals(27, $date['day']);
    }

    public function test_dateTimeFromFormat()
    {
        $jdate = '1394/11/25 15:00:00';
        $gDateTime = \Morilog\Jalali\jDate::dateTimeFromFormat('Y/m/d H:i:s', $jdate);

        $this->assertTrue($gDateTime instanceof \DateTime);
       
        $this->assertTrue('2016-02-14 15:00:00' === $gDateTime->format('Y-m-d H:i:s'));
    }
}
