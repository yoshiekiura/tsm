<?php

/*
 * Backend Service Testimony Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('testimony/backend_testimony_model');
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
                    $arr_id = explode("_", $id);
                    if($arr_id[0] == 'public') {
                        $this->function_lib->delete_data('site_testimony', 'testimony_id', $arr_id[1]);
                        $item_deleted++;
                    } elseif($arr_id[0] == 'member') {
                        $this->function_lib->delete_data('sys_testimony', 'testimony_id', $arr_id[1]);
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
                    $data['testimony_is_active'] = '1';
                    
                    $arr_id = explode("_", $id);
                    if($arr_id[0] == 'public') {
                        $this->function_lib->update_data('site_testimony', 'testimony_id', $arr_id[1], $data);
                    } elseif($arr_id[0] == 'member') {
                        $this->function_lib->update_data('sys_testimony', 'testimony_id', $arr_id[1], $data);
                    }
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
                    $data['testimony_is_active'] = '0';
                    
                    $arr_id = explode("_", $id);
                    if($arr_id[0] == 'public') {
                        $this->function_lib->update_data('site_testimony', 'testimony_id', $arr_id[1], $data);
                    } elseif($arr_id[0] == 'member') {
                        $this->function_lib->update_data('sys_testimony', 'testimony_id', $arr_id[1], $data);
                    }
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
        $params['table'] = "view_testimony";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->testimony_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/testimony/edit/' . $row->testimony_category . '/' . $row->testimony_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->id,
                'cell' => array(
                    'testimony_id' => $row->testimony_id,
                    'testimony_category' => $row->testimony_category,
                    'testimony_category_text' => $row->testimony_category_text,
                    'testimony_name' => $row->testimony_name,
                    'testimony_content' => nl2br($row->testimony_content),
                    'testimony_datetime' => convert_datetime($row->testimony_datetime, 'id'),
                    'testimony_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', '<b>Nama</b>', 'required');
        $this->form_validation->set_rules('content', '<b>Isi Testimoni</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            $this->session->set_flashdata('input_content', $this->input->post('content'));
            redirect($this->input->post('uri_string'));
        } else {
            $testimony_name = $this->input->post('name');
            $testimony_content = $this->input->post('content');
            $testimony_datetime = date("Y-m-d H:i:s");

            $data = array();
            $data['testimony_name'] = $testimony_name;
            $data['testimony_content'] = $testimony_content;
            $data['testimony_is_active'] = 1;
            $data['testimony_datetime'] = $testimony_datetime;
            $this->function_lib->insert_data('site_testimony', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        if($this->input->post('category') == 'public') {
            $this->form_validation->set_rules('name', '<b>Nama</b>', 'required');
        }
        $this->form_validation->set_rules('content', '<b>Isi Testimoni</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            if($this->input->post('category') == 'public') {
                $this->session->set_flashdata('input_name', $this->input->post('name'));
            }
            $this->session->set_flashdata('input_content', $this->input->post('content'));
            redirect($this->input->post('uri_string'));
        } else {
            $category = $this->input->post('category');
            $testimony_id = $this->input->post('id');
            $testimony_name = $this->input->post('name');
            $testimony_content = $this->input->post('content');

            if($category == 'public') {
                $data = array();
                $data['testimony_name'] = $testimony_name;
                $data['testimony_content'] = $testimony_content;
                $this->function_lib->update_data('site_testimony', 'testimony_id', $testimony_id, $data);
            } elseif($category == 'member') {
                $data = array();
                $data['testimony_content'] = $testimony_content;
                $this->function_lib->update_data('sys_testimony', 'testimony_id', $testimony_id, $data);
            }
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function act_approve() {
        
        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';

        //approve
        if ($this->input->post('approve') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                foreach ($arr_item as $id) {
                    $data = array();
                    $data['testimony_is_approved'] = '1';
                    $this->function_lib->update_data('sys_testimony', 'testimony_id', $id, $data);
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
    
    function get_approve_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "sys_testimony";
        $params['join'] = "INNER JOIN sys_member ON member_network_id = testimony_network_id";
        $params['where_detail'] = "testimony_is_approved = '0'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            $entry = array('id' => $row->testimony_id,
                'cell' => array(
                    'testimony_id' => $row->testimony_id,
                    'member_name' => $row->member_name,
                    'testimony_content' => nl2br($row->testimony_content),
                    'testimony_datetime' => convert_datetime($row->testimony_datetime, 'id'),
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

}
