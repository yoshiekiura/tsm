<?php

/*
 * Backend Service stockistt Controller
 *
 * @author	Yudha Wirawan Sakti
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('stockist/backend_stockist_model');
        $this->load->helper('form');

        $this->file_dir = _dir_stockist;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 520;
        $this->image_height = 520;
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

                    //hapus file gambar
                    $filename = $this->function_lib->get_one('site_stockist', 'stockist_image', array('stockist_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir . $filename)) {
                        @unlink($this->file_dir . $filename);
                    }

                    //hapus data
                    $this->function_lib->delete_data('site_stockist', 'stockist_id', $id);

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
                    $data['stockist_is_active'] = '1';
                    $this->function_lib->update_data('site_stockist', 'stockist_id', $id, $data);
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
                    $data['stockist_is_active'] = '0';
                    $this->function_lib->update_data('site_stockist', 'stockist_id', $id, $data);
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
        $params['table'] = "site_stockist";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->stockist_image != '' && file_exists($this->file_dir . $row->stockist_image)) {
                $image = $row->stockist_image;
            } else {
                $image = '_default.png';
            }
            $image = '<img src="' . base_url() . 'media/' . $this->file_dir . '110/110/' . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->stockist_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/stockist/edit/' . $row->stockist_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->stockist_id,
                'cell' => array(
                    'stockist_id' => $row->stockist_id,
                    'stockist_title' => $row->stockist_title,
                    'stockist_short_content' => $row->stockist_short_content,
                    'stockist_source' => $row->stockist_source,
                    'stockist_input_datetime' => convert_datetime($row->stockist_input_datetime, 'id'),
                    'stockist_image' => $image,
                    'stockist_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('place', '<b>Tempat Stockist</b>', 'required');
        $this->form_validation->set_rules('phone', '<b>No Tlp</b>', 'required');
        $this->form_validation->set_rules('time', '<b>Jam Kerja</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_stockist_phone', $this->input->post('phone'));
            $this->session->set_flashdata('input_stockist_place', $this->input->post('place'));
            $this->session->set_flashdata('input_stockist_time', $this->input->post('time'));
            redirect($this->input->post('uri_string'));
        } else {
            $stockist_title = $this->input->post('title');
            $stockist_place= $this->input->post('place');
            $stockist_phone = $this->input->post('phone');
            $stockist_time = $this->input->post('time');
            $datetime = date("Y-m-d H:i:s");

            $data = array();
            $data['stockist_title'] = $stockist_title;
            $data['stockist_place'] = $stockist_place;
            $data['stockist_phone'] = $stockist_phone;
            $data['stockist_time'] = $stockist_time;
            $data['stockist_input_administrator_id'] = $this->session->userdata('administrator_id');
            $data['stockist_input_datetime'] = $datetime;
            $data['stockist_is_active'] = 1;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width > $this->image_width || $height > $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($stockist_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['stockist_image'] = $image_filename;
            } else {
                $data['stockist_image'] = '';
            }
            $this->function_lib->insert_data('site_stockist', $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('place', '<b>Tempat Stockist</b>', 'required');
        $this->form_validation->set_rules('phone', '<b>No Tlp</b>', 'required');
        $this->form_validation->set_rules('time', '<b>Jam Kerja</b>', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_stockist_phone', $this->input->post('phone'));
            $this->session->set_flashdata('input_stockist_place', $this->input->post('place'));
            $this->session->set_flashdata('input_stockist_time', $this->input->post('time'));
            redirect($this->input->post('uri_string'));
        } else {

            $stockist_id = $this->input->post('id');
            $stockist_title = $this->input->post('title');
            $stockist_place= $this->input->post('place');
            $stockist_phone = $this->input->post('phone');
            $stockist_time = $this->input->post('time');
            $stockist_old_image = $this->input->post('old_image');

            $data = array();
            $data['stockist_title'] = $stockist_title;
            $data['stockist_place'] = $stockist_place;
            $data['stockist_phone'] = $stockist_phone;
            $data['stockist_time'] = $stockist_time;
            $data['stockist_input_administrator_id'] = $this->session->userdata('administrator_id');

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width > $this->image_width || $height > $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                    $this->image_lib->cropCenterImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($stockist_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($stockist_old_image != '' && file_exists($this->file_dir . $stockist_old_image)) {
                    @unlink($this->file_dir . $stockist_old_image);
                }

                $data['stockist_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_stockist', 'stockist_id', $stockist_id, $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
