<?php

/*
 * Backend Service Page Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('page/backend_page_model');
        $this->load->helper('form');
    }
    
    function act_show() {
        //delete
        if ($this->input->post('delete') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_deleted = 0;
                foreach ($arr_item as $id) {
                    //hapus menu
                    $this->function_lib->delete_data('site_menu', 'menu_page_id', $id);
                    
                    //hapus halaman
                    $this->function_lib->delete_data('site_page', 'page_id', $id);
                    
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
                    $data['page_is_active'] = '1';
                    $this->function_lib->update_data('site_page', 'page_id', $id, $data);
                    
                    $data = array();
                    $data['menu_is_active'] = '1';
                    $this->function_lib->update_data('site_menu', 'menu_page_id', $id, $data);
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
                    $data['page_is_active'] = '0';
                    $this->function_lib->update_data('site_page', 'page_id', $id, $data);
                    
                    $data = array();
                    $data['menu_is_active'] = '0';
                    $this->function_lib->update_data('site_menu', 'menu_page_id', $id, $data);
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
        $params['table'] = "site_page";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->page_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/page/edit/' . $row->page_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->page_id,
                'cell' => array(
                    'page_id' => $row->page_id,
                    'page_title' => $row->page_title,
                    'page_is_active' => $is_active,
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
        $this->form_validation->set_rules('page_content', '<b>Isi</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_page_content', $this->input->post('page_content'));
            $this->session->set_flashdata('input_is_create_menu', $this->input->post('is_create_menu'));
            redirect($this->input->post('uri_string'));
        } else {
            $page_title = $this->input->post('title');
            $page_content = $this->input->post('page_content');
            $is_create_menu = $this->input->post('is_create_menu');

            $data = array();
            $data['page_title'] = $page_title;
            $data['page_content'] = $page_content;
            $page_id = $this->function_lib->insert_data('site_page', $data);

            if ($is_create_menu == 1) {
                $menu_par_id = $this->input->post('par_id');
                $menu_order_by = $this->function_lib->get_max('site_menu', 'menu_order_by', array('menu_par_id' => $menu_par_id)) + 1;
                
                $data = array();
                $data['menu_par_id'] = $menu_par_id;
                $data['menu_page_id'] = $page_id;
                $data['menu_title'] = $page_title;
                $data['menu_link'] = 'page/view/' . $page_id . '/' . url_title($page_title);
                $data['menu_type'] = 'page';
                $data['menu_order_by'] = $menu_order_by;
                $data['menu_is_active'] = '1';
                $data['menu_description'] = '';
                $this->function_lib->insert_data('site_menu', $data);
            }

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $is_update_menu = $this->input->post('is_update_menu');

        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('page_content', '<b>Isi</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_page_content', $this->input->post('page_content'));
            $this->session->set_flashdata('input_is_update_menu', $this->input->post('is_update_menu'));
            redirect($this->input->post('uri_string'));
        } else {
            $page_id = $this->input->post('id');
            $page_title = $this->input->post('title');
            $page_content = $this->input->post('page_content');

            $data = array();
            $data['page_title'] = $page_title;
            $data['page_content'] = $page_content;
            $this->function_lib->update_data('site_page', 'page_id', $page_id, $data);

            if ($is_update_menu == 1) {
                $data = array();
                $data['menu_title'] = $page_title;
                $data['menu_link'] = 'page/view/' . $page_id . '/' . url_title($page_title);
                $this->function_lib->update_data('site_menu', 'menu_page_id', $page_id, $data);
            }

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}

