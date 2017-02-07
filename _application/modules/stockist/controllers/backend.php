<?php

/*
 * Backend stockist Controller
 *
 * @author	Yudha Wirawan Sakti
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('stockist/backend_stockist_model');
        $this->load->helper('form');

        $this->file_dir = _dir_stockist;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 520;
        $this->image_height = 520;
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'stockist' => 'backend/stockist/show',
        );
        
        template('backend', 'stockist/backend_stockist_list_view', $data);
    }

    function add() {
        $this->load->helper('tinymce');
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'stockist' => 'backend/stockist/show',
            'Tambah stockist' => 'backend/stockist/add',
        );
        
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/stockist/act_add';

        template('backend', 'stockist/backend_stockist_add_view', $data);
    }

    function edit() {
        $this->load->helper('tinymce');
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'stockist' => 'backend/stockist/show',
            'Ubah stockist' => 'backend/stockist/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_stockist', 'stockist_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/stockist/act_edit';

        template('backend', 'stockist/backend_stockist_edit_view', $data);
    }

}
