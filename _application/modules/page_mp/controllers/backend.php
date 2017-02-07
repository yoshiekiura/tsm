<?php

/*
 * Backend Page Marketing Plan Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('backend_page_mp_model');
        $this->load->helper('form');
        $this->file_dir = _dir_marketing_plan;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 1600;
        $this->image_height = 1600;
    }

    function index() {
        $this->show();
    }

    function show() {
        $this->load->helper('ckeditor');

        $data['arr_breadcrumbs'] = array(
            'Main' => '#',
            'Marketing Plan' => 'backend/page_mp/show',
        );

        $data['form_action'] = 'backend/page_home/act_show';
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;

        template('backend', 'page_mp/backend_page_mp_list_view', $data);
    }

    function add() {
        $this->load->helper('tinymce');

        $data['arr_breadcrumbs'] = array(
            'Marketing Plan' => 'backend/page_mp/show',
            'Tambah Marketing Plan' => 'backend/page_mp/add',
        );

        $data['form_action'] = 'backend_service/page_mp/act_add';

        template('backend', 'page_mp/backend_page_mp_add_view', $data);
    }

    function edit() {
        $this->load->helper('tinymce');
        $edit_id = $this->uri->segment(4);

        $data['arr_breadcrumbs'] = array(
            'Marketing Plan' => 'backend/page_mp/show',
            'Ubah Marketing Plan' => 'backend/page_mp/edit',
        );

        $data['query'] = $this->function_lib->get_detail_data('site_page_mp', 'page_mp_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/page_mp/act_edit';

        template('backend', 'page_mp/backend_page_mp_edit_view', $data);
    }

}

?>
