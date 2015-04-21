<?php

namespace Derby\Utility;

class Slugize
{
    public static function slugize($str)
    {
        $str = strtolower(trim($str));

        $chars        = array("ä", "ö", "ü", "ß");
        $replacements = array("ae", "oe", "ue", "ss");
        $str          = str_replace($chars, $replacements, $str);

        $pattern      = array("/(é|è|ë|ê)/", "/(ó|ò|ö|ô)/", "/(ú|ù|ü|û)/");
        $replacements = array("e", "o", "u");
        $str          = preg_replace($pattern, $replacements, $str);

        $pattern = array(":", "!", "?", ".", "/", "'");
        $str     = str_replace($pattern, "", $str);

        $pattern = array("/[^a-z0-9-]/", "/-+/");
        $str     = preg_replace($pattern, "-", $str);

        return $str;
    }
}
