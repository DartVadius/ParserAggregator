<?php

namespace app\lib;

class MyFunctions {

    public static function setTimeStamp($timer, $format = 'Y-m-d H:i:s') {
        $date = new \DateTime();
        $date->modify($timer);
        $date->format($format);
        $date = $date->getTimestamp();
        return $date = date($format, $date);
    }

    /**
     * string treatment
     *
     * @param string $str
     * @return string
     */
    public static function strProcessing($str) {
        $str = mb_strtolower($str);
        return trim($str);
    }

}