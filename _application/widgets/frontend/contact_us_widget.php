<?php

/*
 * Frontend Contact Us Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact_us_widget extends Widget {

    public function run() {
        $this->load->helper('form');
        $this->load->model("frontend/common_model");
        $this->load->model('frontend/member_model');
        
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;

        if ($this->session->userdata('member_id') != null) {
            $query = $this->member_model->get_member_by_id($this->session->userdata('member_id'));
            $row = $query->row();
            $data = $row;
        } else {
            $data = array(
                'member_title' => '',
                'member_name' => '',
                'member_company' => '',
                'member_main_business' => '',
                'member_address' => '',
                'member_city' => '',
                'member_country_id' => '',
                'member_zip_code' => '',
                'member_telephone' => '',
                'member_fax' => '',
                'member_email' => '',
            );
        }
        
        $data['options_title'] = array('mr' => 'Mr.', 'mrs' => 'Mrs.', 'ms' => 'Ms.');
        $data['options_country'] = $this->function_lib->get_option_country();

        $this->render($widget_themes . '/contact_us_widget_view', $data);
    }

}
