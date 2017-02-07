<?php

/*
 * Backend Service Page Home Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('form');
    }
    
    function act_show() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('home_content', '<b>Isi</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_home_content', $this->input->post('home_content'));
            $this->session->set_flashdata('input_location', $this->input->post('location'));
            redirect($this->input->post('uri_string'));
        } else {
            $page_home_title = $this->input->post('title');
            $page_home_content = $this->input->post('home_content');
            $location = $this->input->post('location');

            $data = array();
            $data['page_home_title'] = $page_home_title;
            $data['page_home_content'] = $page_home_content;
            $this->function_lib->update_data('site_page_home', 'page_home_location', $location, $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}

