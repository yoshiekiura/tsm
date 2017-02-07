<?php

/*
 * Backend Page Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('page_member/backend_page_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Halaman Member' => 'backend/page_member/show',
        );
        
        template('backend', 'page_member/backend_page_list_view', $data);
    }

    function add() {
        $this->load->helper('tinymce');
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Halaman Member' => 'backend/page_member/show',
            'Tambah Halaman Member' => 'backend/page_member/add',
        );
        
        
        $data['form_action'] = 'backend_service/page_member/act_add';

        template('backend', 'page_member/backend_page_add_view', $data);
    }

    function edit() {
        $this->load->helper('tinymce');
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Halaman Member' => 'backend/page_member/show',
            'Ubah Halaman Member' => 'backend/page_member/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_page_member', 'page_id', $edit_id);
        $data['form_action'] = 'backend_service/page_member/act_edit';

        template('backend', 'page_member/backend_page_edit_view', $data);
    }

}

