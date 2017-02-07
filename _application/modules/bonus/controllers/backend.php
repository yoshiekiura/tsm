<?php

/*
 * Backend Bonus Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bonus/backend_bonus_model');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Member' => '#',
            'Bonus Member' => 'backend/bonus/show',
        );
        
        $data['bank_grid_options'] = $this->function_lib->get_bank_grid_options();
        $data['arr_active_bonus'] = $this->mlm_function->get_arr_active_bonus();
        
        template('backend', 'bonus/backend_bonus_list_view', $data);
    }

}
