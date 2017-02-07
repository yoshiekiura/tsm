<?php

/*
 * Member Testimony Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Testimony extends Member_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('voffice/testimony_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['page_title'] = 'Data Testimony';
        $data['arr_breadcrumbs'] = array(
            'Testimoni' => 'voffice/testimony/show',
        );
        
        template('member', 'voffice/testimony_list_view', $data);
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
                    $this->function_lib->delete_data('sys_testimony', 'testimony_id', $id);
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

    function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "sys_testimony";
        $params['where_detail'] = "testimony_network_id = '" . $this->session->userdata('network_id') . "'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //edit
            $edit = '<a href="' . base_url() . 'voffice/testimony/edit/' . $row->testimony_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->testimony_id,
                'cell' => array(
                    'testimony_id' => $row->testimony_id,
                    'testimony_content' => nl2br($row->testimony_content),
                    'testimony_datetime' => convert_datetime($row->testimony_datetime, 'id'),
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function add() {
        $data['page_title'] = 'Kirim Testimoni';
        $data['arr_breadcrumbs'] = array(
            'Testimoni' => 'voffice/testimony/show',
            'Kirim Testimoni' => 'voffice/testimony/add',
        );
        
        $data['form_action'] = 'voffice/testimony/act_add';
        
        template('member', 'voffice/testimony_add_view', $data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('content', '<b>Isi Testimoni</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_content', $this->input->post('content'));
            redirect($this->input->post('uri_string'));
        } else {
            $testimony_network_id = $this->session->userdata('network_id');
            $testimony_content = $this->input->post('content');
            $testimony_datetime = date("Y-m-d H:i:s");

            $data = array();
            $data['testimony_network_id'] = $testimony_network_id;
            $data['testimony_content'] = $testimony_content;
            $data['testimony_is_approved'] = 0;
            $data['testimony_is_active'] = 1;
            $data['testimony_datetime'] = $testimony_datetime;
            $this->function_lib->insert_data('sys_testimony', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Testimoni anda berhasil dikirim. Terima kasih atas partisipasi anda.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        $data['page_title'] = 'Ubah Testimoni';
        $data['arr_breadcrumbs'] = array(
            'Testimoni' => 'voffice/testimony/show',
            'Ubah Testimoni' => 'voffice/testimony/edit/' . $edit_id,
        );
        
        $data['query'] = $this->testimony_model->get_detail($edit_id, $this->session->userdata('network_id'));
        $data['form_action'] = 'voffice/testimony/act_edit';

        template('member', 'voffice/testimony_edit_view', $data);
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('content', '<b>Isi Testimoni</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_content', $this->input->post('content'));
            redirect($this->input->post('uri_string'));
        } else {
            $testimony_id = $this->input->post('id');
            $testimony_content = $this->input->post('content');

            $data = array();
            $data['testimony_content'] = $testimony_content;
            $this->testimony_model->update($testimony_id, $this->session->userdata('network_id'), $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
