<?php

/*
 * Backend Downloads Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('downloads/backend_downloads_model');
        $this->load->helper('form');
        
        $this->file_dir = _dir_downloads;
        $this->allowed_file_type = 'pdf|docx|xls|xlsx|ppt|pptx|pps|ppsx|rar|zip|jpg|jpeg|png';
        $this->max_file = 980240; //The maximum size (in kilobytes)
        //byte converter http://www.whatsabyte.com/P1/byteconverter.htm
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Download File' => 'backend/downloads/show',
        );
        
        template('backend', 'downloads/backend_downloads_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Download File' => 'backend/downloads/show',
            'Tambah Data Download File' => 'backend/downloads/add',
        );
        
        $location_options = array();
        $location_options['public'] = 'Umum';
        $location_options['member'] = 'Member';
        $data['location_options'] = $location_options;
        
        $data['max_file'] = $this->max_file;
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['form_action'] = 'backend_service/downloads/act_add';
        
        template('backend', 'downloads/backend_downloads_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Download File' => 'backend/downloads/show',
            'Ubah Data Download File' => 'backend/downloads/edit/' . $edit_id,
        );
        
        $location_options = array();
        $location_options['public'] = 'Umum';
        $location_options['member'] = 'Member';
        $data['location_options'] = $location_options;
        
        $data['query'] = $this->function_lib->get_detail_data('site_downloads', 'downloads_id', $edit_id);
        $data['max_file'] = $this->max_file;
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['form_action'] = 'backend_service/downloads/act_edit';

        template('backend', 'downloads/backend_downloads_edit_view', $data);
    }

}
