<?php

/*
 * Backend Bank Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('bank/backend_bank_model');
        $this->load->helper('form');

        $this->file_dir = _dir_bank;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 200;
        $this->image_height = 75;
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Bank' => 'backend/bank/show',
        );
        
        template('backend', 'bank/backend_bank_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Bank' => 'backend/bank/show',
            'Tambah Data Bank' => 'backend/bank/add',
        );
        
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/bank/act_add';
        
        template('backend', 'bank/backend_bank_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Bank' => 'backend/bank/show',
            'Ubah Data Bank' => 'backend/bank/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('ref_bank', 'bank_id', $edit_id);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/bank/act_edit';

        template('backend', 'bank/backend_bank_edit_view', $data);
    }

}
