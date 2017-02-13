<?php

/*
 * Backend Service Systems Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('systems/backend_systems_model');
        $this->load->helper('form');
        $this->load->library('encrypt');
        $this->config->load('key');
        
        $this->image_width = 96;
        $this->image_height = 96;
    }

    function act_profile() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('username', '<b>Username</b>', 'required|min_length[5]|max_length[15]|callback_username_check[' . $this->session->userdata('administrator_id') . ']');
        $this->form_validation->set_rules('name', '<b>Nama</b>', 'required');
        $this->form_validation->set_rules('mobilephone', '<b>No. Hp</b>', 'required|min_length[5]|max_length[15]|callback_validate_phone');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            redirect($this->input->post('uri_string'));
        } else {
            $administrator_id = $this->session->userdata('administrator_id');
            $administrator_username = $this->input->post('username');
            $administrator_name = $this->input->post('name');
            $administrator_email = $this->input->post('email');
            $administrator_mobilephone = $this->input->post('mobilephone');
            $administrator_old_image = $this->input->post('old_image');

            $data = array();
            $data['administrator_username'] = $administrator_username;
            $data['administrator_name'] = $administrator_name;
            $data['administrator_email'] = $administrator_email;
            $data['administrator_mobilephone'] = $administrator_mobilephone;

            if ($this->upload->fileUpload('image', _dir_administrator, 'gif|jpg|png')) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                    $this->image_lib->cropCenterImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($administrator_name) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($administrator_old_image != '' && file_exists(_dir_administrator . $administrator_old_image)) {
                    @unlink(_dir_administrator . $administrator_old_image);
                }

                $data['administrator_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_administrator', 'administrator_id', $administrator_id, $data);
            $this->session->set_userdata($data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_password', '<b>Password Lama</b>', 'required|callback_password_check[' . $this->session->userdata('administrator_id') . ']');
        $this->form_validation->set_rules('password', '<b>Password Baru</b>', 'required|matches[password_conf]');
        $this->form_validation->set_rules('password_conf', '<b>Ulangi Password Baru</b>', 'required');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            redirect($this->input->post('uri_string'));
        } else {
            $administrator_id = $this->session->userdata('administrator_id');
            $administrator_password = $this->input->post('password');
            
            $data = array();
            $data['administrator_password'] = $this->encrypt->encode($administrator_password, $this->config->item('key_administrator'));
            $this->function_lib->update_data('site_administrator', 'administrator_id', $administrator_id, $data);
            $this->session->set_userdata($data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function username_check($str, $id = null) {
        $check = $this->backend_systems_model->check_username($str, $id);
        if ($check == true) {
            $this->form_validation->set_message('username_check', '%s telah digunakan');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function password_check($str, $id) {
        $ecrypted_password = $this->backend_systems_model->get_administrator_password($id);
        $administrator_password = $this->encrypt->decode($ecrypted_password, $this->config->item('key_administrator'));
        if ($str === $administrator_password) {
            return TRUE;
        } else {
            $this->form_validation->set_message('password_check', '%s belum benar');
            return FALSE;
        }
    }

    public function validate_phone($num) {
        $is_error = false;
        // validasi karakter (hanya angka)
        if ( ! ctype_digit($num)) {
            $is_error = true;
            $msg = '<b>Nomor Handphone</b> hanya boleh mengandung karakter angka.';
        }

        // blacklist phone_number
        $black_list = array('12345678', '01234567');
        $max_length = 8;
        for ($i=0; $i <= $max_length; $i++) { 
            $black_list[] = str_repeat($i, $max_length);
        }
        if ($is_error == false && in_array(substr($num, 0, $max_length), $black_list)) {
            $is_error = true;
            $msg = '<b>Nomor Handphone</b> tidak valid.';
        }

        if (!$is_error) {
            return true;
        } else {
            $this->form_validation->set_message('validate_phone', $msg);
            return false;
        }
    }

}
