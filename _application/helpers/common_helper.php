<?php

/*
 * Common Helper
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('convert_month')) {

    function convert_month($month, $lang = 'en') {
        $month = (int) $month;
        switch ($lang) {
            case 'id':
                $arr_month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
                break;

            default:
                $arr_month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                break;
        }
        
        if(array_key_exists($month - 1, $arr_month)) {
            $month_converted = $arr_month[$month - 1];
        } else {
            $month_converted = '';
        }

        return $month_converted;
    }

}


if (!function_exists('convert_date')) {

    function convert_date($date, $lang = 'en', $type = 'text', $format = '.') {
        if (!empty($date) && $date != '0000-00-00') {
            $date = substr($date, 0, 10);
            if ($type == 'num') {
                $date_converted = str_replace('-', $format, $date);
            } else {
                $year = substr($date, 0, 4);
                $month = substr($date, 5, 2);
                $month = convert_month($month, $lang);
                $day = substr($date, 8, 2);

                $date_converted = $day . ' ' . $month . ' ' . $year;
            }
        } else {
            $date_converted = '-';
        }
        return $date_converted;
    }

}


if (!function_exists('convert_datetime')) {

    function convert_datetime($date, $lang = 'en', $type = 'text', $formatdate = '.', $formattime = ':') {

        if (!empty($date)) {
            if ($type == 'num') {
                $date_converted = str_replace('-', $formatdate, str_replace(':', $formattime, $date));
            } else {
                $year = substr($date, 0, 4);
                $month = substr($date, 5, 2);
                $month = convert_month($month, $lang);
                $day = substr($date, 8, 2);
                $time = strlen($date) > 10 ? substr($date, 11, 8) : '';
                $time = str_replace(':', $formattime, $time);

                $date_converted = $day . ' ' . $month . ' ' . $year . ' ' . $time;
            }
        } else {
            $date_converted = '-';
        }
        return $date_converted;
    }

}


if (!function_exists('get_filesize')) {

    function get_filesize($file) {
        $bytes = array("B", "KB", "MB", "GB", "TB", "PB");
        $file_with_path = $file;
        $file_with_path;
        // replace (possible) double slashes with a single one
        $file_with_path = str_replace("///", "/", $file_with_path);
        $file_with_path = str_replace("//", "/", $file_with_path);
        $size = @filesize($file_with_path);
        $i = 0;

        //divide the filesize (in bytes) with 1024 to get "bigger" bytes
        while ($size >= 1024) {
            $size = $size / 1024;
            $i++;
        }

        // you can change this number if you like (for more precision)
        if ($i > 1) {
            return round($size, 1) . " " . $bytes[$i];
        } else {
            return round($size, 0) . " " . $bytes[$i];
        }
    }

}

/**
|------------------------------------------------------------------
| Date Converter
|------------------------------------------------------------------
| Converting date format
| 
| D    =   Mon through Sun
| l    =   Sunday through Saturday
| N    =   1 (for Monday) through 7 (for Sunday)
| w    =   0 (for Sunday) through 6 (for Saturday)
| F    =   January through December
| M    =   Jan through Dec
| 
 */

if (! function_exists('date_converter')) {
    function date_converter($date, $new_format, $lang='id')
    {
        $month_name = array(1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        $day_name = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');

        $timestamp = strtotime($date);
        if ($lang == 'id') {

            $converted_date = date($new_format, $timestamp);
            if (strpos($new_format, 'F') !== FALSE) {
                $month_global = date('F', $timestamp);
                $month_global_n = date('n', $timestamp);
                $month_id = $month_name[$month_global_n];
                $converted_date = str_replace($month_global, $month_id, $converted_date);
            }
            
            if (strpos($new_format, 'M') !== FALSE) {
                $month_global2 = date('M', $timestamp);
                $month_global_n2 = date('n', $timestamp);
                $month_id2 = $month_name[$month_global_n2];
                $converted_date = str_replace($month_global2, substr($month_id2, 0, 3), $converted_date);
            }

            if (strpos($new_format, 'l') !== FALSE) {
                $day_global = date('l', $timestamp);
                $day_global_n = date('w', $timestamp);
                $day_id = $day_name[$day_global_n];
                $converted_date =str_replace($day_global, $day_id, $converted_date);
            }

            if (strpos($new_format, 'D') !== FALSE) {
                $day_global2 = date('D', $timestamp);
                $day_global_n2 = date('w', $timestamp);
                $day_id2 = $day_name[$day_global_n2];
                $converted_date =str_replace($day_global2, substr($day_id2, 0, 3), $converted_date);
            }

        } else {
            $converted_date = date($new_format, $timestamp);
        }

        return $converted_date;
    }
}