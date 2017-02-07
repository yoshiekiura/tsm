<?php

/*
 * Backend Guestbook Controller
 *
 * @author	Ardiansyah Prasaja
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {
    
    function __construct() {
        parent::__construct();

        $this->load->model('guestbook/backend_guestbook_model');
        $this->load->helper('form');
    }
    
    function index() {
        $this->show();
    }
    
    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Buku Tamu' => 'backend/guestbook/show',
        );
               
        template('backend', 'guestbook/backend_guestbook_list_view', $data);
    }
    
    function detail() {
        $detail_id = $this->uri->segment(4);
        
        $data_update = array();
        $data_update['guestbook_is_read'] = '1';
        $this->function_lib->update_data('site_guestbook', 'guestbook_id', $detail_id, $data_update);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Buku Tamu' => 'backend/guestbook/show',
            'Detail Buku Tamu' => 'backend/guestbook/detail/' . $detail_id,
        );
        
        $data['query'] = $this->backend_guestbook_model->get_detail($detail_id);

        template('backend', 'guestbook/backend_guestbook_detail_view', $data);
    }
    
    function configuration() {
        $this->load->helper('tinymce');
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Konfigurasi Buku Tamu' => 'backend/guestbook/configuration',
        );
        
        $data['query'] = $this->backend_guestbook_model->get_list_configuration();
        $data['form_action'] = 'backend_service/guestbook/act_configuration';

        template('backend', 'guestbook/backend_guestbook_configuration_view', $data);
    }
}

?>
