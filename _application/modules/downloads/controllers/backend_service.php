<?php

/*
 * Backend Service Downloads Controller
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

        $this->load->model('downloads/backend_downloads_model');
        $this->load->helper('form');

        $this->file_dir = _dir_downloads;
        $this->allowed_file_type = 'pdf|docx|xls|xlsx|ppt|pptx|pps|ppsx|rar|zip|jpg|jpeg|png';
        $this->max_file = 980240; //The maximum size (in kilobytes)
        //byte converter http://www.whatsabyte.com/P1/byteconverter.htm
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
                    //hapus file
                    $filename = $this->function_lib->get_one('site_downloads', 'downloads_file', array('downloads_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir . $filename)) {
                        @unlink($this->file_dir . $filename);
                    }

                    //hapus data
                    $this->function_lib->delete_data('site_downloads', 'downloads_id', $id);
                    $item_deleted++;
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
                    $data['downloads_is_active'] = '1';
                    $this->function_lib->update_data('site_downloads', 'downloads_id', $id, $data);
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
                    $data['downloads_is_active'] = '0';
                    $this->function_lib->update_data('site_downloads', 'downloads_id', $id, $data);
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
        $params['select'] = "
            *, 
            (
                CASE downloads_location 
                WHEN 'public' THEN 'Umum' 
                WHEN 'member' THEN 'Member' 
                ELSE '-'
                END
            ) AS downloads_location_text 
        ";
        $params['table'] = "site_downloads";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //file icon
            if ($row->downloads_file != '') {
                $this->load->library('image_lib');
                $arr_filename = $this->image_lib->explode_name($row->downloads_file);
                $file_ext = $arr_filename['ext'];
                $filetype = str_replace('.', '', $file_ext);
                $filetype_icon = 'icon-' . $filetype . '.png';
                if (!file_exists(_dir_filetypes . $filetype_icon)) {
                    $filetype_icon = '_default.png';
                    $icon = $file_ext;
                } else {
                    $icon = '<img src="' . base_url() . _dir_filetypes . $filetype_icon . '" title="' . $file_ext . '" alt="' . $file_ext . '" />';
                    //$icon = $file_ext;
                }
            } else {
                $file_ext = '-';
                $filetype = '-';
                $filetype_icon = '_default.png';
                $icon = '-';
            }

            //downloads link & file size
            if ($row->downloads_file != '' && file_exists($this->file_dir . $row->downloads_file)) {
                $downloads_link = '<a href="' . base_url() . 'voffice/downloads/getfile/' . $row->downloads_id . '/' . $row->downloads_file . '"><img src="' . base_url() . _dir_icon . 'downloads.png" border="0" alt="Download" title="Download" /></a>';
                $downloads_filesize = get_filesize($this->file_dir . $row->downloads_file);
            } else {
                $downloads_link = '<img src="' . base_url() . _dir_icon . 'downloads_disabled.png" border="0" alt="File tidak tersedia" title="File tidak tersedia" />';
                $downloads_filesize = '-';
            }

            //is_active
            if ($row->downloads_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/downloads/edit/' . $row->downloads_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->downloads_id,
                'cell' => array(
                    'downloads_id' => $row->downloads_id,
                    'downloads_title' => $row->downloads_title,
                    'downloads_description' => nl2br($row->downloads_description),
                    'downloads_location' => $row->downloads_location,
                    'downloads_location_text' => $row->downloads_location_text,
                    'downloads_count' => $row->downloads_count,
                    'downloads_input_datetime' => convert_datetime($row->downloads_input_datetime, 'id'),
                    'downloads_filesize' => $downloads_filesize,
                    'downloads_link' => $downloads_link,
                    'downloads_file_ext' => $file_ext,
                    'downloads_filetype' => strtoupper($filetype),
                    'downloads_icon' => $icon,
                    'downloads_is_active' => $is_active,
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
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_location', $this->input->post('location'));
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_description', $this->input->post('description'));
            redirect($this->input->post('uri_string'));
        } elseif ($this->upload->fileUpload('file', $this->file_dir, $this->allowed_file_type, $this->max_file)) {
            $upload = $this->upload->data();

            $file_filename = url_title($upload['raw_name']) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
            rename($upload['full_path'], $upload['file_path'] . $file_filename);

            $downloads_title = $this->input->post('title');
            $downloads_location = $this->input->post('location');
            $downloads_description = $this->input->post('description');
            $downloads_input_datetime = date("Y-m-d H:i:s");
            $downloads_file = $file_filename;

            $data = array();
            $data['downloads_title'] = $downloads_title;
            $data['downloads_description'] = $downloads_description;
            $data['downloads_file'] = $downloads_file;
            $data['downloads_location'] = $downloads_location;
            $data['downloads_input_datetime'] = $downloads_input_datetime;
            $data['downloads_is_active'] = 1;
            $this->function_lib->insert_data('site_downloads', $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        } else {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . $this->upload->display_errors() . '</div>');
            $this->session->set_flashdata('input_location', $this->input->post('location'));
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_description', $this->input->post('description'));
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_location', $this->input->post('location'));
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_description', $this->input->post('description'));
            redirect($this->input->post('uri_string'));
        } elseif (isset($_FILES['file']['size']) && $_FILES['file']['size'] > 0) {
            if ($this->upload->fileUpload('file', $this->file_dir, $this->allowed_file_type, $this->max_file)) {
                $upload = $this->upload->data();

                $file_filename = url_title($upload['raw_name']) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $file_filename);

                $downloads_id = $this->input->post('id');
                $downloads_title = $this->input->post('title');
                $downloads_location = $this->input->post('location');
                $downloads_description = $this->input->post('description');
                $downloads_old_file = $this->input->post('old_file');

                $data = array();
                $data['downloads_title'] = $downloads_title;
                $data['downloads_location'] = $downloads_location;
                $data['downloads_description'] = $downloads_description;
                $data['downloads_file'] = $file_filename;
                $this->function_lib->update_data('site_downloads', 'downloads_id', $downloads_id, $data);

                //delete old file
                if ($downloads_old_file != '' && file_exists($this->file_dir . $downloads_old_file)) {
                    @unlink($this->file_dir . $downloads_old_file);
                }

                $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
                redirect($this->input->post('uri_string'));
            } else {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . $this->upload->display_errors() . '</div>');
                $this->session->set_flashdata('input_location', $this->input->post('location'));
                $this->session->set_flashdata('input_title', $this->input->post('title'));
                $this->session->set_flashdata('input_description', $this->input->post('description'));
                redirect($this->input->post('uri_string'));
            }
        } else {
            $downloads_id = $this->input->post('id');
            $downloads_title = $this->input->post('title');
            $downloads_description = $this->input->post('description');
            $downloads_location = $this->input->post('location');
            
            $data = array();
            $data['downloads_title'] = $downloads_title;
            $data['downloads_location'] = $downloads_location;
            $data['downloads_description'] = $downloads_description;
            $this->function_lib->update_data('site_downloads', 'downloads_id', $downloads_id, $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
