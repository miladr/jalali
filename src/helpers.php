<?php

if (! function_exists('jdate')) {

    /**
     * @param string $str
     * @return \Morilog\Jalali\jDate
     */
    function jdate($str = null)
    {
        return \Morilog\Jalali\jDate::forge($str);
    }
}
