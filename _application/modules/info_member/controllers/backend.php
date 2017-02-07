<?php

/*
 * Backend News Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('info_member/backend_info_member_model');
        $this->load->helper('form');

        
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Dashboard Member' => '#',
            'Dashboard Member' => 'backend/info_member/show',
        );
        
        template('backend', 'info_member/backend_info_member_list_view', $data);
    }

    function add() {
        $this->load->helper('tinymce');
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Dashboard Member' => '#',
            'Dashboard Member' => 'backend/info_member/show',
            'Tambah Dashboard Member' => 'backend/info_member/add',
        );
        
        $data['form_action'] = 'backend_service/info_member/act_add';

        template('backend', 'info_member/backend_info_member_add_view', $data);
    }

    function edit() {
        $this->load->helper('tinymce');
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Dashboard Member' => '#',
            'Dashboard Member' => 'backend/info_member/show',
            'Ubah Dashboard Member' => 'backend/info_member/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_page_dashboard', 'page_dashboard_id', $edit_id);
        
        $data['form_action'] = 'backend_service/info_member/act_edit';

        template('backend', 'info_member/backend_info_member_edit_view', $data);
    }

}
