<?php

/*
 * Backend Service Page Marketing Plan Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('backend_contact_us_model');
        $this->load->helper('form');
    }

    function act_show() {
        //delete
        if ($this->input->post('delete') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_deleted = 0;
                foreach ($arr_item as $id) {
                    //hapus halaman
                    $this->function_lib->delete_data('site_contact_us', 'contact_us_id', $id);
                    
                    $item_deleted++;
                }
                $arr_output['message'] = $item_deleted . ' data berhasil dihapus.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        //publish
        if ($this->input->post('publish') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                foreach ($arr_item as $id) {
                    $data = array();
                    $data['contact_us_is_active'] = '1';
                    $this->function_lib->update_data('site_contact_us', 'contact_us_id', $id, $data);
                }
                $arr_output['message'] = 'Data berhasil disimpan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        //unpublish
        if ($this->input->post('unpublish') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                foreach ($arr_item as $id) {
                    $data = array();
                    $data['contact_us_is_active'] = '0';
                    $this->function_lib->update_data('site_contact_us', 'contact_us_id', $id, $data);
                }
                $arr_output['message'] = 'Data berhasil disimpan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }
        
        echo json_encode($arr_output);
    }

    function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_contact_us";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $contact_us = isset($_POST['contact_us']) ? $_POST['contact_us'] : 1;
        $json_data = array('contact_us' => $contact_us, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->contact_us_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/contact_us/edit/' . $row->contact_us_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->contact_us_id,
                'cell' => array(
                    'contact_us_id' => $row->contact_us_id,
                    'contact_us_title' => $row->contact_us_title,
                    'contact_us_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function act_add() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('contact_content', '<b>Isi</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_content', $this->input->post('contact_content'));
            redirect($this->input->post('uri_string'));
        } else {
            $contact_us_title = $this->input->post('title');
            $contact_us_content = $this->input->post('contact_content');

            $data = array();
            $data['contact_us_title'] = $contact_us_title;
            $data['contact_us_content'] = $contact_us_content;
            $data['contact_us_is_active'] = '1';
            $this->function_lib->insert_data('site_contact_us', $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function act_edit() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('contact_content', '<b>Isi</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_content', $this->input->post('contact_content'));
            redirect($this->input->post('uri_string'));
        } else {
            $contact_us_id = $this->input->post('id');
            $contact_us_title = $this->input->post('title');
            $contact_us_content = $this->input->post('contact_content');

            $data = array();
            $data['contact_us_title'] = $contact_us_title;
            $data['contact_us_content'] = $contact_us_content;
            $data['contact_us_is_active'] = '1';
            $this->function_lib->update_data('site_contact_us', 'contact_us_id', $contact_us_id, $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
}

?>
