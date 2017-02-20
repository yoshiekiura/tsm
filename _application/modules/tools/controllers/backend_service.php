<?php
/**
 * Backend Tools Controller
 *
 * @author      Fahrur Rifai <developer11@esoftdream.net>
 * @copyright   Copyright (c) 2017, Esoftdream.net
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }

    function get_data_cron() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "cron_log";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rp']) ? $_POST['rp'] : 10;
        $number = ($page-1)*$limit;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            $entry = array('id' => $row->cron_log_id,
                'cell' => array(
                    'no' => ++$number,
                    'cron_id' => $row->cron_log_id,
                    'cron_title' => $row->cron_log_name,
                    'cron_log_date' => convert_datetime($row->cron_log_date, 'id'),
                    'cron_log_run_datetime' => convert_datetime($row->cron_log_run_datetime, 'id'),
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_check_member() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('member_code', '<b>Kode Member</b>', 'required');
        $this->session->set_flashdata('input_member_code', $this->input->post('member_code'));
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
        } else {
            $send['network_code'] = $this->input->post('member_code');
            $send['network_id'] = $this->function_lib->get_one('sys_network', 'network_id', array('network_code'=>$send['network_code']));

            if (empty($send['network_id']) OR $send['network_id'] == '') {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><strong>Member</strong> tidak ditemukan.</div>');
                redirect($this->input->post('uri_string'));
                exit();
            }

            $send['sponsor_network_id'] = $this->function_lib->get_one('sys_network', 'network_sponsor_network_id', 'network_id =' . $send['network_id']);
            $send['sponsor_network_code'] = $this->function_lib->get_one('sys_network', 'network_code', 'network_id =' . $send['sponsor_network_id']);
            $send['upline_network_id'] = $this->function_lib->get_one('sys_network', 'network_upline_network_id', 'network_id =' . $send['network_id']);
            $send['upline_network_code'] = $this->function_lib->get_one('sys_network', 'network_code', 'network_id =' . $send['upline_network_id']);

            $send['data_bonus'] = $this->function_lib->get_detail_data('sys_bonus', 'bonus_network_id', $send['network_id'])->row();
            $send['arr_bonus_active'] = $this->mlm_function->get_arr_active_bonus();
            
            $this->session->set_flashdata('data_send', $send);
        }
        redirect($this->input->post('uri_string'));
    }

}
