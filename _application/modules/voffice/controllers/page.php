<?php

/*
 * Member Page Controller
 *
 * @author	@yonkz28
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Member_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('voffice/page_model');
        $this->load->helper('form');
    }
    
    function index(){
        $this->show();
    }
    
    function show(){
        $data['page_title'] = 'Data Pesan';
        $data['arr_breadcrumbs'] = array(
            'Data Pesan' => 'voffice/message/show',
        );
        
        template('member', 'voffice/message_list_view', $data);
    }
    
    function view() {
        $query = $this->page_model->get_page($this->uri->segment(4));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data['page_title'] = ($row->page_title != '') ? $row->page_title : '';
            $data['page_content'] = $row->page_content;
        } else {
            $data['page_title'] = 'Halaman tidak ditemukan';
            $data['page_content'] = 'Maaf, halaman tidak ditemukan.';
        }

        template('member', 'voffice/page_view', $data);
    }
}

?>
