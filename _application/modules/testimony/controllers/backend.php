<?php

/*
 * Backend Testimony Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('testimony/backend_testimony_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Testimoni' => 'backend/testimony/show',
        );
        
        template('backend', 'testimony/backend_testimony_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Testimoni' => 'backend/testimony/show',
            'Tambah Data Testimoni' => 'backend/testimony/add',
        );
        
        $data['form_action'] = 'backend_service/testimony/act_add';
        
        template('backend', 'testimony/backend_testimony_add_view', $data);
    }

    function edit() {
        $edit_category = $this->uri->segment(4);
        $edit_id = $this->uri->segment(5);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Testimoni' => 'backend/testimony/show',
            'Ubah Data Testimoni' => 'backend/testimony/edit/' . $edit_id,
        );
        
        if($edit_category == 'member') {
            $data['query'] = $this->backend_testimony_model->get_detail($edit_id);
        } else {
            $data['query'] = $this->function_lib->get_detail_data('site_testimony', 'testimony_id', $edit_id);
        }
        $data['category'] = $edit_category;
        $data['form_action'] = 'backend_service/testimony/act_edit';

        template('backend', 'testimony/backend_testimony_edit_view', $data);
    }
    
    function approve() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Testimoni' => 'backend/testimony/show',
            'Approval Testimoni' => 'backend/testimony/approve',
        );

        template('backend', 'testimony/backend_testimony_approve_view', $data);
    }

}
