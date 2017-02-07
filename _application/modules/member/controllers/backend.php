<?php

/*
 * Backend Member Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('member/backend_member_model');
        $this->load->helper('form');

        $this->file_dir = _dir_member;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 200;
        $this->image_height = 200;
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Member' => '#',
            'Data Member' => 'backend/member/show',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();
        $data['serial_type_grid_options'] = $this->mlm_function->get_serial_type_grid_options();
        $data['serial_type_count'] = $this->mlm_function->get_count_serial_type();
        
        template('backend', 'member/backend_member_list_view', $data);
    }
    
    function detail() {
        $detail_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Member' => '#',
            'Data Member' => 'backend/member/show',
            'Detail Data Member' => 'backend/member/detail/' . $detail_id,
        );
        
        $data['query'] = $this->backend_member_model->get_detail($detail_id);

        template('backend', 'member/backend_member_detail_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Member' => '#',
            'Data Member' => 'backend/member/show',
            'Ubah Data Member' => 'backend/member/edit/' . $edit_id,
        );
        
        $data['identity_type_options'] = $this->function_lib->get_identity_type_options();
        $data['sex_options'] = $this->function_lib->get_sex_options();
        $data['city_options'] = $this->function_lib->get_city_province_options();
        $data['country_options'] = $this->function_lib->get_country_options();
        $data['bank_options'] = $this->function_lib->get_bank_options();
        
        $data['query'] = $this->backend_member_model->get_detail($edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/member/act_edit';

        template('backend', 'member/backend_member_edit_view', $data);
    }
    
    function password() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Member' => '#',
            'Data Member' => 'backend/member/show',
            'Ubah Password Member' => 'backend/member/password/' . $edit_id,
        );
        
        $data['query'] = $this->backend_member_model->get_detail($edit_id);
        $data['form_action'] = 'backend_service/member/act_password';
        
        template('backend', 'member/backend_member_password_view', $data);
    }
    
    function geneology() {
        $root_network_id = 1;
        $top_network_code = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Member' => '#',
            'Jaringan Member' => 'backend/member/show',
        );
        
        if($top_network_code) {
            $top_network_id = $this->mlm_function->get_network_id($top_network_code);
            if($top_network_id == '') {
                $top_network_id = 1;
            }
        } else {
            $top_network_id = 1;
        }
        
        $data['root_network_id'] = $root_network_id;
        $data['top_network_id'] = $top_network_id;
        $data['arr_data'] = $this->mlm_function->generate_geneology_binary($root_network_id, $top_network_id, 3);
        $data['extra_head_content'] = '<link rel="stylesheet" href="' . base_url() . '/addons/jorgchart/css/jorgchart.css"/>';
        $data['extra_head_content'] .= '<script type="text/javascript" src="' . base_url() . '/addons/jorgchart/js/jorgchart.js"></script>';
        $data['extra_head_content'] .= '<link rel="stylesheet" href="' . base_url() . '/addons/jquery-qtip/css/jquery.qtip.min.css"/>';
        $data['extra_head_content'] .= '<script type="text/javascript" src="' . base_url() . '/addons/jquery-qtip/js/jquery.qtip.min.js"></script>';
        $data['form_action'] = 'backend_service/member/act_geneology';
        
        template('backend', 'member/backend_member_geneology_view', $data);
    }
    
    function get_member_info($network_code = '') {
        $network_id = $this->mlm_function->get_network_id($network_code);
        $data['arr_data'] = $this->mlm_function->get_arr_member_detail($network_id);
        $data['arr_data']['max_level_left'] = $this->mlm_function->get_member_max_level($network_id, 'L');
        $data['arr_data']['max_level_right'] = $this->mlm_function->get_member_max_level($network_id, 'R');
        $data['arr_data']['sponsoring_count_left'] = $this->mlm_function->get_member_sponsoring_count($network_id, 'L');
        $data['arr_data']['sponsoring_count_right'] = $this->mlm_function->get_member_sponsoring_count($network_id, 'R');
        template('blank', 'member/backend_member_info_view', $data);
    }

}
