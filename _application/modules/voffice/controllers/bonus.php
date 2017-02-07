<?php

/*
 * Member Bonus Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bonus extends Member_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('voffice/bonus_model');
    }
    
    public function index() {
        $this->show();
    }
    
    function show() {
        $data['page_title'] = 'Status Komisi';
        $data['arr_breadcrumbs'] = array(
            'Komisi' => '#',
            'Status Komisi' => 'voffice/bonus/show',
        );
        
        $data['arr_active_bonus'] = $this->mlm_function->get_arr_active_bonus();
        template('member', 'voffice/bonus_main_view', $data);
    }
    
    function log() {
        $data['page_title'] = 'History Komisi';
        $data['arr_breadcrumbs'] = array(
            'Komisi' => '#',
            'History Komisi' => 'voffice/bonus/log',
        );
        
        $data['arr_active_bonus'] = $this->mlm_function->get_arr_active_bonus();
        template('member', 'voffice/bonus_log_view', $data);
    }
    
    function get_log_data() {
        $arr_active_bonus = $this->mlm_function->get_arr_active_bonus();
        $params = isset($_POST) ? $_POST : array();
        $query = $this->bonus_model->get_query_log_data($this->session->userdata('network_id'), $params);
        $total = $this->bonus_model->get_query_log_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {
            
            $entry = array('id' => $row->bonus_log_id,
                'cell' => array(
                    'bonus_log_date' => convert_date($row->bonus_log_date, 'id'),
                    'bonus_log_total' => $this->function_lib->set_number_format($row->bonus_log_total),
                ),
            );
            
            if(is_array($arr_active_bonus)) {
                foreach($arr_active_bonus as $bonus_item) {
                    $field = 'bonus_log_' . $bonus_item['name'];
                    $entry['cell'][$field] = $this->function_lib->set_number_format($row->$field);
                }
            }
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_log_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'History Komisi';
        $data['query'] = $this->bonus_model->get_query_log_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function export_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'History Komisi';
        $data['query'] = $this->bonus_model->get_query_transfer_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function transfer() {
        $data['page_title'] = 'History Transfer';
        $data['arr_breadcrumbs'] = array(
            'Komisi' => '#',
            'History Transfer' => 'voffice/bonus/transfer',
        );
        
        $data['transfer_category_grid_options'] = $this->mlm_function->get_transfer_category_grid_options();
        template('member', 'voffice/bonus_transfer_view', $data);
    }
    
    function get_transfer_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->bonus_model->get_query_transfer_data($this->session->userdata('network_id'), $params);
        $total = $this->bonus_model->get_query_transfer_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {
            
            //detail
            $detail = '<a href="' . base_url() . 'voffice/bonus/transfer_detail/' . base64_encode($row->bonus_transfer_code) . '" target="_blank"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Data Detail" title="Lihat Data Detail" /></a>';
            
            //print
            $print = '<a href="' . base_url() . 'voffice/bonus/transfer_print/' . base64_encode($row->bonus_transfer_code) . '" target="_blank"><img src="' . base_url() . _dir_icon . 'printer.png" border="0" alt="Cetak" title="Cetak" /></a>';
            
            $entry = array('id' => $row->bonus_transfer_id,
                'cell' => array(
                    'bonus_transfer_code' => $row->bonus_transfer_code,
                    'bonus_transfer_category_label' => $row->bonus_transfer_category_label,
                    'bonus_transfer_datetime' => convert_datetime($row->bonus_transfer_datetime, 'id'),
                    'bonus_transfer_status_label' => $row->bonus_transfer_status_label,
                    'bonus_transfer_note' => $row->bonus_transfer_note,
                    'bonus_transfer_nett' => $this->function_lib->set_number_format($row->bonus_transfer_nett),
                    'detail' => $detail,
                    'print' => $print,
                ),
            );
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_transfer_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        $data = array();
        $data['title'] = 'History Transfer ' . $this->session->userdata('network_code');
        $data['query'] = $this->bonus_model->get_query_transfer_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function transfer_detail() {
        $transfer_code = $this->uri->segment(4);
        if($transfer_code != '') {
            $transfer_code = base64_decode($transfer_code);
        }
        
        $data['arr_breadcrumbs'] = array(
            'Komisi' => '#',
            'History Transfer' => 'voffice/bonus/transfer',
            'Detail Transfer' => 'voffice/bonus/transfer_detail/' . base64_encode($transfer_code),
        );
        
        $bonus_transfer_id = $this->function_lib->get_one("sys_bonus_transfer", "bonus_transfer_id", "bonus_transfer_code = '" . $transfer_code . "' AND bonus_transfer_network_id = '" . $this->session->userdata('network_id') . "'");
        if($bonus_transfer_id != '') {
            $data['query'] = $this->function_lib->get_detail_data("sys_bonus_transfer", "bonus_transfer_id", $bonus_transfer_id);
            
            $bonus_transfer_datetime = $this->function_lib->get_one("sys_bonus_transfer", "bonus_transfer_datetime", "bonus_transfer_id = '" . $bonus_transfer_id . "'");
            $data['arr_bonus'] = $this->mlm_function->get_arr_transfer_bonus_active($bonus_transfer_datetime);
            $data['query_detail'] = $this->bonus_model->get_detail_bonus_transfer_detail($bonus_transfer_id, $data['arr_bonus']);
        }
        
        template('member', 'voffice/bonus_transfer_detail_view', $data);
    }
    
    function transfer_print() {
        $transfer_code = $this->uri->segment(4);
        if($transfer_code != '') {
            $transfer_code = base64_decode($transfer_code);
        }
        
        $data['arr_breadcrumbs'] = array(
            'Komisi' => '#',
            'History Transfer' => 'voffice/bonus/transfer',
            'Detail Transfer' => 'voffice/bonus/transfer_detail/' . base64_encode($transfer_code),
        );
        
        $bonus_transfer_id = $this->function_lib->get_one("sys_bonus_transfer", "bonus_transfer_id", "bonus_transfer_code = '" . $transfer_code . "' AND bonus_transfer_network_id = '" . $this->session->userdata('network_id') . "'");
        if($bonus_transfer_id != '') {
            $data['query'] = $this->function_lib->get_detail_data("sys_bonus_transfer", "bonus_transfer_id", $bonus_transfer_id);
            
            $bonus_transfer_datetime = $this->function_lib->get_one("sys_bonus_transfer", "bonus_transfer_datetime", "bonus_transfer_id = '" . $bonus_transfer_id . "'");
            $data['arr_bonus'] = $this->mlm_function->get_arr_transfer_bonus_active($bonus_transfer_datetime);
            $data['query_detail'] = $this->bonus_model->get_detail_bonus_transfer_detail($bonus_transfer_id, $data['arr_bonus']);
        }
        
        template('blank', 'voffice/bonus_transfer_print_view', $data);
    }

}