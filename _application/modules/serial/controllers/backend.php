<?php

/*
 * Backend Serial Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('serial/backend_serial_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Serial' => '#',
            'Data Serial' => 'backend/serial/show',
        );
        
        $data['serial_type_grid_options'] = $this->mlm_function->get_serial_type_grid_options();
        $data['serial_type_count'] = $this->mlm_function->get_count_serial_type();
        
        template('backend', 'serial/backend_serial_list_view', $data);
    }
    
    function add() {
        // restrict non superuser group
        if ($this->session->userdata('administrator_group_type') != 'superuser') {
            redirect('backend/serial/show');
        }

        $data['arr_breadcrumbs'] = array(
            'Member' => '#',
            'Data Serial' => 'backend/serial/show',
            'Tambah Data Serial' => 'backend/serial/add',
        );
        
        $data['serial_type_options'] = $this->mlm_function->get_serial_type_options();
        $data['serial_type_count'] = $this->mlm_function->get_count_serial_type();
        $data['default_serial_type_id'] = $this->backend_serial_model->get_default_serial_type_id();
        
        $data['form_action'] = 'backend_service/serial/act_add';

        template('backend', 'serial/backend_serial_add_view', $data);
    }
    
    function buy() {
        $data['arr_breadcrumbs'] = array(
            'Serial' => '#',
            'Penjualan Serial' => 'backend/serial/buy',
        );
        
        $data['serial_type_grid_options'] = $this->mlm_function->get_serial_type_grid_options();
        $data['serial_type_count'] = $this->mlm_function->get_count_serial_type();
        
        template('backend', 'serial/backend_serial_buy_view', $data);
    }
    
    function price() {
        $data['arr_breadcrumbs'] = array(
            'Serial' => '#',
            'Harga Serial' => 'backend/serial/price',
        );
        
        $data['serial_type_grid_options'] = $this->mlm_function->get_serial_type_grid_options();
        
        template('backend', 'serial/backend_serial_price_list_view', $data);
    }
    
    function price_edit() {
        // restrict non superuser group
        if ($this->session->userdata('administrator_group_type') != 'superuser') {
            redirect('backend/serial/show');
        }
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Serial' => '#',
            'Harga Serial' => 'backend/serial/price',
            'Ubah Harga' => 'backend/serial/price_edit',
        );
        
        $data['query'] = $this->backend_serial_model->get_detail($edit_id);
        $data['form_action'] = 'backend_service/serial/act_price_edit';

        template('backend', 'serial/backend_serial_price_edit_view', $data);
    }

}
