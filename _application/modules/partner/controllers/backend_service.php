<?php

/*
 * Backend Service News Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('partner/backend_partner_model');
        $this->load->helper('form');

        $this->file_dir = _dir_partner;
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
                    $filename = $this->function_lib->get_one('site_partner', 'partner_image', array('partner_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir . $filename)) {
                        @unlink($this->file_dir . $filename);
                    }

                    //hapus data
                    $this->function_lib->delete_data('site_partner', 'partner_id', $id);
                    
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
                    $data['partner_is_active'] = '1';
                    $this->function_lib->update_data('site_partner', 'partner_id', $id, $data);
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
                    $data['partner_is_active'] = '0';
                    $this->function_lib->update_data('site_partner', 'partner_id', $id, $data);
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
        $params['table'] = "site_partner";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->partner_image != '' && file_exists($this->file_dir . $row->partner_image)) {
                $image = $row->partner_image;
            } else {
                $image = '_default.png';
            }
            $image = '<img src="' . base_url() . 'media/' . $this->file_dir . '110/110/' . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->partner_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/partner/edit/' . $row->partner_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->partner_id,
                'cell' => array(
                    'partner_id' => $row->partner_id,
                    'partner_title' => $row->partner_title,
                    'partner_short_content' => $row->partner_short_content,
                    
                    'partner_input_datetime' => convert_datetime($row->partner_input_datetime, 'id'),
                    'partner_image' => $image,
                    'partner_is_active' => $is_active,
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
        $this->form_validation->set_rules('short_content', '<b>Deskripsi</b>', 'required');
        $this->form_validation->set_rules('partner_content', '<b>Isi</b>', 'required');
        

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_short_content', $this->input->post('short_content'));
            $this->session->set_flashdata('input_partner_content', $this->input->post('partner_content'));
            $this->session->set_flashdata('input_source', $this->input->post('source'));
            $this->session->set_flashdata('input_partner_price', $this->input->post('partner_price'));
            redirect($this->input->post('uri_string'));
        } else {
            $partner_title = $this->input->post('title');
            $partner_short_content = $this->input->post('short_content');
            $partner_content = $this->input->post('partner_content');
            
            
            $datetime = date("Y-m-d H:i:s");

            $data = array();
            $data['partner_title'] = $partner_title;
            $data['partner_short_content'] = $partner_short_content;
            $data['partner_content'] = $partner_content;
            
           
            $data['partner_input_administrator_id'] = $this->session->userdata('administrator_id');
            $data['partner_input_datetime'] = $datetime;
            $data['partner_is_active'] = 1;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width > $this->image_width || $height > $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($partner_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['partner_image'] = $image_filename;
            } else {
                $data['partner_image'] = '';
            }
            $this->function_lib->insert_data('site_partner', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('short_content', '<b>Deskripsi</b>', 'required');
        $this->form_validation->set_rules('partner_content', '<b>Isi</b>', 'required');
        

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_short_content', $this->input->post('short_content'));
            $this->session->set_flashdata('input_partner_content', $this->input->post('partner_content'));
            $this->session->set_flashdata('input_source', $this->input->post('source'));
            $this->session->set_flashdata('input_partner_price', $this->input->post('partner_price'));
            redirect($this->input->post('uri_string'));
        } else {
            
            $partner_id = $this->input->post('id');
            $partner_title = $this->input->post('title');
            $partner_short_content = $this->input->post('short_content');
            $partner_content = $this->input->post('partner_content');
            
            
            $partner_old_image = $this->input->post('old_image');

            $data = array();
            $data['partner_title'] = $partner_title;
            $data['partner_short_content'] = $partner_short_content;
            $data['partner_content'] = $partner_content;
            
           
            $data['partner_input_administrator_id'] = $this->session->userdata('administrator_id');

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width > $this->image_width || $height > $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                    $this->image_lib->cropCenterImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($partner_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($partner_old_image != '' && file_exists($this->file_dir . $partner_old_image)) {
                    @unlink($this->file_dir . $partner_old_image);
                }

                $data['partner_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_partner', 'partner_id', $partner_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
