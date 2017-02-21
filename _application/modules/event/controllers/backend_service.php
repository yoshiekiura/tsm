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

        $this->load->model('event/backend_event_model');
        $this->load->helper('form');

        $this->file_dir = _dir_event;
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
                    $filename = $this->function_lib->get_one('site_event', 'event_image', array('event_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir . $filename)) {
                        @unlink($this->file_dir . $filename);
                    }

                    //hapus data
                    $this->function_lib->delete_data('site_event', 'event_id', $id);
                    
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
                    $data['event_is_active'] = '1';
                    $this->function_lib->update_data('site_event', 'event_id', $id, $data);
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
                    $data['event_is_active'] = '0';
                    $this->function_lib->update_data('site_event', 'event_id', $id, $data);
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
        $params['table'] = "site_event";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->event_image != '' && file_exists($this->file_dir . $row->event_image)) {
                $image = $row->event_image;
            } else {
                $image = '_default.png';
            }
            $image = '<img src="' . base_url() . 'media/' . $this->file_dir . '110/110/' . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->event_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/event/edit/' . $row->event_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->event_id,
                'cell' => array(
                    'event_id' => $row->event_id,
                    'event_title' => $row->event_title,
                    'event_city' => $row->event_city,
                    'event_description' => $row->event_description,
                    'event_date' => date_converter($row->event_date, 'd F Y'),
                    'event_input_datetime' => convert_datetime($row->event_input_datetime, 'id'),
                    'event_image' => $image,
                    'event_is_active' => $is_active,
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
        $this->form_validation->set_rules('event_description', '<b>Isi</b>', 'required');
        $this->form_validation->set_rules('event_city', '<b>Kota</b>', 'required');
        $this->form_validation->set_rules('event_date', '<b>Tanggal Event</b>', 'required');
        $this->form_validation->set_rules('event_place', '<b>Tempat Event</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_event_city', $this->input->post('event_city'));
            $this->session->set_flashdata('input_event_description', $this->input->post('event_description'));
            $this->session->set_flashdata('input_event_note', $this->input->post('event_note'));
            $this->session->set_flashdata('input_event_place', $this->input->post('event_place'));
            $this->session->set_flashdata('input_event_date', $this->input->post('event_date'));
            redirect($this->input->post('uri_string'));
        } else {
            $event_title = $this->input->post('title');
            $event_description = $this->input->post('event_description');
            $event_note = $this->input->post('event_note');
            $event_place = $this->input->post('event_place');
            $event_date = $this->input->post('event_date');
            $event_city = $this->input->post('event_city');
            $event_time = $this->input->post('event_time');
            $event_type = $this->input->post('event_type');
            $event_ticket = $this->input->post('event_ticket');
            $datetime = date("Y-m-d H:i:s");
            $event_old_image = $this->input->post('old_image');
            
            $data = array();
            $data['event_title'] = $event_title;
            $data['event_city'] = $event_city;
            $data['event_description'] = $event_description;
            $data['event_note'] = $event_note;
            $data['event_type'] = $event_type;
            $data['event_time'] = $event_time;
            $data['event_ticket'] = $event_ticket;
            $data['event_place'] = $event_place;
            $data['event_date'] = $event_date;
            $data['event_input_administrator_id'] = $this->session->userdata('administrator_id');
            $data['event_input_datetime'] = $datetime;
            $data['event_is_active'] = 1;

           if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width > $this->image_width || $height > $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                    $this->image_lib->cropCenterImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($event_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($event_old_image != '' && file_exists($this->file_dir . $event_old_image)) {
                    @unlink($this->file_dir . $event_old_image);
                }

                $data['event_image'] = $image_filename;
            } else {
                $data['event_image'] = '';
            }
            $this->function_lib->insert_data('site_event', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
       $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('event_description', '<b>Isi</b>', 'required');
        $this->form_validation->set_rules('event_city', '<b>Kota</b>', 'required');
        $this->form_validation->set_rules('event_date', '<b>Tanggal Event</b>', 'required');
        $this->session->set_flashdata('input_event_place', $this->input->post('event_place'));

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_event_city', $this->input->post('event_city'));
            $this->session->set_flashdata('input_event_description', $this->input->post('event_description'));
            $this->session->set_flashdata('input_event_note', $this->input->post('event_note'));
            $this->session->set_flashdata('input_event_date', $this->input->post('event_date'));
            $this->session->set_flashdata('input_event_place', $this->input->post('event_place'));
            redirect($this->input->post('uri_string'));
        } else {
            $event_id = $this->input->post('id');
            $event_title = $this->input->post('title');
            $event_description = $this->input->post('event_description');
            $event_note = $this->input->post('event_note');
            $event_date = $this->input->post('event_date');
            $event_city = $this->input->post('event_city');
            $event_time = $this->input->post('event_time');
            $event_type = $this->input->post('event_type');
            $event_ticket = $this->input->post('event_ticket');
            $datetime = date("Y-m-d H:i:s");
            $event_old_image = $this->input->post('old_image');
            
            $data = array();
            $data['event_title'] = $event_title;
            $data['event_city'] = $event_city;
            $data['event_type'] = $event_type;
            $data['event_time'] = $event_time;
            $data['event_ticket'] = $event_ticket;
            $data['event_description'] = $event_description;
            $data['event_note'] = $event_note;
            $data['event_date'] = $event_date;
            $data['event_input_administrator_id'] = $this->session->userdata('administrator_id');
            $data['event_input_datetime'] = $datetime;
            $data['event_is_active'] = 1;

             if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width > $this->image_width || $height > $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                    $this->image_lib->cropCenterImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($event_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($event_old_image != '' && file_exists($this->file_dir . $event_old_image)) {
                    @unlink($this->file_dir . $event_old_image);
                }

                $data['event_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_event', 'event_id', $event_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
