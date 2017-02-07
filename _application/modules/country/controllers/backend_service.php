<?php

/*
 * Backend Service Country Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('country/backend_country_model');
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
                    $check_delete = $this->backend_country_model->check_delete($id);
                    if($check_delete == true) {
                        $this->function_lib->delete_data('ref_country', 'country_id', $id);
                        $item_deleted++;
                    } else {
                        $item_undeleted++;
                    }
                }
                $arr_output['message'] = $item_deleted . ' data berhasil dihapus. ' . $item_undeleted . ' data gagal dihapus.';
                $arr_output['message_class'] = ($item_undeleted > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
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
                    $data['country_is_active'] = '1';
                    $this->function_lib->update_data('ref_country', 'country_id', $id, $data);
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
                    $data['country_is_active'] = '0';
                    $this->function_lib->update_data('ref_country', 'country_id', $id, $data);
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
        $params['table'] = "ref_country";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {
            
            //flag
            if ($row->country_flag != '' && file_exists(_dir_flag . $row->country_flag)) {
                $image = $row->country_flag;
            } else {
                $image = '_default.png';
            }
            $flag = '<img src="' . base_url() . _dir_flag . $image . '" border="0" width="22" align="absmiddle" alt="' . $image . '" style="border:1px solid #999;" />';

            //is_active
            if ($row->country_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/country/edit/' . $row->country_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->country_id,
                'cell' => array(
                    'country_id' => $row->country_id,
                    'country_name' => $row->country_name,
                    'country_iso_code' => $row->country_iso_code,
                    'country_phone_code' => $row->country_phone_code,
                    'country_flag' => $flag,
                    'country_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', '<b>Nama Negara</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            redirect($this->input->post('uri_string'));
        } else {
            $country_name = $this->input->post('name');

            $data = array();
            $data['country_name'] = $country_name;
            $data['country_is_active'] = 1;
            $this->function_lib->insert_data('ref_country', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', '<b>Nama Negara</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            redirect($this->input->post('uri_string'));
        } else {
            $country_id = $this->input->post('id');
            $country_name = $this->input->post('name');

            $data = array();
            $data['country_name'] = $country_name;
            $this->function_lib->update_data('ref_country', 'country_id', $country_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
