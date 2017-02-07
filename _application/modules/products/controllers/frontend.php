<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of frontend
 *
 * @author Almira
 */
class frontend extends Frontend_Controller{
    //put your code here
      function __construct() {
        parent::__construct();
        $this->load->model('frontend_products_model');
    }

    public function index() {
        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 9;
        $config['base_url'] = site_url('products/index');
        $config['total_rows'] = $this->frontend_products_model->get_products_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'List Produk';
        $data['query'] = $this->frontend_products_model->get_products_list($offset, $limit)->result();
        template('frontend', 'products/frontend_products_list_view', $data);
    }
    
    

     function view() {
        $data['title'] = 'Detail Produk';
        $data['query'] = $this->frontend_products_model->get_products_detail($this->uri->segment(3));
        $data['data'] = $this->frontend_products_model->get_products_detail_item($this->uri->segment(3));
//        echo '<pre>';
//        print_r($data['data']->result());
//        die();

        template('frontend', 'products/frontend_products_detail_view', $data);
    }
}

?>
