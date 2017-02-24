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
                    'cron_log_name' => $row->cron_log_name,
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

            $this->session->set_flashdata('data_send', $send);
        }
        redirect($this->input->post('uri_string'));
    }

    function get_data_otp($user='admin') {
        $params = isset($_POST) ? $_POST : array();
        if ($user == 'admin') {
            $prefix_column = 'administrator_access_otp_';
            $user_id = 'id';
            $user_name = 'administrator_name';
            $params['table'] = 'site_administrator_access_otp';
            $params['join'] = 'INNER JOIN site_administrator ON administrator_access_otp_id = administrator_id';
        } elseif ($user == 'member') {
            $prefix_column = 'member_access_otp_';
            $user_id = 'network_id';
            $user_name = 'member_name';
            $params['table'] = 'sys_member_access_otp';
            $params['join'] = 'INNER JOIN sys_member ON member_access_otp_network_id = member_network_id';
        }

        $params['select'] = $prefix_column .'id AS id, ' . 
                            $prefix_column . $user_id . ' AS user_id, ' . 
                            $user_name . ' AS user_name, ' . 
                            $prefix_column . 'code AS code, ' . 
                            $prefix_column . 'start_datetime AS start_datetime, ' . 
                            $prefix_column . 'expired_datetime AS expired_datetime';
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['rp']) ? $_POST['rp'] : 1;
        $numbering = ($page-1)*$limit;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            $entry = array('id' => $row->id,
                'cell' => array(
                    'no' => ++$numbering,
                    'user_id' => $row->user_id,
                    'user_name' => stripslashes($row->user_name),
                    'code' => $row->code,
                    'start_datetime' => date_converter($row->start_datetime, 'd F Y H:i:s'),
                    'expired_datetime' => date_converter($row->expired_datetime, 'd F Y H:i:s'),
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

}
