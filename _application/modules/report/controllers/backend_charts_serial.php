<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of backend_charts_serial
 *
 * @author Yusuf Rahmanto
 */
class backend_charts_serial extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('backend_report_charts_model', 'backend_charts_model');
    }
    
    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Report Serial' => '#',
            'Penjualan' => 'backend/report/ch_serial',
        );
        
        $waktu = $this->uri->segment(5,'harian');
        if($this->input->post('cari')){
            redirect('backend/report/ch_serial/show/'.$waktu.'/'.$this->input->post('date_start'));
        }
        
        $data['grafik'] = $this->$waktu();
        
        template('backend', 'report/backend_charts_serial_view', $data);
    }

    function harian() {
        $data = array();
        $date_default = date("Y-m-d", strtotime('-6 day',strtotime(date("Y-m-d"))));
        $date_start = $this->uri->segment(6, $date_default);
        
        $data['penggunaan']['series'][0]['name'] = 'Posting';
        $data['aktivasi']['series'][0]['name'] = 'Aktivasi';
        $data['jual_aktif']['series'][0]['name'] = 'Aktif';
        $data['jual_pasif']['series'][0]['name'] = 'Pasif';
        for($c=0;$c<=6;$c++){
            $date = date("Y-m-d", strtotime("+$c day",strtotime($date_start)));
            $get_penggunaan = $this->backend_charts_model->sum_penggunaan($date, 'harian')->row_array();
            $data['penggunaan']['categories'][$c] = $date;
            $data['penggunaan']['series'][0]['data'][$c] = intval($get_penggunaan['total']);
            $get_aktivasi = $this->backend_charts_model->sum_aktivasi($date, 'harian')->row_array();
            $data['aktivasi']['categories'][$c] = $date;
            $data['aktivasi']['series'][0]['data'][$c] = intval($get_aktivasi['total']);
            $data['jual_aktif']['categories'][$c] = $date;
            $data['jual_pasif']['categories'][$c] = $date;
            
            $jual_aktif = $jual_pasif = 0;
            $get_jual = $this->backend_charts_model->sum_penjualan($date, 'harian')->result_array();
            if($get_jual){
                foreach ($get_jual as $row){
                    if($row['serial_activation_datetime'] > $row['serial_buyer_datetime']){
                        $jual_pasif += 1;
                    } else {
                        $jual_aktif += 1;
                    }
                }
            }
            $data['jual_aktif']['series'][0]['data'][$c] = intval($jual_aktif);
            $data['jual_pasif']['series'][0]['data'][$c] = intval($jual_pasif);
        }
        
        return $data;
    }
    
    function bulanan() {
        $data = array();
        $date_default = date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y")));
        $date_start = $this->uri->segment(6, $date_default);
        
        $data['penggunaan']['series'][0]['name'] = 'Posting';
        $data['aktivasi']['series'][0]['name'] = 'Aktivasi';
        $data['jual_aktif']['series'][0]['name'] = 'Aktif';
        $data['jual_pasif']['series'][0]['name'] = 'Pasif';
        
        //$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        $bulan = array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
        for($c=0;$c<12;$c++){
            $date = date("Y-m", strtotime("+$c month",strtotime($date_start)));
            $get_penggunaan = $this->backend_charts_model->sum_penggunaan($date, 'bulanan')->row_array();
            $data['penggunaan']['categories'][$c] = $bulan[$c];
            $data['penggunaan']['series'][0]['data'][$c] = intval($get_penggunaan['total']);
            $get_aktivasi = $this->backend_charts_model->sum_aktivasi($date, 'bulanan')->row_array();
            $data['aktivasi']['categories'][$c] = $bulan[$c];
            $data['aktivasi']['series'][0]['data'][$c] = intval($get_aktivasi['total']);
            $data['jual_aktif']['categories'][$c] = $bulan[$c];
            $data['jual_pasif']['categories'][$c] = $bulan[$c];
            
            $jual_aktif = $jual_pasif = 0;
            $get_jual = $this->backend_charts_model->sum_penjualan($date, 'bulanan')->result_array();
            if($get_jual){
                foreach ($get_jual as $row){
                    if($row['serial_activation_datetime'] > $row['serial_buyer_datetime']){
                        $jual_pasif += 1;
                    } else {
                        $jual_aktif += 1;
                    }
                }
            }
            $data['jual_aktif']['series'][0]['data'][$c] = intval($jual_aktif);
            $data['jual_pasif']['series'][0]['data'][$c] = intval($jual_pasif);
        }
        
        return $data;
    }
    
    function tahunan() {
        $data = array();
        $date_default = date("Y");
        $date_start = $this->uri->segment(6, $date_default);
        
        $data['penggunaan']['series'][0]['name'] = 'Posting';
        $data['aktivasi']['series'][0]['name'] = 'Aktivasi';
        $data['jual_aktif']['series'][0]['name'] = 'Aktif';
        $data['jual_pasif']['series'][0]['name'] = 'Pasif';
        
        for($c=2013;$c<$date_start;$c++){
            $date = date("Y", strtotime("+1 year",strtotime($c.'-01-01')));
            $get_penggunaan = $this->backend_charts_model->sum_penggunaan($date, 'tahunan')->row_array();
            $data['penggunaan']['categories'][] = $date;
            $data['penggunaan']['series'][0]['data'][] = intval($get_penggunaan['total']);
            $get_aktivasi = $this->backend_charts_model->sum_aktivasi($date, 'tahunan')->row_array();
            $data['aktivasi']['categories'][] = $date;
            $data['aktivasi']['series'][0]['data'][] = intval($get_aktivasi['total']);
            $data['jual_aktif']['categories'][] = $date;
            $data['jual_pasif']['categories'][] = $date;
            
            $jual_aktif = $jual_pasif = 0;
            $get_jual = $this->backend_charts_model->sum_penjualan($date, 'tahunan')->result_array();
            if($get_jual){
                foreach ($get_jual as $row){
                    if($row['serial_activation_datetime'] > $row['serial_buyer_datetime']){
                        $jual_pasif += 1;
                    } else {
                        $jual_aktif += 1;
                    }
                }
            }
            $data['jual_aktif']['series'][0]['data'][] = intval($jual_aktif);
            $data['jual_pasif']['series'][0]['data'][] = intval($jual_pasif);
        }
        
        return $data;
    }
    
//    function total_penjualan2($render_to, $theme) {
//        $value = array();
//        $this->highcharts_lib->initialize($theme);
//        $this->highcharts_lib->set_title('Penggunaan Kartu Aktivasi');
//        $this->highcharts_lib->set_dimensions(450,250); 
//        $this->highcharts_lib->set_axis_titles('Tanggal', 'Jumlah');
//        $this->highcharts_lib->render_to($render_to);
//
//        $date['start'] = '2014-01-18';
//        $date['end'] = '2014-06-18';
//        //$date['end'] = date("Y-m-d", strtotime('+6 day',strtotime($date['start'])));
//        $get_penggunaan = $this->backend_charts_model->sum_penggunaan_harian($date)->result_array();
//        if(!empty($get_penggunaan)){
//            foreach ($get_penggunaan as $row){
//                $value[] = intval($row["total_serial"]);
//                $date[] = ($row["serial_use_date"]);
//            }
//        }
//        
//        $this->highcharts_lib->push_xcategorie($date);
//
//        $serie['data'] = $value;
//        $this->highcharts_lib->export_file("Code 2 Learn Chart".date('d M Y')); 
//        $this->highcharts_lib->set_serie($serie, "Age");
//
//        return $this->highcharts_lib->render();
//    }
}
?>
