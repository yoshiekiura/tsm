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
        $this->load->model('frontend_contact_us_model');
    }

    function index() {
        
        $data['query'] = $this->function_lib->get_detail_data('site_contact_us', 'contact_us_is_active', '1')->result();
        $data['title'] = 'Kontak Kami';
        //template('frontend', 'page_mp/frontend_page_mp_list', $data);
        template('frontend', 'contact_us/frontend_contact_us_view', $data);
    }
    
}

?>
