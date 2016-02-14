<?php

class HelperTest extends PHPUnit_Framework_TestCase
{
    public function test_jdate_function()
    {
        $this->assertTrue(function_exists('jdate'));

        $jdate = jdate('now');
        $this->assertTrue($jdate instanceof \Morilog\Jalali\jDate);
    }
}
