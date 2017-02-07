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

        $this->load->model('event/backend_event_model');
        $this->load->helper('form');

        $this->file_dir = _dir_event;
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
            'Event' => 'backend/event/show',
        );
        
        template('backend', 'event/backend_event_list_view', $data);
    }

    function add() {
        $this->load->helper('tinymce');
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Event' => 'backend/event/show',
            'Tambah Event' => 'backend/event/add',
        );
        
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/event/act_add';

        template('backend', 'event/backend_event_add_view', $data);
    }

    function edit() {
        $this->load->helper('tinymce');
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Event' => 'backend/event/show',
            'Ubah Event' => 'backend/event/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_event', 'event_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/event/act_edit';

        template('backend', 'event/backend_event_edit_view', $data);
    }

}
