<?php

/*
 * Backend Gallery Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('gallery/backend_gallery_model');
        $this->load->helper('form');

        $this->file_dir = _dir_gallery;
        $this->file_dir_item = _dir_gallery_item;
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
            'Galeri' => 'backend/gallery/show',
        );
        
        template('backend', 'gallery/backend_gallery_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Galeri' => 'backend/gallery/show',
            'Tambah Galeri' => 'backend/gallery/add',
        );
        
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/gallery/act_add';
        
        template('backend', 'gallery/backend_gallery_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Galeri' => 'backend/gallery/show',
            'Ubah Galeri' => 'backend/gallery/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_gallery', 'gallery_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/gallery/act_edit';

        template('backend', 'gallery/backend_gallery_edit_view', $data);
    }
    
    function item_show($gallery_id = 0) {
        $gallery_title = $this->function_lib->get_one('site_gallery', 'gallery_title', array('gallery_id' => $gallery_id));
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Galeri' => 'backend/gallery/show',
            'Galeri Item &raquo; ' . $gallery_title => 'backend/gallery/item_show/' . $gallery_id,
        );
        
        $data['gallery_id'] = $gallery_id;
        $data['gallery_title'] = $gallery_title;
        if($gallery_id == 0 || $gallery_title == '') {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Data Galeri Item tidak ditemukan.</div>');
            redirect('backend/gallery/show');
        }
        
        template('backend', 'gallery/backend_gallery_item_list_view', $data);
    }

    function item_add($gallery_id = 0) {
        $gallery_title = $this->function_lib->get_one('site_gallery', 'gallery_title', array('gallery_id' => $gallery_id));
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Galeri' => 'backend/gallery/show',
            'Galeri Item &raquo; ' . $gallery_title => 'backend/gallery/item_show/' . $gallery_id,
            'Tambah Galeri Item' => 'backend/gallery/item_add/' . $gallery_id,
        );
        
        $data['gallery_id'] = $gallery_id;
        $data['gallery_title'] = $gallery_title;
        if($gallery_id == 0 || $gallery_title == '') {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Data Galeri Item tidak ditemukan.</div>');
            redirect('backend/gallery/show');
        }
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/gallery/act_item_add';
        
        template('backend', 'gallery/backend_gallery_item_add_view', $data);
    }

    function item_edit() {
        $edit_id = $this->uri->segment(4);
        $gallery_id = $this->function_lib->get_one('site_gallery_item', 'gallery_item_gallery_id', (array('gallery_item_id' => $edit_id)));
        $gallery_title = $this->function_lib->get_one('site_gallery', 'gallery_title', array('gallery_id' => $gallery_id));
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Galeri' => 'backend/gallery/show',
            'Galeri Item &raquo; ' . $gallery_title => 'backend/gallery/item_show/' . $gallery_id,
            'Ubah Galeri Item' => 'backend/gallery/item_edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_gallery_item', 'gallery_item_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/gallery/act_item_edit';

        template('backend', 'gallery/backend_gallery_item_edit_view', $data);
    }

}
