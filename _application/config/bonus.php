<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * konfigurasi settingan bonus
 * keterangan:
 * - index => nama unik yang akan digunakan untuk id dan nama field di database
 * - label => label yang akan ditampilkan pada table
 * - active => boolean (apakah bonus dipakai)
 * - value => nilai bonus (jika ada level, maka dibuat array lagi. batasan level memakai count array value)
 */
// sponsor
$config['bonus']['sponsor'] = array(
    'label' => 'Bonus Sponsor',
    'active' => true,
    'periode' => 'daily',
    'value' => 350000,
);

// titik
$config['bonus']['node'] = array(
    'label' => 'Bonus Titik',
    'active' => true,
    'periode' => 'daily',
    'value' => array(
        1 => 50000,
        2 => 25000,
        3 => 10000,
        4 => 10000,
        5 => 10000,
        6 => 10000,
        7 => 10000,
        8 => 10000,
        9 => 10000,
        10 => 10000,
    ),
);

// pasangan
$config['bonus']['match'] = array(
    'label' => 'Bonus Pasangan',
    'active' => true,
    'periode' => 'daily',
    'value' => 100000,
);

// generasi pasangan / matching
$config['bonus']['gen_match'] = array(
    'label' => 'Bonus Generasi',
    'active' => false,
    'periode' => 'daily',
    'value' => array(
        1 => 0,
    ),
);

// generasi titik / duplikasi
$config['bonus']['gen_node'] = array(
    'label' => 'Bonus Generasi Titik',
    'active' => false,
    'periode' => 'daily',
    'value' => array(
        1 => 0,
    ),
);

// generasi sponsor
// contoh: ketika A mensponsori B, maka maka jaringan diatas A sesuai jalur sponsor sampai level tertentu mendapatkan bonus ini
$config['bonus']['gen_sponsor'] = array(
    'label' => 'Royalti Jariyah',
    'active' => false,
    'periode' => 'daily',
    'value' => array(
        1 => 0,
    ),
);

// upline sponsor
// contoh: ketika A mensponsori B, maka upline dari A mendapatkan bonus ini
$config['bonus']['upline_sponsor'] = array(
    'label' => 'Bonus Upline Sponsor',
    'active' => false,
    'periode' => 'daily',
    'value' => 0,
);

// upline pasangan
// contoh: ketika A mendapatkan bonus pasangan, maka upline dari A mendapatkan bonus ini
$config['bonus']['upline_match'] = array(
    'label' => 'Bonus Upline Pasangan',
    'active' => false,
    'periode' => 'daily',
    'value' => 0,
);
