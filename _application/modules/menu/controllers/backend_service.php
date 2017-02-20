<?php

/*
 * Backend Service Menu Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('menu/backend_menu_model');
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
                    $this->function_lib->delete_data('site_menu', 'menu_id', $id);
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
                    $data['menu_is_active'] = '1';
                    $this->function_lib->update_data('site_menu', 'menu_id', $id, $data);
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
                    $data['menu_is_active'] = '0';
                    $this->function_lib->update_data('site_menu', 'menu_id', $id, $data);
                }
                $arr_output['message'] = 'Data berhasil disimpan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        //up
        if ($this->input->post('up') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_updated = $item_unupdated = 0;
                foreach ($arr_item as $id) {
                    if($this->backend_menu_model->update_order_by($id, 'up')) {
                        $item_updated++;
                    } else {
                        $item_unupdated++;
                    }
                }
                $arr_output['message'] = $item_updated . ' data berhasil disimpan. ' . $item_unupdated . ' data gagal disimpan.';
                $arr_output['message_class'] = ($item_unupdated > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        //down
        if ($this->input->post('down') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                krsort($arr_item);
                $item_updated = $item_unupdated = 0;
                foreach ($arr_item as $id) {
                    if($this->backend_menu_model->update_order_by($id, 'down')) {
                        $item_updated++;
                    } else {
                        $item_unupdated++;
                    }
                }
                $arr_output['message'] = $item_updated . ' data berhasil disimpan. ' . $item_unupdated . ' data gagal disimpan.';
                $arr_output['message_class'] = ($item_unupdated > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }
        
        echo json_encode($arr_output);
    }

    function get_data($menu_par_id = 0) {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_menu";
        $params['where_detail'] = "menu_par_id = '" . $menu_par_id . "'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        $data['block_options'] = array('top'=>'Top','sidebar'=>'Sidebar','middle'=>'Middle','bottom'=>'Bottom');
        foreach ($query->result() as $row) {

            //is_active
            if ($row->menu_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            $submenu = '<a href="' . base_url() . 'backend/menu/show/' . $row->menu_id . '"><img src="' . base_url() . _dir_icon . 'node-tree.png" border="0" alt="Sub Menu" title="Sub Menu" /></a>';

            //edit
            $edit = '<a href="' . base_url() . 'backend/menu/edit/' . $row->menu_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->menu_id,
                'cell' => array(
                    'menu_id' => $row->menu_id,
                    'menu_title' => $row->menu_title,
                    'menu_link' => $row->menu_link,
                    'menu_block' => $data['block_options'][$row->menu_block],
                    'menu_is_active' => $is_active,
                    'edit' => $edit,
                    'submenu' => $submenu,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('link', '<b>Link</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_link', $this->input->post('link'));
            $this->session->set_flashdata('input_type', $this->input->post('type'));
            $this->session->set_flashdata('input_page_link', $this->input->post('page_link'));
            $this->session->set_flashdata('input_modules_link', $this->input->post('modules_link'));
            $this->session->set_flashdata('input_block', $this->input->post('block'));
            redirect($this->input->post('uri_string'));
        } else {
            $menu_par_id = $this->input->post('par_id');
            $menu_title = $this->input->post('title');
            $menu_link = $this->input->post('link');
            $menu_type = $this->input->post('type');
            $menu_block = $this->input->post('block');
            $menu_order_by = $this->function_lib->get_max('site_menu', 'menu_order_by', array('menu_par_id' => $menu_par_id)) + 1;
            $menu_is_active = '1';

            $data = array();
            $data['menu_par_id'] = $menu_par_id;
            $data['menu_title'] = $menu_title;
            $data['menu_link'] = $menu_link;
            $data['menu_type'] = $menu_type;
            $data['menu_order_by'] = $menu_order_by;
            $data['menu_is_active'] = $menu_is_active;
            $data['menu_description'] = '';
            if ($menu_type == 'page') {
                $arr_menu_link = explode('/', $menu_link);
                $data['menu_page_id'] = $arr_menu_link[2];
            } else {
                $data['menu_page_id'] = 0;
            }

            if ($menu_par_id == 0) {
                $data['menu_block'] = $menu_block;
            } else {
                $menu_par_block = $this->function_lib->get_one('site_menu', 'menu_block', array('menu_id'=>$menu_par_id));
                $data['menu_block'] = $menu_par_block;
            }
            
            $this->function_lib->insert_data('site_menu', $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('link', '<b>Link</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_link', $this->input->post('link'));
            $this->session->set_flashdata('input_type', $this->input->post('type'));
            $this->session->set_flashdata('input_page_link', $this->input->post('page_link'));
            $this->session->set_flashdata('input_modules_link', $this->input->post('modules_link'));
            $this->session->set_flashdata('input_block', $this->input->post('block'));
            redirect($this->input->post('uri_string'));
        } else {
            $menu_id = $this->input->post('id');
            $menu_title = $this->input->post('title');
            $menu_link = $this->input->post('link');
            $menu_type = $this->input->post('type');
            $menu_block = $this->input->post('block');

            $data = array();
            $data['menu_title'] = $menu_title;
            $data['menu_link'] = $menu_link;
            $data['menu_type'] = $menu_type;
            if ($menu_type == 'page') {
                $arr_menu_link = explode('/', $menu_link);
                $data['menu_page_id'] = $arr_menu_link[2];
            } else {
                $data['menu_page_id'] = 0;
            }
            $menu_par_id = $this->function_lib->get_one('site_menu', 'menu_par_id', array('menu_id'=>$menu_id));
            if ($menu_par_id == 0) {
                $data['menu_block'] = $menu_block;
                $this->function_lib->update_data('site_menu', 'menu_par_id', $menu_id, array('menu_block'=>$menu_block));
            }
            $this->function_lib->update_data('site_menu', 'menu_id', $menu_id, $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}

