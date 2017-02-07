<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of backend_charts_bonus
 *
 * @author Yusuf Rahmanto
 */
class backend_charts_bonus extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('backend_report_charts_model', 'backend_charts_model');
        $this->load->library('mlm/mlm_function');
    }
    
    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Report Serial' => '#',
            'Penjualan' => 'backend/report/ch_bonus',
        );
        
        $waktu = $this->uri->segment(5,'harian');
        if($this->input->post('cari')){
            redirect('backend/report/ch_bonus/show/'.$waktu.'/'.$this->input->post('date_start'));
        }
        
        $data['grafik'] = $this->$waktu();
        
        template('backend', 'report/backend_charts_bonus_view', $data);
    }

    function harian() {
        $data = array();
        $date_default = date("Y-m-d", strtotime('-6 day',strtotime(date("Y-m-d"))));
        $date_start = $this->uri->segment(6, $date_default);
        
        $arr_bonus = $this->mlm_function->get_arr_active_bonus();
        $x = 0;
        foreach($arr_bonus as $arr_bonus_item) {
            $data['payout']['series'][$x]['name'] = str_replace('Bonus', '', $arr_bonus_item['label']);
            $data['transfer']['series'][$x]['name'] = str_replace('Bonus', '', $arr_bonus_item['label']);
            $data['total_payout']['series'][0]['data'][$x][0] = str_replace('Bonus', '', $arr_bonus_item['label']);
            $data['total_payout']['series'][0]['data'][$x][1] = 0;
            $x++;
        }
        $data['profit']['series'][0]['name'] = 'Profit';
        
        for($c=0;$c<=6;$c++){
            $date = date("Y-m-d", strtotime("+$c day",strtotime($date_start)));
            $total_payout = $x = 0;
            foreach($arr_bonus as $arr_bonus_item) {
                $get_payout = $this->backend_charts_model->sum_payout($arr_bonus, $date, 'harian')->row_array();
                $data['payout']['categories'][$c] = $date;
                $data['payout']['series'][$x]['data'][$c] = intval($get_payout['log_'.$arr_bonus_item['name']]);
                
                $data['total_payout']['series'][0]['data'][$x][1] += intval($get_payout['log_'.$arr_bonus_item['name']]);
                $total_payout += $get_payout['log_'.$arr_bonus_item['name']];
                
                $get_transfer = $this->backend_charts_model->sum_transfer($arr_bonus, $date, 'harian')->row_array();
                $data['transfer']['categories'][$c] = $date;
                $data['transfer']['series'][$x]['data'][$c] = intval($get_transfer['transfer_'.$arr_bonus_item['name']]);
                $x++;
            }
            
            $data['total_payout_day']['categories'][$c] = $date;
            $data['total_payout_day']['series'][0]['data'][$c] = intval($total_payout);
            
            $get_penggunaan = $this->backend_charts_model->sum_penggunaan($date, 'harian')->row_array();
            $data['profit']['categories'][$c] = $date;
            $data['profit']['series'][0]['data'][$c] = intval($get_penggunaan['total_harga'] - $total_payout);
        }
        
        return $data;
    }
    
    function bulanan() {
        $data = array();
        $date_default = date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y")));
        $date_start = $this->uri->segment(6, $date_default);
        
        $arr_bonus = $this->mlm_function->get_arr_active_bonus();
        $x = 0;
        foreach($arr_bonus as $arr_bonus_item) {
            $data['payout']['series'][$x]['name'] = str_replace('Bonus', '', $arr_bonus_item['label']);
            $data['transfer']['series'][$x]['name'] = str_replace('Bonus', '', $arr_bonus_item['label']);
            $data['total_payout']['series'][0]['data'][$x][0] = str_replace('Bonus', '', $arr_bonus_item['label']);
            $data['total_payout']['series'][0]['data'][$x][1] = 0;
            $x++;
        }
        $data['profit']['series'][0]['name'] = 'Profit';
        
        $bulan = array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
        for($c=0;$c<12;$c++){
            $date = date("Y-m", strtotime("+$c month",strtotime($date_start)));
            $total_payout = $x = 0;
            foreach($arr_bonus as $arr_bonus_item) {
                $get_payout = $this->backend_charts_model->sum_payout($arr_bonus, $date, 'bulanan')->row_array();
                $data['payout']['categories'][$c] = $bulan[$c];
                $data['payout']['series'][$x]['data'][$c] = intval($get_payout['log_'.$arr_bonus_item['name']]);
                $total_payout += $get_payout['log_'.$arr_bonus_item['name']];
                $data['total_payout']['series'][0]['data'][$x][1] += intval($get_payout['log_'.$arr_bonus_item['name']]);
                
                $get_transfer = $this->backend_charts_model->sum_transfer($arr_bonus, $date, 'bulanan')->row_array();
                $data['transfer']['categories'][$c] = $bulan[$c];
                $data['transfer']['series'][$x]['data'][$c] = intval($get_transfer['transfer_'.$arr_bonus_item['name']]);
                $x++;
            }
            
            $data['total_payout_day']['categories'][$c] = $bulan[$c];
            $data['total_payout_day']['series'][0]['data'][$c] = intval($total_payout);
            
            $get_penggunaan = $this->backend_charts_model->sum_penggunaan($date, 'bulanan')->row_array();
            $data['profit']['categories'][$c] = $bulan[$c];
            $data['profit']['series'][0]['data'][$c] = intval($get_penggunaan['total_harga'] - $total_payout);
        }
        
        return $data;
    }
    
    function tahunan() {
        $data = array();
        $date_default = date("Y");
        $date_start = $this->uri->segment(6, $date_default);
        
        $arr_bonus = $this->mlm_function->get_arr_active_bonus();
        $x = 0;
        foreach($arr_bonus as $arr_bonus_item) {
            $data['payout']['series'][$x]['name'] = str_replace('Bonus', '', $arr_bonus_item['label']);
            $data['transfer']['series'][$x]['name'] = str_replace('Bonus', '', $arr_bonus_item['label']);
            $data['total_payout']['series'][0]['data'][$x][0] = str_replace('Bonus', '', $arr_bonus_item['label']);
            $data['total_payout']['series'][0]['data'][$x][1] = 0;
            $x++;
        }
        $data['profit']['series'][0]['name'] = 'Profit';
        
        for($c=2012;$c<$date_start;$c++){
            $date = date("Y", strtotime("+1 year",strtotime($c.'-01-01')));
            $total_payout = $x = 0;
            foreach($arr_bonus as $arr_bonus_item) {
                $get_payout = $this->backend_charts_model->sum_payout($arr_bonus, $date, 'tahunan')->row_array();
                $data['payout']['categories'][] = $date;
                $data['payout']['series'][$x]['data'][] = intval($get_payout['log_'.$arr_bonus_item['name']]);
                $total_payout += $get_payout['log_'.$arr_bonus_item['name']];
                $data['total_payout']['series'][0]['data'][$x][1] += intval($get_payout['log_'.$arr_bonus_item['name']]);
                
                $get_transfer = $this->backend_charts_model->sum_transfer($arr_bonus, $date, 'tahunan')->row_array();
                $data['transfer']['categories'][] = $date;
                $data['transfer']['series'][$x]['data'][] = intval($get_transfer['transfer_'.$arr_bonus_item['name']]);
                $x++;
            }
            
            $data['total_payout_day']['categories'][] = $date;
            $data['total_payout_day']['series'][0]['data'][] = intval($total_payout);
            
            $get_penggunaan = $this->backend_charts_model->sum_penggunaan($date, 'tahunan')->row_array();
            $data['profit']['categories'][] = $date;
            $data['profit']['series'][0]['data'][] = intval($get_penggunaan['total_harga'] - $total_payout);
        }
        
        return $data;
    }
}

?>
