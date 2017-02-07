<?php

/*
 * Backend Service Page Marketing Plan Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('backend_page_mp_model');
        $this->load->helper('form');

        $this->file_dir = _dir_marketing_plan;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 1600;
        $this->image_height = 1600;
    }

    function act_show() {
        //delete
        if ($this->input->post('delete') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_deleted = 0;
                foreach ($arr_item as $id) {
                    //hapus halaman
                    $this->function_lib->delete_data('site_page_mp', 'page_mp_id', $id);

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
                    $data['page_mp_is_active'] = '1';
                    $this->function_lib->update_data('site_page_mp', 'page_mp_id', $id, $data);
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
                    $data['page_mp_is_active'] = '0';
                    $this->function_lib->update_data('site_page_mp', 'page_mp_id', $id, $data);
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
        $params['table'] = "site_page_mp";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->page_mp_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/page_mp/edit/' . $row->page_mp_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->page_mp_id,
                'cell' => array(
                    'page_mp_id' => $row->page_mp_id,
                    'page_mp_title' => $row->page_mp_title,
                    'page_mp_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_add() {
//        print_r($_POST);
//        die();
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');

        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        //$this->form_validation->set_rules('mp_content', '<b>Isi</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            //$this->session->set_flashdata('input_content', $this->input->post('mp_content'));
            redirect($this->input->post('uri_string'));
        } else {
            $page_title = $this->input->post('title');
            $page_content = $this->input->post('mp_content');

            $data = array();
            $data['page_mp_title'] = $page_title;
            $data['page_mp_content'] = $page_content;
            $data['page_mp_is_active'] = '1';

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($page_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['page_mp_image'] = $image_filename;
            } else {
                $data['page_mp_image'] = 'aaa';
            }


            $this->function_lib->insert_data('site_page_mp', $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');

        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        //$this->form_validation->set_rules('mp_content', '<b>Isi</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            //$this->session->set_flashdata('input_content', $this->input->post('mp_content'));
            redirect($this->input->post('uri_string'));
        } else {
            $page_mp_id = $this->input->post('id');
            $page_mp_title = $this->input->post('title');
            $page_content = $this->input->post('mp_content');
            $gallery_old_image = $this->input->post('old_image');

            $data = array();
            $data['page_mp_title'] = $page_mp_title;
            $data['page_mp_content'] = $page_content;
            $data['page_mp_is_active'] = '1';
            
            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($page_mp_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($gallery_old_image != '' && file_exists($this->file_dir . $gallery_old_image)) {
                    @unlink($this->file_dir . $gallery_old_image);
                }

                $data['page_mp_image'] = $image_filename;
            }
            
            $this->function_lib->update_data('site_page_mp', 'page_mp_id', $page_mp_id, $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}

?>
