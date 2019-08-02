<?php namespace App\Helpers;
 
class Parser {

    public static function isCDT($str)
    {
        if (preg_match('/^C\d{8,11}?/', $str)) {
            return true;
        }
        return false;
    }

    public static function isIDT($str)
    {
        if (preg_match('/^I\d{8,11}?/', $str)) {
            return true;
        }
        return false;
    }
}