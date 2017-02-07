<?php

/*
 * Backend Service Bonus Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bonus/backend_bonus_model');
    }

    function get_data() {
        $arr_active_bonus = $this->mlm_function->get_arr_active_bonus();
        
        $params = isset($_POST) ? $_POST : array();
        $query = $this->backend_bonus_model->get_query_bonus_data($params);
        $total = $this->backend_bonus_model->get_query_bonus_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        
        foreach ($query->result() as $row) {

            //is_active
            if ($row->member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->network_id,
                'cell' => array(
                    'network_id' => $row->network_id,
                    'network_code' => $row->network_code,
                    'member_name' => $row->member_name,
                    'member_nickname' => $row->member_nickname,
                    'member_phone' => $row->member_phone,
                    'member_mobilephone' => $row->member_mobilephone,
                    'member_join_datetime' => convert_datetime($row->member_join_datetime, 'id'),
                    'bank_name' => $row->bank_name,
                    'member_bank_city' => $row->member_bank_city,
                    'member_bank_branch' => $row->member_bank_branch,
                    'member_bank_account_name' => $row->member_bank_account_name,
                    'member_bank_account_no' => $row->member_bank_account_no,
                    'member_is_active' => $is_active,
                    'bonus_total_in' => $this->function_lib->set_number_format($row->bonus_total_in),
                    'bonus_total_out' => $this->function_lib->set_number_format($row->bonus_total_out),
                    'bonus_total_saldo' => $this->function_lib->set_number_format($row->bonus_total_saldo),
                ),
            );
            
            if(is_array($arr_active_bonus)) {
                foreach($arr_active_bonus as $bonus_item) {
                    $field_in = 'bonus_' . $bonus_item['name'] . '_in';
                    $field_out = 'bonus_' . $bonus_item['name'] . '_out';
                    $field_saldo = 'bonus_' . $bonus_item['name'] . '_saldo';
                    
                    $entry['cell'][$field_in] = $this->function_lib->set_number_format($row->$field_in);
                    $entry['cell'][$field_out] = $this->function_lib->set_number_format($row->$field_out);
                    $entry['cell'][$field_saldo] = $this->function_lib->set_number_format($row->$field_saldo);
                }
            }
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function export_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'Data Bonus Member';
        $data['params'] = $params;
        $data['query'] = $this->backend_bonus_model->get_query_bonus_data($params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }

}
