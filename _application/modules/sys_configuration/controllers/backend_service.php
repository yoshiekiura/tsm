<?php

/*
 * Backend Service Systems Configuration Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('sys_configuration/backend_sys_configuration_model');
        $this->load->helper('form');
    }

    function act_show() {
        $this->load->library('form_validation');
        $query = $this->backend_sys_configuration_model->get_list();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if ($row->configuration_is_required == '1') {
                    $this->form_validation->set_rules($row->configuration_name, '<b>' . $row->configuration_title . '</b>', 'required');
                }
            }

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
                foreach ($query->result() as $row) {
                    $this->session->set_flashdata('input_' . $row->configuration_name, $this->input->post($row->configuration_name));
                }
                redirect($this->input->post('uri_string'));
            } else {
                foreach ($query->result() as $row) {
                    $data['configuration_value'] = $this->input->post($row->configuration_name);
                    $this->function_lib->update_data('sys_configuration', 'configuration_id', $row->configuration_id, $data);
                }

                $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
                redirect($this->input->post('uri_string'));
            }
        }
    }

}
