<?php

/*
 * Backend Service Dashboard Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('backend_dashboard_model');
    }

    function get_data() {
        $data = array();
        $date['start'] = date("Y-m-d", strtotime('-7 day', strtotime(date("Y-m-d"))));
        $date['end'] = date("Y-m-d");

        $data['member']['series'][0]['name'] = 'Member';
        for ($c = 0; $c <= 6; $c++) {
            $date_now = date("Y-m-d", strtotime("+$c day", strtotime($date['start'])));
            $get_penggunaan = $this->backend_dashboard_model->sum_penggunaan_serial($date_now)->row_array();
            $data['member']['categories'][$c] = $date_now;
            $data['member']['series'][0]['data'][$c] = intval($get_penggunaan['total']);
        }

        $total_member = $this->backend_dashboard_model->get_total_member();
        $data['statistik']['categories'][0] = 'Total Member';
        $data['statistik']['series'][0]['data'][0] = intval($total_member);

        $total_serial_aktive = $this->backend_dashboard_model->get_total_serial_active();
        $data['statistik']['categories'][1] = 'Total Serial Aktif';
        $data['statistik']['series'][0]['data'][1] = intval($total_serial_aktive);

        $total_serial = $this->backend_dashboard_model->get_total_serial();
        $data['statistik']['categories'][2] = 'Total Serial';
        $data['statistik']['series'][0]['data'][2] = intval($total_serial);

        $x = 0;
        $arr_bonus = $this->mlm_function->get_arr_active_bonus();
        $get_bonus = $this->backend_dashboard_model->sum_bonus_log($arr_bonus, $date)->row_array();
        $get_transfer = $this->backend_dashboard_model->sum_transfer($arr_bonus, $date)->row_array();
        foreach ($arr_bonus as $arr_bonus_item) {
            $data['bonus']['series'][0]['data'][$x][0] = str_replace('Bonus ', '', $arr_bonus_item['label']);
            $data['bonus']['series'][0]['data'][$x][1] = intval($get_bonus['log_' . $arr_bonus_item['name']]);
            $data['transfer']['series'][0]['data'][$x][0] = str_replace('Bonus ', '', $arr_bonus_item['label']);
            $data['transfer']['series'][0]['data'][$x][1] = intval($get_transfer['transfer_' . $arr_bonus_item['name']]);
            $x++;
        }

        return $data;
    }

    function get_data_detail() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "sys_bonus";
        $params['join'] = "INNER JOIN sys_network ON network_id = bonus_network_id";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            $entry = array('id' => $row->bonus_network_id,
                'cell' => array(
                    'bonus_network_id' => $row->bonus_network_id,
                    'network_code' => $row->network_code,
                    'bonus_sponsor_acc' => $this->function_lib->set_number_format($row->bonus_sponsor_acc),
                    'bonus_gen_sponsor_acc' => $this->function_lib->set_number_format($row->bonus_gen_sponsor_acc),
                    'bonus_profit_sharing_acc' => $this->function_lib->set_number_format($row->bonus_profit_sharing_acc),
                    'bonus_royalty_payment_acc' => $this->function_lib->set_number_format($row->bonus_royalty_payment_acc)
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function get_summary_data() {
        $arr_output = array();
        $arr_output['arr_data'] = '';

        $params = isset($_POST) ? $_POST : array();
        $query = $this->backend_income_model->get_summary_income_data($params);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $arr_output['arr_data'] = $result;
        }

        echo json_encode($arr_output);
    }

}
