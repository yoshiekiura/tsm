<?php
/**
 * Service API Serial Controller
 *
 * @author      Fahrur Rifai <developer11@esoftdream.net>
 * @copyright   Copyright (c) 2017, Esoftdream.net
 */
class Serial extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('service_api/service_serial_model');
        $this->load->config->load('key');
        $this->api_key = $this->config->item('key_api');

        $this->year = date("Y");
        $this->month = date("m");
        $this->datetime = date("Y-m-d H:i:s");
    }

    private function is_valid_key($key) {
        $response = array();
        if ($key === $this->api_key) {
            $response['status'] = true;
            $response['message'] = 'Valid Key';
        } else {
            $response['status'] = false;
            $response['message'] = 'Invalid Key';
        }
        return $response;
    }

    public function info() {
        $api_key = $this->input->get('key') ? $this->input->get('key') : '';
        $request_error = false;
        $month = $this->input->get('month') ? $this->input->get('month', TRUE) : $this->month;
        $year = $this->input->get('year') ? $this->input->get('year', TRUE) : $this->year;
        
        $api_response = $this->is_valid_key($api_key);

        if ($api_response['status'] == FALSE) {
            $arr_output['status'] = 400;
            $arr_output['message'] = $api_response['message'];
            $request_error = true;
        }

        if (($month > 12) || $month < 1 || !is_numeric($month)) {
            $arr_output['status'] = 400;
            $arr_output['message'] = 'Bad Request. Invalid month';
            $request_error = true;
        }

        $data_result = $this->service_serial_model->get_serial_info($year, $month);
        if ( ! $request_error) {
            $arr_output['status'] = 200;
            $arr_output['data'] = $data_result;
        }

        set_status_header($arr_output['status']); // set server status header
        $this->output->set_content_type('json');
        echo json_encode($arr_output);
        
    }

}
