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
        $this->load->model('frontend_promo_model');
    }

    public function index() {
        $this->load->library('pagination');
        $data['arr_breadcrumbs'] = array(
            'Promo' => '#',
            'Data Promo' => '',
        );
        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 6;
        $config['base_url'] = site_url('promo/index');
        $config['total_rows'] = $this->frontend_promo_model->get_promo_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Promo';
        $data['query'] = $this->frontend_promo_model->get_promo_list($offset, $limit);

        template('frontend', 'promo/frontend_promo_list_view', $data);
    }

    public function show() {
        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 10;
        $config['base_url'] = site_url('promo/show');
        $config['total_rows'] = $this->frontend_promo_model->get_promo_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Promo';
        $data['query'] = $this->frontend_promo_model->get_promo_list($offset, $limit);

        template('frontend', 'promo/frontend_promo_list_view', $data);
    }

    function detail() {
        $data['arr_breadcrumbs'] = array(
            'Promo' => '#',
            'Detail Promo' => '',
        );
        $data['title'] = 'Promo';
        $data['query'] = $this->frontend_promo_model->get_promo_detail($this->uri->segment(3));

        template('frontend', 'promo/frontend_promo_detail_view', $data);
    }

}
