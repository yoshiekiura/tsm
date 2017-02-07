<?php

/*
 * Backend Catalog Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('catalog/backend_catalog_model');
        $this->load->helper('form');

        $this->file_dir = _dir_catalog;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 600;
        $this->image_height = 1000;
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Katalog' => 'backend/catalog/show',
        );
        
        template('backend', 'catalog/backend_catalog_list_view', $data);
    }

    function add() {
        $this->load->helper('tinymce');
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Katalog' => 'backend/catalog/show',
            'Tambah Katalog' => 'backend/catalog/add',
        );
        
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/catalog/act_add';
        
        template('backend', 'catalog/backend_catalog_add_view', $data);
    }

    function edit() {
        $this->load->helper('tinymce');
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Katalog' => 'backend/catalog/show',
            'Ubah Katalog' => 'backend/catalog/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_catalog', 'catalog_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/catalog/act_edit';

        template('backend', 'catalog/backend_catalog_edit_view', $data);
    }

}
