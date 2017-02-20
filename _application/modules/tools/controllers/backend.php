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

}
