<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of backend_charts_member
 *
 * @author Yusuf Rahmanto
 */
class backend_charts_member extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('backend_report_charts_model', 'backend_charts_model');
        $this->load->helper('form');
    }
    
    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Report Member' => '$',
            'Daerah' => 'backend/report/ch_member',
        );
        
        $waktu = $this->uri->segment(5,'harian');
        if($this->input->post('cari')){
            redirect('backend/report/ch_member/show/'.$waktu.'/'.$this->input->post('date_start'));
        }
        
        $data['grafik'] = $this->$waktu();
        
        template('backend', 'report/backend_member_charts_view', $data);
    }

    function coverage() {
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
                    if($row['member_activation_datetime'] > $row['member_buyer_datetime']){
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
}

?>
