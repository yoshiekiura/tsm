<?php

/*
 * Backend Administrator Menu Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('administrator_menu/backend_administrator_menu_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show($menu_par_id = 0) {
        $data['arr_breadcrumbs'] = array(
            'Data Master' => '#',
            'Data Menu Administrator' => 'backend/administrator_menu/show',
        );
        
        $menu_par_title = $this->backend_administrator_menu_model->get_menu_title($menu_par_id);
        if($menu_par_id != 0) {
            $data['arr_breadcrumbs']['Data Sub Menu "' . $menu_par_title . '"'] = 'backend/administrator_menu/show/' . $menu_par_id;
        }
        
        $data['menu_par_id'] = $menu_par_id;
        $data['menu_par_title'] = $menu_par_title;
        
        template('backend', 'administrator_menu/backend_administrator_menu_list_view', $data);
    }

    function get_data($menu_par_id = 0) {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_administrator_menu";
        $params['where_detail'] = "administrator_menu_par_id = '" . $menu_par_id . "'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->administrator_menu_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/administrator_menu/edit/' . $row->administrator_menu_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            //submenu
            $submenu = '<a href="' . base_url() . 'backend/administrator_menu/show/' . $row->administrator_menu_id . '"><img src="' . base_url() . _dir_icon . 'node-tree.png" border="0" alt="Sub Menu" title="Sub Menu" /></a>';
            
            //icon
            $menu_icon = '';
            if ($row->administrator_menu_icon != '' && file_exists(_dir_menu . $row->administrator_menu_icon)) {
                $menu_icon = '<img src="' . base_url() . _dir_menu . $row->administrator_menu_icon . '" alt="Ikon Menu" title="Ikon Menu" border="0" />';
            }

            //class
            $menu_class = '<div><i class="' . $row->administrator_menu_class . '"></i></div>';
            
            $entry = array('id' => $row->administrator_menu_id,
                'cell' => array(
                    'administrator_menu_id' => $row->administrator_menu_id,
                    'administrator_menu_title' => $row->administrator_menu_title,
                    'administrator_menu_link' => $row->administrator_menu_link,
                    'administrator_menu_icon' => $menu_icon,
                    'administrator_menu_class' => $menu_class,
                    'administrator_menu_is_active' => $is_active,
                    'edit' => $edit,
                    'submenu' => $submenu,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_show() {
        //delete
        if ($this->input->post('delete') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_deleted = 0;
                foreach ($arr_item as $id) {                    
                    //hapus menu
                    $this->function_lib->delete_data('site_administrator_menu', 'administrator_menu_id', $id);
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
                    $data['administrator_menu_is_active'] = '1';
                    $this->function_lib->update_data('site_administrator_menu', 'administrator_menu_id', $id, $data);
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
                    $data['administrator_menu_is_active'] = '0';
                    $this->function_lib->update_data('site_administrator_menu', 'administrator_menu_id', $id, $data);
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
                    if($this->backend_administrator_menu_model->update_order_by($id, 'up')) {
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
                    if($this->backend_administrator_menu_model->update_order_by($id, 'down')) {
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

    function add($menu_par_id = 0) {
        $data['arr_breadcrumbs'] = array(
            'Data Master' => '#',
            'Data Menu Administrator' => 'backend/administrator_menu/show',
        );
        
        $menu_par_title = $this->backend_administrator_menu_model->get_menu_title($menu_par_id);
        if($menu_par_id != 0) {
            $data['arr_breadcrumbs']['Data Sub Menu "' . $menu_par_title . '"'] = 'backend/administrator_menu/show/' . $menu_par_id;
        }
        $data['arr_breadcrumbs']['Tambah Menu'] = 'backend/administrator_menu/add';
        
        $data['menu_par_id'] = $menu_par_id;
        $data['menu_par_title'] = $menu_par_title;
        $data['form_action'] = 'backend/administrator_menu/act_add';

        template('backend', 'administrator_menu/backend_administrator_menu_add_view', $data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('link', '<b>Link</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_link', $this->input->post('link'));
            $this->session->set_flashdata('input_class', $this->input->post('class'));
            redirect($this->input->post('uri_string'));
        } else {
            $administrator_menu_par_id = $this->input->post('par_id');
            $administrator_menu_title = $this->input->post('title');
            $administrator_menu_link = $this->input->post('link');
            $administrator_menu_class = $this->input->post('class');
            $administrator_menu_order_by = $this->function_lib->get_max('site_administrator_menu', 'administrator_menu_order_by', array('administrator_menu_par_id' => $administrator_menu_par_id)) + 1;

            $data = array();
            $data['administrator_menu_par_id'] = $administrator_menu_par_id;
            $data['administrator_menu_title'] = $administrator_menu_title;
            $data['administrator_menu_link'] = $administrator_menu_link;
            $data['administrator_menu_class'] = $administrator_menu_class;
            $data['administrator_menu_order_by'] = $administrator_menu_order_by;
            $this->function_lib->insert_data('site_administrator_menu', $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        $menu_par_id = $this->backend_administrator_menu_model->get_menu_par_id($edit_id);
        $menu_par_title = $this->backend_administrator_menu_model->get_menu_title($menu_par_id);
        
        $data['arr_breadcrumbs'] = array(
            'Data Master' => '#',
            'Data Menu Administrator' => 'backend/administrator_menu/show',
        );
        
        if($menu_par_id != 0) {
            $data['arr_breadcrumbs']['Data Sub Menu "' . $menu_par_title . '"'] = 'backend/administrator_menu/show/' . $menu_par_id;
        }
        $data['arr_breadcrumbs']['Ubah Menu'] = 'backend/administrator_menu/edit/' . $edit_id;

        $data['menu_id'] = $edit_id;
        $data['menu_par_id'] = $menu_par_id;
        $data['menu_par_title'] = $menu_par_title;
        $data['query'] = $this->function_lib->get_detail_data('site_administrator_menu', 'administrator_menu_id', $edit_id);
        $data['form_action'] = 'backend/administrator_menu/act_edit';

        template('backend', 'administrator_menu/backend_administrator_menu_edit_view', $data);
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('link', '<b>Link</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_link', $this->input->post('link'));
            $this->session->set_flashdata('input_class', $this->input->post('class'));
            redirect($this->input->post('uri_string'));
        } else {
            $administrator_menu_id = $this->input->post('id');
            $administrator_menu_title = $this->input->post('title');
            $administrator_menu_link = $this->input->post('link');
            $administrator_menu_class = $this->input->post('class');

            $data = array();
            $data['administrator_menu_title'] = $administrator_menu_title;
            $data['administrator_menu_link'] = $administrator_menu_link;
            $data['administrator_menu_class'] = $administrator_menu_class;
            $this->function_lib->update_data('site_administrator_menu', 'administrator_menu_id', $administrator_menu_id, $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}

