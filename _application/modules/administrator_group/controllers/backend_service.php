<?php

/*
 * Backend Service Administrator Group Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('administrator_group/backend_administrator_group_model');
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
                    $check_delete = $this->backend_administrator_group_model->check_delete($id);
                    if($check_delete == true) {
                        //hapus privilege
                        $this->function_lib->delete_data('site_administrator_privilege', 'administrator_privilege_administrator_group_id', $id);
                        
                        //hapus data
                        $this->function_lib->delete_data('site_administrator_group', 'administrator_group_id', $id);
                        
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
                    $data['administrator_group_is_active'] = '1';
                    $this->function_lib->update_data('site_administrator_group', 'administrator_group_id', $id, $data);
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
                    $data['administrator_group_is_active'] = '0';
                    $this->function_lib->update_data('site_administrator_group', 'administrator_group_id', $id, $data);
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
        $params['table'] = "site_administrator_group";
        if ($this->session->userdata('administrator_group_type') == 'administrator') {
            $params['where_detail'] = "administrator_group_type = 'administrator'";
        }
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->administrator_group_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/administrator_group/edit/' . $row->administrator_group_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->administrator_group_id,
                'cell' => array(
                    'administrator_group_id' => $row->administrator_group_id,
                    'administrator_group_title' => $row->administrator_group_title,
                    'administrator_group_type' => ucfirst($row->administrator_group_type),
                    'administrator_group_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '<b>Nama Grup</b>', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_type', $this->input->post('type'));
            if($this->input->post('type') == 'administrator' && $this->input->post('item') != FALSE) {
                $this->session->set_flashdata('input_allitem', $this->input->post('allitem'));
                $this->session->set_flashdata('input_item', $this->input->post('item'));
            }
            redirect($this->input->post('uri_string'));
        } else {
            $administrator_group_title = $this->input->post('title');
            $administrator_group_type = $this->input->post('type');

            $data = array();
            $data['administrator_group_title'] = $administrator_group_title;
            $data['administrator_group_type'] = $administrator_group_type;
            $data['administrator_group_is_active'] = 1;
            $administrator_group_id = $this->function_lib->insert_data('site_administrator_group', $data);
            
            //add privilege
            if ($administrator_group_type == 'administrator' && $this->input->post('item') != FALSE) {
                foreach ($this->input->post('item') as $id) {
                    $data = array();
                    $data['administrator_privilege_administrator_group_id'] = $administrator_group_id;
                    $data['administrator_privilege_administrator_menu_id'] = $id;
                    $data['administrator_privilege_action'] = '';
                    $this->function_lib->insert_data('site_administrator_privilege', $data);
                }
            }
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '<b>Nama Grup</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_type', $this->input->post('type'));
            if($this->input->post('type') == 'administrator' && $this->input->post('item') != FALSE) {
                $this->session->set_flashdata('input_allitem', $this->input->post('allitem'));
                $this->session->set_flashdata('input_item', $this->input->post('item'));
            }
            redirect($this->input->post('uri_string'));
        } else {
            $administrator_group_id = $this->input->post('id');
            $administrator_group_title = $this->input->post('title');
            $administrator_group_type = $this->input->post('type');

            $data = array();
            $data['administrator_group_title'] = $administrator_group_title;
            $data['administrator_group_type'] = $administrator_group_type;
            $this->function_lib->update_data('site_administrator_group', 'administrator_group_id', $administrator_group_id, $data);
            
            //delete privilege
            $this->function_lib->delete_data('site_administrator_privilege', 'administrator_privilege_administrator_group_id', $administrator_group_id);
            
            //add privilege
            if ($administrator_group_type == 'administrator' && $this->input->post('item') != FALSE) {
                foreach ($this->input->post('item') as $id) {
                    $data = array();
                    $data['administrator_privilege_administrator_group_id'] = $administrator_group_id;
                    $data['administrator_privilege_administrator_menu_id'] = $id;
                    $data['administrator_privilege_action'] = '';
                    $this->function_lib->insert_data('site_administrator_privilege', $data);
                }
            }
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
