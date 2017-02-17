<?php

/*
 * Backend Dashboard Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once(dirname(__FILE__) . "/backend_service.php");

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('backend_dashboard_model');
        $this->backend_service = new backend_service();
        $this->date = date('Y-m-d');
        $this->month = date('m');
        $this->year = date('Y');
    }

    public function index() {
        $this->show();
    }

    function show() {
        $data['grafik'] = $this->backend_service->get_data();

        $data['administrator_username'] = $this->session->userdata('administrator_username');
        $data['administrator_name'] = $this->session->userdata('administrator_name');
        $data['administrator_last_login'] = $this->session->userdata('administrator_last_login');
        $data['administrator_last_username'] = $this->session->userdata('administrator_last_username');
        $data['administrator_last_name'] = $this->session->userdata('administrator_last_name');
        $data['administrator_last_last_login'] = $this->session->userdata('administrator_last_last_login');
        
        // serial
        $data['count_serial'] = $this->backend_dashboard_model->get_total_serial();
        $data['count_serial_active'] = $this->backend_dashboard_model->get_total_serial_active();
        $data['count_serial_used'] = $this->backend_dashboard_model->get_total_serial_used();
        
        // member
        $data['count_member_all'] = $this->backend_dashboard_model->get_total_member();
        $data['count_member_monthly'] = $this->backend_dashboard_model->get_total_member($this->date, 'month');
        $data['count_member_weekly'] = $this->backend_dashboard_model->get_total_member($this->date, 'week');
        $data['count_member_daily'] = $this->backend_dashboard_model->get_total_member($this->date, 'day');

        // summary bonus
        $data['arr_total_bonus'] = $this->backend_dashboard_model->get_total_bonus();
        $data['arr_total_payout_monthly'] = $this->backend_dashboard_model->get_total_bonus_monthly($this->month, $this->year);
        
        // kalkulasi bonus hari ini
        $daily_bonus = $this->mlm_function->get_arr_active_bonus('daily');
        
        foreach ($daily_bonus as $daily_bonus_item) {
            $max_level = 0;
            $bonus_name = $daily_bonus_item['name'];
            $config_bonus_value = $daily_bonus_item['value'];

            if (is_array($daily_bonus_item['value'])) {
                $max_level = max(array_keys($daily_bonus_item['value']));
            }
            $bonus_function = 'calculate_bonus_'.$bonus_name.'_daily';
            $daily_bonus_calculation[$bonus_name]['label'] = $daily_bonus_item['label'];
            $daily_bonus_calculation[$bonus_name]['value'] = $this->backend_dashboard_model->$bonus_function($config_bonus_value, $max_level);
        }
        $data['arr_daily_bonus_calculation'] = $daily_bonus_calculation;

        // additional
        $data['today'] = $this->date;

        template('backend', 'dashboard/backend_dashboard_view', $data);
    }

    function detail_bonus() {
        $data['data'] = 'Ini halaman Detail';
        template('backend', 'dashboard/backend_detail_bonus_view', $data);
    }
    
}
