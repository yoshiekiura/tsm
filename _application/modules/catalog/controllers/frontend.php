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
        $this->load->model('frontend_catalog_model');
    }

    public function index() {
        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 6;
        $config['base_url'] = site_url('catalog/index');
        $config['total_rows'] = $this->frontend_catalog_model->get_catalog_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['page_title'] = 'Featured product';
        $data['query'] = $this->frontend_catalog_model->get_catalog_list($offset, $limit);

        template('frontend', 'catalog/frontend_catalog_list_view', $data);
    }

    function view() {
        $data['page_title'] = 'Featured Product';
        $data['query'] = $this->frontend_catalog_model->get_catalog_detail($this->uri->segment(3));

        template('frontend', 'catalog/frontend_catalog_detail_view', $data);
    }
}

?>
