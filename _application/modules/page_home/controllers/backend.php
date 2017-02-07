<?php

/*
 * Backend Page Home Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show($location = 'frontend') {
        $this->load->helper('tinymce');
        
        switch($location) {
            case "member":
                $title = 'Member';
                break;
            
            default:
                $title = 'Publik';
                break;
        }
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Halaman Depan ' . $title => 'backend/page_home/show/' . $location,
        );
        
        
        $data['title'] = $title;
        $data['query'] = $this->function_lib->get_detail_data('site_page_home', 'page_home_location', $location);
        $data['form_action'] = 'backend_service/page_home/act_show';
        
        template('backend', 'page_home/backend_page_home_view', $data);
    }

}

