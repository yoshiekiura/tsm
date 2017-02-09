<?php

/*
 * Backend Leader Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('leader/backend_leader_model');
        $this->load->helper('form');
        
        $this->file_dir = _dir_leader;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';

        //set width & height berdasarkan leader block
        $this->header_image_width = 250;
        $this->header_image_height = 250;
    }

    function index() {
        $this->show();
    }
    
    function show() {
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Pembimbing' => 'backend/leader/show',
        );
        
        template('backend', 'leader/backend_leader_list_view', $data);
    }

    function add($block = 'header') {
        switch($block) {
            default:
                $block_title = "Header";
                break;
        }
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Pembimbing' => 'backend/leader/show',
            'Tambah Pembimbing'=> 'backend/leader/add',
        );
        
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['form_action'] = 'backend_service/leader/act_add';
        
        template('backend', 'leader/backend_leader_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Pembimbing' => 'backend/leader/show',
            'Ubah' => 'backend/leader/edit',
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_leader', 'leader_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['form_action'] = 'backend_service/leader/act_edit';

        template('backend', 'leader/backend_leader_edit_view', $data);
    }

}
