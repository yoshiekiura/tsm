<?php

if ($rs_slider != false) {
    $i = 1;
    foreach ($rs_slider as $row_slider) {
        echo '<img src="' . base_url() . _dir_slider . $row_slider->slider_image . '" alt="Image ' . $i . '" title="' . $row_slider->slider_title . '" border="0" />';
        $i++;
    }
}
?>