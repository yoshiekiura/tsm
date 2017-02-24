<?php
/**
 * Backend Tools Controller
 *
 * @author      Fahrur Rifai <developer11@esoftdream.net>
 * @copyright   Copyright (c) 2017, Esoftdream.net
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('tools/backend_tools_model');
        $this->load->helper('form');
    }

    function index() {
        redirect('backend/tools/info_cron');
    }

    function info_cron() {
        $data['arr_breadcrumbs'] = array(
            'Tools' => '#',
            'Info Cron Log' => 'backend/cron/show',
        );
        
        template('backend', 'tools/backend_tools_cron_list_view', $data);
    }
    
    function info_member() {
        $data['arr_breadcrumbs'] = array(
            'Tools' => '#',
            'Cek Data Member' => 'backend/tools/info_member',
        );
        $data['form_action'] = base_url('backend_service/tools/act_check_member');;
        template('backend', 'tools/backend_tools_cek_data_view', $data);
    }

    function info_otp($user='admin') {
        if ($user != 'admin' && $user != 'member') {
            redirect('backend/tools/info_otp/admin');
        }

        $otp_active = false; 
        if ($user == 'admin') {
            // check if configuration is active
            if ($this->sys_configuration['otp_login_admin']) {
                $otp_active = true;
            }

        } elseif ($user == 'member') {
            if ($this->sys_configuration['otp_member_active']) {
                $otp_active = true;
            }
        }

        $data['arr_breadcrumbs'] = array(
            'Tools' => '#',
            'Info OTP ' . ucfirst($user) => 'backend/tools/info_otp/admin',
        );
        $data['title'] = 'Info OTP ' . ucfirst($user);
        $data['otp_active'] = $otp_active;
        $data['otp_user'] = $user;
        $data['get_data_url'] = $this->service_module_url . '/get_data_otp/' . $user;

        template('backend', 'tools/backend_tools_info_otp_view', $data);
    }

}
