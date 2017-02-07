<?php

/*
 * Backend Service Bank Account Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('bank_account/backend_bank_account_model');
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
                $item_deleted = 0;
                foreach ($arr_item as $id) {
                    $this->function_lib->delete_data('site_bank_account', 'bank_account_id', $id);
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
                    $data['bank_account_is_active'] = '1';
                    $this->function_lib->update_data('site_bank_account', 'bank_account_id', $id, $data);
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
                    $data['bank_account_is_active'] = '0';
                    $this->function_lib->update_data('site_bank_account', 'bank_account_id', $id, $data);
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
        $params['table'] = "site_bank_account";
        $params['join'] = "INNER JOIN ref_bank ON bank_id = bank_account_bank_id";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->bank_account_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/bank_account/edit/' . $row->bank_account_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->bank_account_id,
                'cell' => array(
                    'bank_account_id' => $row->bank_account_id,
                    'bank_account_name' => $row->bank_account_name,
                    'bank_account_no' => $row->bank_account_no,
                    'bank_account_is_active' => $is_active,
                    'bank_name' => $row->bank_name,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bank_id', '<b>Bank</b>', 'required');
        $this->form_validation->set_rules('name', '<b>Nama Rekening</b>', 'required');
        $this->form_validation->set_rules('no', '<b>No. Rekening</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_bank_id', $this->input->post('bank_id'));
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            $this->session->set_flashdata('input_no', $this->input->post('no'));
            redirect($this->input->post('uri_string'));
        } else {
            $bank_account_bank_id = $this->input->post('bank_id');
            $bank_account_name = $this->input->post('name');
            $bank_account_no = $this->input->post('no');

            $data = array();
            $data['bank_account_bank_id'] = $bank_account_bank_id;
            $data['bank_account_name'] = $bank_account_name;
            $data['bank_account_no'] = $bank_account_no;
            $data['bank_account_is_active'] = 1;
            $this->function_lib->insert_data('site_bank_account', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bank_id', '<b>Bank</b>', 'required');
        $this->form_validation->set_rules('name', '<b>Nama Rekening</b>', 'required');
        $this->form_validation->set_rules('no', '<b>No. Rekening</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_bank_id', $this->input->post('bank_id'));
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            $this->session->set_flashdata('input_no', $this->input->post('no'));
            redirect($this->input->post('uri_string'));
        } else {
            $bank_account_id = $this->input->post('id');
            $bank_account_bank_id = $this->input->post('bank_id');
            $bank_account_name = $this->input->post('name');
            $bank_account_no = $this->input->post('no');

            $data = array();
            $data['bank_account_bank_id'] = $bank_account_bank_id;
            $data['bank_account_name'] = $bank_account_name;
            $data['bank_account_no'] = $bank_account_no;
            $this->function_lib->update_data('site_bank_account', 'bank_account_id', $bank_account_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}












