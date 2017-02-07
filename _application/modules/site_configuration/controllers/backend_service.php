<?php

/*
 * Backend Service Site Configuration Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('site_configuration/backend_site_configuration_model');
        $this->load->helper('form');

        $this->file_dir = _dir_site_config;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
    }

    function act_show() {
        $this->load->library('form_validation');
        $query = $this->backend_site_configuration_model->get_list();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if ($row->configuration_is_required == '1') {
                    if ($row->configuration_type != 'file') {
                        $this->form_validation->set_rules($row->configuration_name, '<b>' . $row->configuration_title . '</b>', 'required');
                    }
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
                    $data = array();
                    if ($row->configuration_type == 'file') {
                        $this->load->library('upload');
                        if ($this->upload->fileUpload('file_' . $row->configuration_name, $this->file_dir, $this->allowed_file_type)) {
                            $upload = $this->upload->data();
                            // remove the old file
                            if ($row->configuration_value != '' && file_exists($this->file_dir . $row->configuration_value)) {
                                @unlink($this->file_dir . $row->configuration_value);
                            }
                            // setting new file
                            $image_filename = $row->configuration_name . strtolower($upload['file_ext']);
                            rename($upload['full_path'], $upload['file_path'] . $image_filename);
                            $data['configuration_value'] = $image_filename;
                        } else {
                            $data['configuration_value'] = $row->configuration_value;
                        }
                    } else {
                        $data['configuration_value'] = $this->input->post($row->configuration_name);
                    }
                    $this->function_lib->update_data('site_configuration', 'configuration_id', $row->configuration_id, $data);
                }

                $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
                redirect($this->input->post('uri_string'));
            }
        }
    }

}
