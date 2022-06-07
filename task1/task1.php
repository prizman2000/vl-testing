<?php

function makeMagicStringFromDate()
{
    $dateTime = new DateTime("now", new DateTimeZone("GMT"));
    $str = $dateTime->format("YmdHis");

    for ($i = 0; $i < strlen($str); $i++) {
        (!$str[$i]) ? $str[$i] = 'a' : $str[$i] = 10 - $str[$i];
    }

    return $str;
}