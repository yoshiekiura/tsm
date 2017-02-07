<?php

/*
 * Backend Service City Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('city/backend_city_model');
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
                    $check_delete = $this->backend_city_model->check_delete($id);
                    if($check_delete == true) {
                        $this->function_lib->delete_data('ref_city', 'city_id', $id);
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
                    $data['city_is_active'] = '1';
                    $this->function_lib->update_data('ref_city', 'city_id', $id, $data);
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
                    $data['city_is_active'] = '0';
                    $this->function_lib->update_data('ref_city', 'city_id', $id, $data);
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
        $params['table'] = "ref_city";
        $params['join'] = "
            INNER JOIN ref_province ON province_id = city_province_id 
            INNER JOIN ref_region ON region_id = province_region_id 
        ";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->city_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/city/edit/' . $row->city_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->city_id,
                'cell' => array(
                    'city_id' => $row->city_id,
                    'city_name' => $row->city_name,
                    'province_name' => $row->province_name,
                    'region_name' => $row->region_name,
                    'city_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('province_id', '<b>Propinsi</b>', 'required');
        $this->form_validation->set_rules('name', '<b>Nama Kota / Kabupaten</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_province_id', $this->input->post('province_id'));
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            redirect($this->input->post('uri_string'));
        } else {
            $city_province_id = $this->input->post('province_id');
            $city_name = $this->input->post('name');

            $data = array();
            $data['city_province_id'] = $city_province_id;
            $data['city_name'] = $city_name;
            $data['city_is_active'] = 1;
            $this->function_lib->insert_data('ref_city', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('province_id', '<b>Propinsi</b>', 'required');
        $this->form_validation->set_rules('name', '<b>Nama Kota / Kabupaten</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_province_id', $this->input->post('province_id'));
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            redirect($this->input->post('uri_string'));
        } else {
            $city_id = $this->input->post('id');
            $city_province_id = $this->input->post('province_id');
            $city_name = $this->input->post('name');

            $data = array();
            $data['city_province_id'] = $city_province_id;
            $data['city_name'] = $city_name;
            $this->function_lib->update_data('ref_city', 'city_id', $city_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
