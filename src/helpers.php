<?php

if (!function_exists('roundUp')) {
    function roundUp($value, $precision)
    {
        $pow = pow(10, $precision);
        return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
    }
}

if (!function_exists('getWeekNumberFromDate')) {
    function getWeekNumberFromDate($date)
    {
        return date('W', strtotime($date));
    }
}

if (!function_exists('getYearFromDate')) {
    function getYearFromDate($date)
    {
        return date('Y', strtotime($date));
    }
}

if (!function_exists('getBetweenDates')) {
    function getBetweenDates($startDate, $endDate)
    {
        $rangArray = [];
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        for ($currentDate = $startDate; $currentDate <= $endDate;
            $currentDate += (86400)) {
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }
        return $rangArray;
    }
}
