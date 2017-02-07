<?php

/*
 * Frontend Page Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('page/frontend_page_model');
    }

    function index() {
        $data['arr_breadcrumbs'] = array(
            'Page' => '#',
        );
        $query = $this->frontend_page_model->get_homepage();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data['page_title'] = ($row->page_home_title != '') ? $row->page_home_title : '';
            $data['page_content'] = $row->page_home_content;
        } else {
            $data['page_title'] = 'Halaman tidak ditemukan';
            $data['page_content'] = 'Maaf, halaman tidak ditemukan.';
        }
        
        template('frontend', 'page/frontend_page_home_view', $data);
    }

    function view() {
        $data['arr_breadcrumbs'] = array(
            'Page' => '#',
            'Detail Page' => '',
        );
        $query = $this->frontend_page_model->get_page($this->uri->segment(3));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data['page_title'] = ($row->page_title != '') ? $row->page_title : '';
            $data['page_content'] = $row->page_content;
        } else {
            $data['page_title'] = 'Halaman tidak ditemukan';
            $data['page_content'] = 'Maaf, halaman tidak ditemukan.';
        }

        template('frontend', 'page/frontend_page_view', $data);
    }

}
