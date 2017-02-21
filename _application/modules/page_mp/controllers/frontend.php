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
        $this->load->model('frontend_page_mp_model');
    }

    function index() {
         $data['arr_breadcrumbs'] = array(
            'Halaman' => '#',
            'Marketing Plan' => '',
        );
        //$data['query'] = $this->function_lib->get_detail_data('site_page_mp', 'page_mp_is_active', '1')->result();
        $data['query'] =$this->frontend_page_mp_model->get_mp()->result();
        $data['title'] ='Marketing Plan';
        template('frontend', 'page_mp/frontend_page_mp_list', $data);
    }
    
    function view($id) {
        $data['query'] = $this->frontend_page_mp_model->get_page_mp($id)->row();
        $data['other_query'] = $this->frontend_page_mp_model->get_page_mp_all($id)->result(); // untuk menampilkan data selain id yg dipanggil
        
        template('frontend', 'page_mp/frontend_page_mp_view', $data);
    }
}

?>
