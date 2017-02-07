<?php

/*
 * Backend Bonus Transfer Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('bonus_transfer/backend_bonus_transfer_model');
        $this->load->helper('form');
        $this->config->load('transfer');
        $this->config->load('bonus');
    }

    function index() {
        $this->show();
    }
    
    function show() {
        $data['arr_breadcrumbs'] = array(
            'Member' => '#',
            'Log Transfer Bonus' => 'backend/bonus_transfer/show',
        );
        
        $data['bank_grid_options'] = $this->function_lib->get_bank_grid_options();
        
        template('backend', 'bonus_transfer/backend_bonus_transfer_list_view', $data);
    }

    function add($category = '') {
        $arr_all_transfer_config = $this->config->item('transfer');
        $arr_all_bonus_config = $this->config->item('bonus');
        
        if($category != '' && array_key_exists($category, $arr_all_transfer_config)) {
            $arr_transfer_config = $arr_all_transfer_config[$category];
            
            $data['arr_breadcrumbs'] = array(
                'Member' => '#',
                'Rekap Bonus ' . $arr_transfer_config['title'] => 'backend/bonus_transfer/add/' . $category,
            );

            $data['bank_grid_options'] = $this->function_lib->get_bank_grid_options();
            $data['category'] = $category;
            $data['arr_transfer_config'] = $arr_transfer_config;
            $data['arr_all_bonus_config'] = $arr_all_bonus_config;

            template('backend', 'bonus_transfer/backend_bonus_transfer_add_view', $data);
        } else {
             $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Terdapat kesalahan dalam menampilkan halaman.</div>');
            redirect('backend/dashboard/show');
        }
    }
    
    function approve() {
        $data['arr_breadcrumbs'] = array(
            'Transfer Bonus' => '#',
            'Approval Transfer Bonus' => 'backend/bonus_transfer/approve',
        );

        $data['form_action'] = 'backend_service/bonus_transfer/act_approve';
        template('backend', 'bonus_transfer/backend_bonus_transfer_approve_view', $data);
    }

}
