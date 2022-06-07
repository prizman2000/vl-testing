<?php

function makeMagicStringFromDate1()
{
    $dateTime = new DateTime("now", new DateTimeZone("GMT"));
    $str = $dateTime->format("YmdHis");

    for ($i = 0; $i < strlen($str); $i++) {
        (!$str[$i]) ? $str[$i] = 'a' : $str[$i] = 10 - $str[$i];
    }

    return $str;
}

function makeMagicStringFromDate2()
{
    $dateTime = new DateTime("now", new DateTimeZone("GMT"));
    $str = $dateTime->format("YmdHis");

    return preg_replace_callback('/(\d)/', function ($match) {return 10 - (int)$match[1];}, str_replace('0', 'a', $str));
}