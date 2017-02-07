<?php

/*
 * Frontend stockist Controller
 *
 * @author	Yudha Wirawan Sakti
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('frontend_stockist_model');
    }

    public function index() {
         $data['arr_breadcrumbs'] = array(
            'Data Stockist' => '#',
            'Stockist' => '',
        );
        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 6;
        $config['base_url'] = site_url('stockist/index');
        $config['total_rows'] = $this->frontend_stockist_model->get_stockist_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Stockist';
        $data['query'] = $this->frontend_stockist_model->get_stockist_list($offset, $limit);

        template('frontend', 'stockist/frontend_stockist_list_view', $data);
    }

//    public function show() {
//        $this->load->library('pagination');
//
//        //pagination
//        $offset = (int) $this->uri->segment(3, 0);
//        $limit = 10;
//        $config['base_url'] = site_url('stockist/show');
//        $config['total_rows'] = $this->frontend_stockist_model->get_stockist_list(0, 10000)->num_rows();
//        $config['per_page'] = $limit;
//        $config['uri_segment'] = 3;
//        $this->pagination->initialize($config);
//        $data['pagination'] = $this->pagination->create_links();
//
//        $data['page_title'] = 'Stockist';
//        $data['query'] = $this->frontend_stockist_model->get_stockist_list($offset, $limit);
//
//        template('frontend', 'stockist/frontend_stockist_list_view', $data);
//    }

    function detail() {
         $data['arr_breadcrumbs'] = array(
            'Data Stockist' => '#',
            'Detail Stockist' => '',
        );
         $data['title'] = 'Detail Stockist';
        $data['query'] = $this->frontend_stockist_model->get_stockist_detail($this->uri->segment(3));

        template('frontend', 'stockist/frontend_stockist_detail_view', $data);
    }

}
