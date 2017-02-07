<?php

/*
 * Yahoo! Messenger Status Helper
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('ymstatus')) {

    function ymstatus($yahooid, $img_ol_path, $img_off_path, $title) {
        $yahoo_url = "http://opi.yahoo.com/online?u={$yahooid}&m=a&t=1";
        if (ini_get('allow_url_fopen')) {
            error_reporting(0);
            $yahoo = file_get_contents($yahoo_url);
        } elseif (function_exists('curl_init')) {
            $ch = curl_init($yahoo_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $yahoo = curl_exec($ch);
            curl_close($ch);
        }

        $yahoo = trim($yahoo);
        if (empty($yahoo))
            $imgsrc = $img_off_path; /* Maybe failed connection. */
        elseif ($yahoo == "01")
            $imgsrc = $img_ol_path;
        elseif ($yahoo == "00")
            $imgsrc = $img_off_path;
        else
            $imgsrc = $img_off_path;

        return '<a href="ymsgr:sendIM?' . $yahooid . '" title="' . $title . '"><img src="' . $imgsrc . '" alt="' . $title . '" border="0" /></a>';
    }

}
?>