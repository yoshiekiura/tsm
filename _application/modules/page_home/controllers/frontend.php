<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of frontend
 *
 * @author Yusuf Rahmanto
 */
class frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('page/frontend_page_model');
    }

    function index() {
        $this->view();
    }

    function view() {
        $query = $this->function_lib->get_detail_data('site_page_home', 'page_home_id', $this->uri->segment(3));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data['page_title'] = ($row->page_home_title != '') ? $row->page_home_title : '';
            $data['page_content'] = $row->page_home_content;
        } else {
            $data['page_title'] = 'Halaman tidak ditemukan';
            $data['page_content'] = 'Maaf, halaman tidak ditemukan.';
        }

        template('frontend', 'page_home/frontend_page_home_view', $data);
    }
}

?>
