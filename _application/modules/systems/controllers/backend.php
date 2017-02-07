<?php

/*
 * Backend Systems Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('systems/backend_systems_model');
        $this->load->helper('form');
        
        $this->image_width = 96;
        $this->image_height = 96;
    }

    function index() {
        $this->profile();
    }
    
    function profile() {
        $data['arr_breadcrumbs'] = array(
            'My Profile' => 'backend/systems/profile',
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_administrator', 'administrator_id', $this->session->userdata('administrator_id'));
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/systems/act_profile';

        template('backend', 'systems/backend_profile_edit_view', $data);
    }

    function password() {
        $data['arr_breadcrumbs'] = array(
            'Ubah Password' => 'backend/systems/password',
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_administrator', 'administrator_id', $this->session->userdata('administrator_id'));
        $data['form_action'] = 'backend_service/systems/act_password';

        template('backend', 'systems/backend_password_edit_view', $data);
    }

}
