<?php

/*
 * Backend Service Administrator Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_Service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('administrator/backend_administrator_model');
        $this->load->helper('form');
        $this->load->library('encrypt');
        $this->config->load('key');

        $this->file_dir = _dir_administrator;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 96;
        $this->image_height = 96;
    }

    function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_administrator";
        $params['join'] = "INNER JOIN site_administrator_group ON administrator_group_id = administrator_administrator_group_id";
        if($this->session->userdata('administrator_group_type') != 'superuser') {
            $params['where'] = "administrator_group_type != 'superuser'";
        }
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->administrator_image != '' && file_exists($this->file_dir . $row->administrator_image)) {
                $image = $row->administrator_image;
            } else {
                $image = '_default.png';
            }
            $image = '<img src="' . base_url() . $this->file_dir . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->administrator_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/administrator/edit/' . $row->administrator_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';
            
            //edit password
            $edit_password = '<a href="' . base_url() . 'backend/administrator/password/' . $row->administrator_id . '"><img src="' . base_url() . _dir_icon . 'lock_edit.png" border="0" alt="Edit Password" title="Edit Password" /></a>';
            
            $entry = array('id' => $row->administrator_id,
                'cell' => array(
                    'administrator_id' => $row->administrator_id,
                    'administrator_group_title' => $row->administrator_group_title,
                    'administrator_username' => $row->administrator_username,
                    'administrator_name' => $row->administrator_name,
                    'administrator_email' => $row->administrator_email,
                    'administrator_last_login' => convert_datetime($row->administrator_last_login, 'id'),
                    'administrator_image' => $image,
                    'administrator_is_active' => $is_active,
                    'edit' => $edit,
                    'edit_password' => $edit_password
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
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
                    $check_delete = $this->backend_administrator_model->check_delete($id);
                    if($check_delete == true) {
                        
                        //hapus file gambar
                        $filename = $this->function_lib->get_one('site_administrator', 'administrator_image', array('administrator_id' => $id));
                        if ($filename != '' && file_exists($this->file_dir . $filename)) {
                            @unlink($this->file_dir . $filename);
                        }
                        
                        //hapus data
                        $this->function_lib->delete_data('site_administrator', 'administrator_id', $id);
                        
                        $item_deleted++;
                    } else {
                        $item_undeleted++;
                    }
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
                    $data['administrator_is_active'] = '1';
                    $this->function_lib->update_data('site_administrator', 'administrator_id', $id, $data);
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
                    $data['administrator_is_active'] = '0';
                    $this->function_lib->update_data('site_administrator', 'administrator_id', $id, $data);
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

    function act_add() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('username', '<b>Username</b>', 'required|min_length[5]|max_length[15]|unique[site_administrator.administrator_username]');
        $this->form_validation->set_rules('password', '<b>Password Baru</b>', 'required|matches[password_conf]');
        $this->form_validation->set_rules('password_conf', '<b>Ulangi Password Baru</b>', 'required');
        $this->form_validation->set_rules('name', '<b>Nama</b>', 'required');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_administrator_group_id', $this->input->post('administrator_group_id'));
            $this->session->set_flashdata('input_username', $this->input->post('username'));
            $this->session->set_flashdata('input_password', $this->input->post('password'));
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            $this->session->set_flashdata('input_email', $this->input->post('email'));
            redirect($this->input->post('uri_string'));
        } else {
            $administrator_group_id = $this->input->post('administrator_group_id');
            $administrator_username = $this->input->post('username');
            $administrator_password = $this->input->post('password');
            $administrator_name = $this->input->post('name');
            $administrator_email = $this->input->post('email');

            $data = array();
            $data['administrator_administrator_group_id'] = $administrator_group_id;
            $data['administrator_username'] = $administrator_username;
            $data['administrator_password'] = $this->encrypt->encode($administrator_password, $this->config->item('key_administrator'));
            $data['administrator_name'] = $administrator_name;
            $data['administrator_email'] = $administrator_email;
            $data['administrator_is_active'] = 1;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
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
                $data['administrator_image'] = $image_filename;
            } else {
                $data['administrator_image'] = '';
            }
            $this->function_lib->insert_data('site_administrator', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('username', '<b>Username</b>', 'required|min_length[5]|max_length[15]|unique[site_administrator.administrator_username.administrator_id.' . $this->input->post('id') . ']');
        $this->form_validation->set_rules('name', '<b>Nama</b>', 'required');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_administrator_group_id', $this->input->post('administrator_group_id'));
            $this->session->set_flashdata('input_username', $this->input->post('username'));
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            $this->session->set_flashdata('input_email', $this->input->post('email'));
            redirect($this->input->post('uri_string'));
        } else {
            $administrator_id = $this->input->post('id');
            $administrator_group_id = $this->input->post('administrator_group_id');
            $administrator_username = $this->input->post('username');
            $administrator_name = $this->input->post('name');
            $administrator_email = $this->input->post('email');
            $administrator_old_image = $this->input->post('old_image');

            $data = array();
            $data['administrator_administrator_group_id'] = $administrator_group_id;
            $data['administrator_username'] = $administrator_username;
            $data['administrator_name'] = $administrator_name;
            $data['administrator_email'] = $administrator_email;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
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
                if ($administrator_old_image != '' && file_exists($this->file_dir . $administrator_old_image)) {
                    @unlink($this->file_dir . $administrator_old_image);
                }

                $data['administrator_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_administrator', 'administrator_id', $administrator_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function act_password() {
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('old_password', '<b>Password Lama</b>', 'required|callback_password_check[' . $this->input->post('id') . ']');
        $this->form_validation->set_rules('password', '<b>Password Baru</b>', 'required|matches[password_conf]');
        $this->form_validation->set_rules('password_conf', '<b>Ulangi Password Baru</b>', 'required');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            redirect($this->input->post('uri_string'));
        } else {
            $administrator_id = $this->input->post('id');
            $administrator_password = $this->input->post('password');
            
            $data = array();
            $data['administrator_password'] = $this->encrypt->encode($administrator_password, $this->config->item('key_administrator'));
            $this->function_lib->update_data('site_administrator', 'administrator_id', $administrator_id, $data);
            $this->session->set_userdata($data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data has been saved successfully.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function password_check($str, $id) {
        $ecrypted_password = $this->backend_administrator_model->get_administrator_password($id);
        $administrator_password = $this->encrypt->decode($ecrypted_password, $this->config->item('key_administrator'));
        if ($str === $administrator_password) {
            return TRUE;
        } else {
            $this->form_validation->set_message('password_check', '%s salah');
            return FALSE;
        }
    }

}
