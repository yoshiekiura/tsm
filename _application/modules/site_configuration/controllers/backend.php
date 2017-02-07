<?php

/*
 * Backend Site Configuration Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('site_configuration/backend_site_configuration_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }
    
    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Konfigurasi Web' => 'backend/site_configuration/show',
        );
        
        $data['query'] = $this->backend_site_configuration_model->get_list();
        $data['form_action'] = 'backend_service/site_configuration/act_show';

        template('backend', 'site_configuration/backend_site_configuration_view', $data);
    }

}
