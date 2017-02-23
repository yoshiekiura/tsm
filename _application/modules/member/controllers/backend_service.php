<?php

/*
 * Backend Service Member Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('member/backend_member_model');
        $this->load->helper('form');
        $this->load->library('encrypt');
        $this->config->load('key');

        $this->file_dir = _dir_member;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 200;
        $this->image_height = 200;
    }

    function act_show() {
        
        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';

        //publish
        if ($this->input->post('publish') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                foreach ($arr_item as $id) {
                    $data = array();
                    $data['member_is_active'] = '1';
                    $this->function_lib->update_data('sys_member', 'member_network_id', $id, $data);
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
                    $data['member_is_active'] = '0';
                    $this->function_lib->update_data('sys_member', 'member_network_id', $id, $data);
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
        $params['table'] = "view_member";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //detail
            $detail = '<a href="' . base_url() . 'backend/member/detail/' . $row->network_id . '"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Data Detail" title="Lihat Data Detail" /></a>';
            
            //edit
            $edit = '<a href="' . base_url() . 'backend/member/edit/' . $row->network_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';
            
            //edit password
            $edit_password = '<a href="' . base_url() . 'backend/member/password/' . $row->network_id . '"><img src="' . base_url() . _dir_icon . 'lock_edit.png" border="0" alt="Edit Password" title="Edit Password" /></a>';
            
            //autologin
            $autologin = '<a href="' . base_url() . 'backend_service/member/autologin/' . $row->network_id . '" target="_blank"><img src="' . base_url() . _dir_icon . 'lock_go.png" border="0" alt="Auto Login Member" title="Auto Login Member" /></a>';
            
            $entry = array('id' => $row->network_id,
                'cell' => array(
                    'network_id' => $row->network_id,
                    'network_code' => $row->network_code,
                    'network_position' => $row->network_position,
                    'network_position_text' => $row->network_position_text,
                    'network_total_downline_left' => $this->function_lib->set_number_format($row->network_total_downline_left),
                    'network_total_downline_right' => $this->function_lib->set_number_format($row->network_total_downline_right),
                    'member_name' => stripslashes($row->member_name),
                    'member_nickname' => $row->member_nickname,
                    'member_phone' => $row->member_phone,
                    'member_mobilephone' => $row->member_mobilephone,
                    'member_join_datetime' => convert_datetime($row->member_join_datetime, 'id'),
                    'member_last_login' => convert_datetime($row->member_last_login, 'id'),
                    'member_city_name' => $row->member_city_name,
                    'member_province_name' => $row->member_province_name,
                    'member_region_name' => $row->member_region_name,
                    'member_country_name' => $row->member_country_name,
                    'member_bank_name' => $row->member_bank_name,
                    'member_bank_city' => $row->member_bank_city,
                    'member_bank_branch' => $row->member_bank_branch,
                    'member_bank_account_name' => $row->member_bank_account_name,
                    'member_bank_account_no' => $row->member_bank_account_no,
                    'member_serial_id' => $row->member_serial_id,
                    'member_serial_pin' => $row->member_serial_pin,
                    'member_serial_type_label' => $row->member_serial_type_label,
                    'sponsor_network_code' => $row->sponsor_network_code,
                    'sponsor_member_name' => $row->sponsor_member_name,
                    'sponsor_member_nickname' => $row->sponsor_member_nickname,
                    'upline_network_code' => $row->upline_network_code,
                    'upline_member_name' => $row->upline_member_name,
                    'upline_member_nickname' => $row->upline_member_nickname,
                    'member_is_active' => $is_active,
                    'detail' => $detail,
                    'edit' => $edit,
                    'edit_password' => $edit_password,
                    'autologin' => $autologin
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function act_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('account_username', '<b>Username</b>', 'required|min_length[5]|max_length[15]|callback_username_check[' . $this->input->post('id') . ']');
        $this->form_validation->set_rules('name', '<b>Nama Lengkap</b>', 'required|callback_validate_name');
        // $this->form_validation->set_rules('nickname', '<b>Nama Alias</b>', 'required');
        // $this->form_validation->set_rules('detail_address', '<b>Alamat</b>', 'required');
        $this->form_validation->set_rules('city_id', '<b>Kota / Kabupaten</b>', 'required');
        $this->form_validation->set_rules('detail_sex', '<b>Jenis Kelamin</b>', 'required');
        // $this->form_validation->set_rules('detail_birth_date', '<b>Tanggal Lahir</b>', 'required');
        $this->form_validation->set_rules('mobilephone', '<b>No. Handphone</b>', 'required|callback_validate_phone');
        $this->form_validation->set_rules('bank_account_name', '<b>Nama Rekening</b>', 'min_length[3]|callback_validate_bank_account_name');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            $this->session->set_flashdata('input_nickname', $this->input->post('nickname'));
            $this->session->set_flashdata('input_city_id', $this->input->post('city_id'));
            $this->session->set_flashdata('input_country_id', $this->input->post('country_id'));
            $this->session->set_flashdata('input_phone', $this->input->post('phone'));
            $this->session->set_flashdata('input_mobilephone', $this->input->post('mobilephone'));
            $this->session->set_flashdata('input_detail_email', $this->input->post('detail_email'));
            $this->session->set_flashdata('input_detail_sex', $this->input->post('detail_sex'));
            $this->session->set_flashdata('input_detail_address', $this->input->post('detail_address'));
            $this->session->set_flashdata('input_detail_zipcode', $this->input->post('detail_zipcode'));
            $this->session->set_flashdata('input_detail_birth_place', $this->input->post('detail_birth_place'));
            $this->session->set_flashdata('input_detail_birth_date', $this->input->post('detail_birth_date'));
            $this->session->set_flashdata('input_detail_identity_type', $this->input->post('detail_identity_type'));
            $this->session->set_flashdata('input_detail_identity_no', $this->input->post('detail_identity_no'));
            $this->session->set_flashdata('input_bank_bank_id', $this->input->post('bank_bank_id'));
            $this->session->set_flashdata('input_bank_city', $this->input->post('bank_city'));
            $this->session->set_flashdata('input_bank_branch', $this->input->post('bank_branch'));
            $this->session->set_flashdata('input_bank_account_name', $this->input->post('bank_account_name'));
            $this->session->set_flashdata('input_bank_account_no', $this->input->post('bank_account_no'));
            $this->session->set_flashdata('input_devisor_name', $this->input->post('devisor_name'));
            $this->session->set_flashdata('input_devisor_relation', $this->input->post('devisor_relation'));
            $this->session->set_flashdata('input_devisor_phone', $this->input->post('devisor_phone'));
            $this->session->set_flashdata('input_account_username', $this->input->post('account_username'));
            redirect($this->input->post('uri_string'));
        } else {
            $member_network_id = $this->input->post('id');
            
            //sys_member
            $member_name = $this->input->post('name');
            $member_nickname = $this->input->post('nickname');
            $member_city_id = $this->input->post('city_id');
            $member_country_id = $this->input->post('country_id');
            $member_phone = $this->input->post('phone');
            $member_mobilephone = $this->input->post('mobilephone');
            
            //sys_member_detail
            $member_detail_email = $this->input->post('detail_email');
            $member_detail_sex = $this->input->post('detail_sex');
            $member_detail_address = $this->input->post('detail_address');
            $member_detail_zipcode = $this->input->post('detail_zipcode');
            $member_detail_birth_place = $this->input->post('detail_birth_place');
            $member_detail_birth_date = $this->input->post('detail_birth_date');
            $member_detail_identity_type = $this->input->post('detail_identity_type');
            $member_detail_identity_no = $this->input->post('detail_identity_no');
            $member_detail_old_image = $this->input->post('detail_old_image');
            
            //sys_member_bank
            $member_bank_bank_id = $this->input->post('bank_bank_id');
            $member_bank_city = $this->input->post('bank_city');
            $member_bank_branch = $this->input->post('bank_branch');
            $member_bank_account_name = $this->input->post('bank_account_name');
            $member_bank_account_no = $this->input->post('bank_account_no');
            
            //sys_member_devisor
            $member_devisor_name = $this->input->post('devisor_name');
            $member_devisor_relation = $this->input->post('devisor_relation');
            $member_devisor_phone = $this->input->post('devisor_phone');
            
            //sys_member_account
            $member_account_username = $this->input->post('account_username');
            
            $data_member = array();
            $data_member['member_name'] = addslashes($member_name);
            $data_member['member_nickname'] = $member_nickname;
            $data_member['member_city_id'] = $member_city_id;
            $data_member['member_country_id'] = $member_country_id;
            $data_member['member_phone'] = $member_phone;
            $data_member['member_mobilephone'] = $member_mobilephone;
            
            $data_member_detail = array();
            $data_member_detail['member_detail_email'] = $member_detail_email;
            $data_member_detail['member_detail_sex'] = $member_detail_sex;
            $data_member_detail['member_detail_address'] = $member_detail_address;
            $data_member_detail['member_detail_zipcode'] = $member_detail_zipcode;
            $data_member_detail['member_detail_birth_place'] = $member_detail_birth_place;
            if ($member_detail_birth_date) {
                $data_member_detail['member_detail_birth_date'] = $member_detail_birth_date;
            }
            $data_member_detail['member_detail_identity_type'] = $member_detail_identity_type;
            $data_member_detail['member_detail_identity_no'] = $member_detail_identity_no;
            
            $data_member_bank = array();
            $data_member_bank['member_bank_bank_id'] = $member_bank_bank_id;
            $data_member_bank['member_bank_city'] = $member_bank_city;
            $data_member_bank['member_bank_branch'] = $member_bank_branch;
            $data_member_bank['member_bank_account_name'] = addslashes($member_bank_account_name);
            $data_member_bank['member_bank_account_no'] = $member_bank_account_no;
            
            $data_member_devisor = array();
            $data_member_devisor['member_devisor_name'] = $member_devisor_name;
            $data_member_devisor['member_devisor_relation'] = $member_devisor_relation;
            $data_member_devisor['member_devisor_phone'] = $member_devisor_phone;
            
            $data_member_account = array();
            $data_member_account['member_account_username'] = $member_account_username;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                    $this->image_lib->cropCenterImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($member_account_username) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($member_detail_old_image != '' && file_exists($this->file_dir . $member_detail_old_image)) {
                    @unlink($this->file_dir . $member_detail_old_image);
                }

                $data_member_detail['member_detail_image'] = $image_filename;
            }
            $this->function_lib->update_data('sys_member', 'member_network_id', $member_network_id, $data_member);
            $this->function_lib->update_data('sys_member_detail', 'member_detail_network_id', $member_network_id, $data_member_detail);
            $this->function_lib->update_data('sys_member_bank', 'member_bank_network_id', $member_network_id, $data_member_bank);
            $this->function_lib->update_data('sys_member_devisor', 'member_devisor_network_id', $member_network_id, $data_member_devisor);
            $this->function_lib->update_data('sys_member_account', 'member_account_network_id', $member_network_id, $data_member_account);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function username_check($str, $id = null) {
        $check = $this->backend_member_model->check_username($str, $id);
        if ($check == true) {
            $this->form_validation->set_message('username_check', '%s telah digunakan');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function act_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', '<b>Password Baru</b>', 'required|matches[password_conf]');
        $this->form_validation->set_rules('password_conf', '<b>Ulangi Password Baru</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            redirect($this->input->post('uri_string'));
        } else {
            $member_network_id = $this->input->post('id');
            $member_account_password = $this->input->post('password');

            $data = array();
            $data['member_account_password'] = $this->encrypt->encode($member_account_password, $this->config->item('key_member'));
            $this->function_lib->update_data('sys_member_account', 'member_account_network_id', $member_network_id, $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function export_data() {
        $params = array();
        if(isset($_POST)) {
            foreach($_POST as $id => $value) {
                $params[$id] = $value;
            }
        }
        $params['params']['table'] = "view_member";
        
        if($params['params']['total_data'] <= 1000) {
            unset($params['params']['rp']);
            unset($params['params']['page']);
        }
        
        $data = array();
        $data['title'] = 'Data Member';
        $data['params'] = $params;
        $data['query'] = $this->function_lib->get_query_data($params['params']);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function act_geneology() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('search_network_code', '<b>Kode Member</b>', 'required');
        $this->session->set_flashdata('input_search_network_code', $this->input->post('search_network_code'));

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            redirect($this->input->post('uri_string'));
        } else {
            $network_code = $this->input->post('search_network_code');
            $check = $this->function_lib->get_one('sys_network', 'network_id', array('network_code' => $network_code));
            if($check != '') {
                redirect('backend/member/geneology/' . $network_code);
            } else {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><p>Data tidak ditemukan.</p><p>Silakan <a href="' . base_url() . $this->input->post('uri_string') . '">klik disini</a> untuk kembali ke Jaringan Member sebelumnya.</p></div>');
                $this->session->set_flashdata('notfound', true);
                redirect($this->input->post('uri_string'));
            }
        }
    }
    
    function get_member_info($network_code = '') {
        $network_id = $this->mlm_function->get_network_id($network_code);
        $data['arr_data'] = $this->mlm_function->get_arr_member_detail($network_id);
        $data['arr_data']['max_level_left'] = $this->mlm_function->get_member_max_level($network_id, 'L');
        $data['arr_data']['max_level_right'] = $this->mlm_function->get_member_max_level($network_id, 'R');
        $data['arr_data']['sponsoring_count_left'] = $this->mlm_function->get_member_sponsoring_count($network_id, 'L');
        $data['arr_data']['sponsoring_count_right'] = $this->mlm_function->get_member_sponsoring_count($network_id, 'R');
        template('blank', 'voffice/network_member_info_view', $data);
    }
    
    function autologin($network_id = 0) {
        $query = $this->backend_member_model->get_detail($network_id);
        if($query->num_rows() > 0) {
            $row = $query->row();
            
            //network_group
            $query_network_group = $this->backend_member_model->get_list_member_group($row->network_id);
            $arr_member_group = array();
            if($query_network_group->num_rows() > 0) {
                $arr_member_group[$row->network_id] = $row->network_code;
                foreach($query_network_group->result() as $row_network_group) {
                    $arr_member_group[$row_network_group->network_id] = $row_network_group->network_code;
                }
                $parent_group_network_id = $row->network_id;
            } else {
                $parent_group_network_id = 0;
            }
            
            $array_items = array(
                'network_id' => $row->network_id,
                'network_code' => $row->network_code,
                'member_name' => $row->member_name,
                'member_nickname' => $row->member_nickname,
                'member_last_login' => $row->member_last_login,
                'member_detail_image' => $row->member_detail_image,
                'parent_group_network_id' => $parent_group_network_id,
                'arr_member_group' => $arr_member_group,
                'member_logged_in' => true,
            );
            
            $this->session->set_userdata($array_items);
            redirect('voffice/dashboard');
        } else {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Terjadi kesalahan pada sistem.</div>');
            redirect('backend/dashboard');
        }
    }

    function validate_phone($num) {
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

    function validate_name($name, $label='Nama') {
        $is_error = false;
        // validasi karakter (hanya angka dan spasi)
        if ( ! preg_match("/^[a-zA-Z .,']+$/", $name)) {
            $is_error = true;
            $msg = '<b>Nama Lengkap</b> hanya boleh mengandung karakter huruf, spasi, petik satu, titik dan koma.';
        }

        if (!$is_error) {
            return true;
        } else {
            $this->form_validation->set_message('validate_name', $msg);
            return false;
        }
    }

    public function validate_bank_account_name($name) {
        $is_error = false;
        // jika kosong
        if (empty($name) OR $name == '') {
            return true;
        }

        // validasi karakter (hanya angka dan spasi)
        if ( ! preg_match("/^[a-zA-Z .,']+$/", $name)) {
            $is_error = true;
            $msg = '<b>Nama Nasabah</b> hanya boleh mengandung karakter huruf, spasi, petik satu, titik dan koma.';
        }

        if (!$is_error) {
            return true;
        } else {
            $this->form_validation->set_message('validate_bank_account_name', $msg);
            return false;
        }
    }

}
