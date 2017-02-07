<?php

/*
 * Backend Catalog_item Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('catalog_item/backend_catalog_item_model');
        $this->load->helper('form');

        $this->file_dir = _dir_catalog_item;
        $this->file_dir_item = _dir_catalog_item_detail;
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
            'Katalog Item' => 'backend/catalog_item/show',
        );
        
        template('backend', 'catalog_item/backend_catalog_item_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Katalog Item' => 'backend/catalog_item/show',
            'Tambah Katalog Item' => 'backend/catalog_item/add',
        );
        
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/catalog_item/act_add';
        
        template('backend', 'catalog_item/backend_catalog_item_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Katalog Item' => 'backend/catalog_item/show',
            'Ubah Katalog Item' => 'backend/catalog_item/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_catalog_item', 'catalog_item_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/catalog_item/act_edit';

        template('backend', 'catalog_item/backend_catalog_item_edit_view', $data);
    }
    
    function item_show($catalog_item_id = 0) {
        $catalog_item_title = $this->function_lib->get_one('site_catalog_item', 'catalog_item_title', array('catalog_item_id' => $catalog_item_id));
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Katalog Item' => 'backend/catalog_item/show',
            'Katalog Item Detail &raquo; ' . $catalog_item_title => 'backend/catalog_item/item_show/' . $catalog_item_id,
        );
        
        $data['catalog_item_id'] = $catalog_item_id;
        $data['catalog_item_title'] = $catalog_item_title;
        if($catalog_item_id == 0 || $catalog_item_title == '') {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Data Katalog Item Detail tidak ditemukan.</div>');
            redirect('backend/catalog_item/show');
        }
        
        template('backend', 'catalog_item/backend_catalog_item_detail_list_view', $data);
    }

    function item_add($catalog_item_id = 0) {
        $catalog_item_title = $this->function_lib->get_one('site_catalog_item', 'catalog_item_title', array('catalog_item_id' => $catalog_item_id));
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Katalog Item' => 'backend/catalog_item/show',
            'Katalog Item Detail &raquo; ' . $catalog_item_title => 'backend/catalog_item/item_show/' . $catalog_item_id,
            'Tambah Katalog Item Detail' => 'backend/catalog_item/item_add/' . $catalog_item_id,
        );
        
        $data['catalog_item_id'] = $catalog_item_id;
        $data['catalog_item_title'] = $catalog_item_title;
        if($catalog_item_id == 0 || $catalog_item_title == '') {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Data Katalog Item Detail tidak ditemukan.</div>');
            redirect('backend/catalog_item/show');
        }
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/catalog_item/act_item_add';
        
        template('backend', 'catalog_item/backend_catalog_item_detail_add_view', $data);
    }

    function item_edit() {
        $edit_id = $this->uri->segment(4);
        $catalog_item_detail_id = $this->function_lib->get_one('site_catalog_item_detail', 'catalog_item_detail_item_id', (array('catalog_item_detail_id' => $edit_id)));
        $catalog_item_title = $this->function_lib->get_one('site_catalog_item', 'catalog_item_title', array('catalog_item_id' => $catalog_item_detail_id));
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Katalog Item' => 'backend/catalog_item/show',
            'Katalog Item Detail &raquo; ' . $catalog_item_title => 'backend/catalog_item/item_show/' . $catalog_item_detail_id,
            'Ubah Katalog Item Detail' => 'backend/catalog_item/item_edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_catalog_item_detail', 'catalog_item_detail_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/catalog_item/act_item_edit';

        template('backend', 'catalog_item/backend_catalog_item_detail_edit_view', $data);
    }

}
