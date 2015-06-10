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


}
