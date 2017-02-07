<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * konfigurasi settingan netgrow
 * keterangan:
 * - index => nama unik yang akan digunakan untuk id dan nama field di database
 * - active => boolean (apakah netgrow dicatat)
 */

// sponsor
$config['netgrow']['sponsor'] = array(
    'active' => true, // wajib true
);

// titik
$config['netgrow']['node'] = array(
    'active' => true, // wajib true
);

// pasangan
$config['netgrow']['match'] = array(
    'active' => true, // wajib true untuk binary
    'flushout' => 15, // jumlah maksimal pasangan per periode
    'max_wait' => 0, // jika nol, maka tidak ada maksimal titik menunggu
);

// pasangan level
$config['netgrow']['level_match'] = array(
    'active' => false,
);

// generasi pasangan / matching
$config['netgrow']['gen_match'] = array(
    'active' => false,
    'level' => 3,
);

// generasi titik / duplikasi
$config['netgrow']['gen_node'] = array(
    'active' => false,
    'level' => 3,
);

// generasi sponsor
// contoh: ketika A mensponsori B, maka maka jaringan diatas A sesuai jalur sponsor sampai level tertentu mendapatkan bonus ini
$config['netgrow']['gen_sponsor'] = array(
    'active' => false,
    'level' => 27,
);

// upline sponsor
// contoh: ketika A mensponsori B, maka upline dari A mendapatkan bonus ini
$config['netgrow']['upline_sponsor'] = array(
    'active' => false,
);

// upline pasangan
// contoh: ketika A mendapatkan bonus pasangan, maka upline dari A mendapatkan bonus ini
$config['netgrow']['upline_match'] = array(
    'active' => false,
);
