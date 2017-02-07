<?php

/*
 * Backend Service Guestbook Controller
 *
 * @author	Ardiansyah Prasaja
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {
    
    function __construct() {
        parent::__construct();

        $this->load->model('guestbook/backend_guestbook_model');
        $this->load->helper('form');
    }
    
    function act_show() {
        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';

        //delete
        if ($this->input->post('delete') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_deleted = $item_undeleted = 0;
                foreach ($arr_item as $id) {
                    $this->function_lib->delete_data('site_guestbook', 'guestbook_id', $id);
                    $item_deleted++;
                }
                $arr_output['message'] = $item_deleted . ' data berhasil dihapus. ' . $item_undeleted . ' data gagal dihapus.';
                $arr_output['message_class'] = ($item_undeleted > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        echo json_encode($arr_output);
    }
    
    function act_configuration() {
        $this->load->library('form_validation');
        $query = $this->backend_guestbook_model->get_list_configuration();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if ($row->guestbook_configuration_is_required == '1') {
                    $this->form_validation->set_rules($row->guestbook_configuration_name, '<b>' . $row->guestbook_configuration_title . '</b>', 'required');
                }
            }

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
                foreach ($query->result() as $row) {
                    $this->session->set_flashdata('input_' . $row->guestbook_configuration_name, $this->input->post($row->guestbook_configuration_name));
                }
                redirect($this->input->post('uri_string'));
            } else {
                foreach ($query->result() as $row) {
                    $data['guestbook_configuration_value'] = $this->input->post($row->guestbook_configuration_name);
                    $this->function_lib->update_data('site_guestbook_configuration', 'guestbook_configuration_id', $row->guestbook_configuration_id, $data);
                }

                $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
                redirect($this->input->post('uri_string'));
            }
        }
    }
}

?>
