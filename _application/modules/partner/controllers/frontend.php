<?php

/*
 * Frontend News Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('frontend_partner_model');
    }

    public function index() {
        $this->load->library('pagination');

        $data['arr_breadcrumbs'] = array(
            'Partner' => '#',
            'Data Partner' => '',
        );
        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 6;
        $config['base_url'] = site_url('partner/index');
        $config['total_rows'] = $this->frontend_partner_model->get_partner_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Partner';
        $data['query'] = $this->frontend_partner_model->get_partner_list($offset, $limit);

        template('frontend', 'partner/frontend_partner_list_view', $data);
    }

//    public function show() {
//        $this->load->library('pagination');
//
//        //pagination
//        $offset = (int) $this->uri->segment(3, 0);
//        $limit = 10;
//        $config['base_url'] = site_url('partner/show');
//        $config['total_rows'] = $this->frontend_partner_model->get_partner_list(0, 10000)->num_rows();
//        $config['per_page'] = $limit;
//        $config['uri_segment'] = 3;
//        $this->pagination->initialize($config);
//        $data['pagination'] = $this->pagination->create_links();
//
//        $data['title'] = 'Partner';
//        $data['query'] = $this->frontend_partner_model->get_partner_list($offset, $limit);
//
//        template('frontend', 'partner/frontend_partner_list_view', $data);
//    }

    function detail() {
        $data['arr_breadcrumbs'] = array(
            'Partner' => '#',
            'Detail Partner' => '',
        );
        $data['title'] = 'Detail Partner';
        $data['query'] = $this->frontend_partner_model->get_partner_detail($this->uri->segment(3));

        template('frontend', 'partner/frontend_partner_detail_view', $data);
    }

}
