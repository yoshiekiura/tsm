<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * konfigurasi settingan transfer
 * keterangan:
 * - index => nama unik untuk kategori transfer (bonus_transfer_category)
 * - title => judul yang akan ditampilkan pada halaman transfer
 * - bonus_min => nilai minimal bonus yang akan ditransfer
 * - arr_bonus => array bonus yang akan ditransfer
 * - adm_charge => nilai potongan administrasi
 * - adm_charge_type => jenis potongan administrasi (value, percent)
 */

$config['transfer']['daily'] = array(
    'title' => 'Harian',
    'type' => 'cash',
    'bonus_min' => 20000,
    'arr_bonus' => array(
        'sponsor','match','node'
    ),
    'adm_charge' => 0,
    'adm_charge_type' => 'value'
);

$config['transfer']['weekly'] = array(
    'title' => 'Mingguan',
    'type' => 'cash',
    'bonus_min' => 20000,
    'arr_bonus' => array(
        
    ),
    'adm_charge' => 0,
    'adm_charge_type' => 'value'
);

$config['transfer']['monthly'] = array(
    'title' => 'Bulanan',
    'type' => 'cash',
    'bonus_min' => 20000,
    'arr_bonus' => array(
        
    ),
    'adm_charge' => 0,
    'adm_charge_type' => 'value'
);
