<?php

/*
 * Backend Systems Configuration Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('sys_configuration/backend_sys_configuration_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }
    
    function show() {
        $data['arr_breadcrumbs'] = array(
            'Konfigurasi Sistem' => 'backend/sys_configuration/show',
        );
        
        $data['query'] = $this->backend_sys_configuration_model->get_list();
        $data['form_action'] = 'backend_service/sys_configuration/act_show';

        template('backend', 'sys_configuration/backend_sys_configuration_view', $data);
    }

}
