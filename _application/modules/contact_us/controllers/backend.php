<?php

/*
 * Backend Page Kontak Kami Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('backend_contact_us_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $this->load->helper('ckeditor');
        
        $data['arr_breadcrumbs'] = array(
            'Main' => '#',
            'Kontak Kami' => 'backend/contact_us/show',
        );
        
        $data['form_action'] = 'backend/contact_us/act_show';
        
        template('backend', 'contact_us/backend_contact_us_list_view', $data);
    }
    
    function add() {
        $this->load->helper('tinymce');
        
        $data['arr_breadcrumbs'] = array(
            'Kontak Kami' => 'backend/contact_us/show',
            'Tambah Kontak Kami' => 'backend/contact_us/add',
        );
        
        $data['form_action'] = 'backend_service/contact_us/act_add';

        template('backend', 'contact_us/backend_contact_us_add_view', $data);
    }
    
    function edit() {
        $this->load->helper('tinymce');
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Kontak Kami' => 'backend/contact_us/show',
            'Ubah Kontak Kami' => 'backend/contact_us/edit',
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_contact_us', 'contact_us_id', $edit_id);
        $data['form_action'] = 'backend_service/contact_us/act_edit';

        template('backend', 'contact_us/backend_contact_us_edit_view', $data);
    }
    
}

?>
