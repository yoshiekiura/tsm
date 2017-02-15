<?php

/*
 * Member Systems Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Systems extends Member_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('voffice/systems_model');
        $this->load->helper('form');
        $this->load->library('encrypt');
        $this->config->load('key');
        $this->load->helper('is_serialized');

        $this->file_dir = _dir_member;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 200;
        $this->image_height = 200;
    }

    function index() {
        $this->profile();
    }

    function profile() {
        $data['page_title'] = 'Ubah Data Profil';
        $data['arr_breadcrumbs'] = array(
            'Profil' => 'voffice/systems/profile',
        );

        $data['identity_type_options'] = $this->function_lib->get_identity_type_options();
        $data['sex_options'] = $this->function_lib->get_sex_options();
        $data['city_options'] = $this->function_lib->get_city_province_options();
        $data['country_options'] = $this->function_lib->get_country_options();
        $data['bank_options'] = $this->function_lib->get_bank_options();

        $data['query'] = $this->systems_model->get_detail($this->session->userdata('network_id'));
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'voffice/systems/act_profile';

        template('member', 'voffice/systems_profile_edit_view', $data);
    }

    function act_profile() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('account_username', '<b>Username</b>', 'required|min_length[5]|max_length[15]|callback_username_check[' . $this->session->userdata('network_id') . ']');
        $this->form_validation->set_rules('name', '<b>Nama Lengkap</b>', 'required|min_length[3]|callback_validate_name[Nama Lengkap]');
        // $this->form_validation->set_rules('nickname', '<b>Nama Alias</b>', 'required|min_length[3]|callback_validate_name[Nama Alias]');
        // $this->form_validation->set_rules('detail_address', '<b>Alamat</b>', 'required');
        $this->form_validation->set_rules('city_id', '<b>Kota / Kabupaten</b>', 'required');
        $this->form_validation->set_rules('detail_sex', '<b>Jenis Kelamin</b>', 'required');
        // $this->form_validation->set_rules('detail_birth_date', '<b>Tanggal Lahir</b>', 'required');
        // $this->form_validation->set_rules('mobilephone', '<b>No. Handphone</b>', 'required');
        
        // VALIDASI PIN SERIAL
        $this->form_validation->set_rules('validate_pin', '<b>PIN Serial</b>', 'required|callback_validate_pin');

        if ($this->form_validation->run($this) == FALSE) {
            // $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $arr_message = array();
            $arr_message['message'] = '<div class="error alert alert-danger"><div class="alert-title"><b>PROSES REGISTRASI GAGAL DILAKUKAN</b></div><ul>' . validation_errors() . '</ul></div>';
            $_SESSION['input_message'] = serialize($arr_message);
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
            $network_id = $this->session->userdata('network_id');

            // sys_member
            $member_name = $this->input->post('name');
            $member_nickname = $this->input->post('nickname');
            $member_city_id = $this->input->post('city_id');
            $member_country_id = $this->input->post('country_id');
            $member_phone = $this->input->post('phone');

            if ($this->input->post('mobilephone') != false) {
                $member_mobilephone = $this->input->post('mobilephone');
            }

            // $member_mobilephone = $this->input->post('mobilephone');
            // sys_member_detail
            $member_detail_email = $this->input->post('detail_email');
            $member_detail_sex = $this->input->post('detail_sex');
            $member_detail_address = $this->input->post('detail_address');
            $member_detail_zipcode = $this->input->post('detail_zipcode');
            $member_detail_birth_place = $this->input->post('detail_birth_place');
            $date = str_replace('/', '-', $this->input->post('detail_birth_date'));
            $member_detail_birth_date = date('Y-m-d', strtotime($date));
                    //$this->input->post('detail_birth_date');
            $member_detail_identity_type = $this->input->post('detail_identity_type');
            $member_detail_identity_no = $this->input->post('detail_identity_no');
            $member_detail_old_image = $this->input->post('detail_old_image');

            // sys_member_bank
            $member_bank_bank_id = $this->input->post('bank_bank_id');
            $member_bank_city = $this->input->post('bank_city');
            $member_bank_branch = $this->input->post('bank_branch');
            $member_bank_account_name = $this->input->post('bank_account_name');
            $member_bank_account_no = $this->input->post('bank_account_no');

            // sys_member_devisor
            $member_devisor_name = $this->input->post('devisor_name');
            $member_devisor_relation = $this->input->post('devisor_relation');
            $member_devisor_phone = $this->input->post('devisor_phone');

            // sys_member_account
            $member_account_username = $this->input->post('account_username');

            $data_member = array();
            $data_member['member_name'] = $member_name;
            $data_member['member_nickname'] = $member_nickname;
            $data_member['member_city_id'] = $member_city_id;
            $data_member['member_country_id'] = $member_country_id;
            $data_member['member_phone'] = $member_phone;
            // $data_member['member_mobilephone'] = $member_mobilephone;
            if ($this->input->post('mobilephone') != false) {
                $data_member['member_mobilephone'] = $member_mobilephone;
            }

            $data_member_detail = array();
            $data_member_detail['member_detail_email'] = $member_detail_email;
            $data_member_detail['member_detail_sex'] = $member_detail_sex;
            $data_member_detail['member_detail_address'] = $member_detail_address;
            $data_member_detail['member_detail_zipcode'] = $member_detail_zipcode;
            $data_member_detail['member_detail_birth_place'] = $member_detail_birth_place;
            $data_member_detail['member_detail_birth_date'] = $member_detail_birth_date;
            $data_member_detail['member_detail_identity_type'] = $member_detail_identity_type;
            $data_member_detail['member_detail_identity_no'] = $member_detail_identity_no;

            $data_member_bank = array();
            $is_bank_update = false;
            // $data_member_bank['member_bank_bank_id'] = $member_bank_bank_id;
            // $data_member_bank['member_bank_city'] = $member_bank_city;
            // $data_member_bank['member_bank_branch'] = $member_bank_branch;
            // $data_member_bank['member_bank_account_name'] = $member_bank_account_name;
            // $data_member_bank['member_bank_account_no'] = $member_bank_account_no;

            if ($this->input->post('bank_bank_id') != false) {
                $is_bank_update = true;
                $data_member_bank['member_bank_bank_id'] = $member_bank_bank_id;
            }
            if ($this->input->post('bank_city') != false) {
                $is_bank_update = true;
                $data_member_bank['member_bank_city'] = $member_bank_city;
            }
            if ($this->input->post('bank_branch') != false) {
                $is_bank_update = true;
                $data_member_bank['member_bank_branch'] = $member_bank_branch;
            }
            if ($this->input->post('bank_account_name') != false) {
                $is_bank_update = true;
                $data_member_bank['member_bank_account_name'] = $member_bank_account_name;
            }
            if ($this->input->post('bank_account_no') != false) {
                $is_bank_update = true;
                $data_member_bank['member_bank_account_no'] = $member_bank_account_no;
            }


            $data_member_devisor = array();
            $data_member_devisor['member_devisor_name'] = $member_devisor_name;
            $data_member_devisor['member_devisor_relation'] = $member_devisor_relation;
            $data_member_devisor['member_devisor_phone'] = $member_devisor_phone;

            $data_member_account = array();
            $data_member_account['member_account_username'] = $member_account_username;

            $array_items = array();
            $array_items['member_name'] = $member_name;
            $array_items['member_nickname'] = $member_nickname;

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

                // delete old file
                if ($member_detail_old_image != '' && file_exists($this->file_dir . $member_detail_old_image)) {
                    @unlink($this->file_dir . $member_detail_old_image);
                }

                $data_member_detail['member_detail_image'] = $image_filename;
                $array_items['member_detail_image'] = $image_filename;
            }
            $this->function_lib->update_data('sys_member', 'member_network_id', $network_id, $data_member);
            $this->function_lib->update_data('sys_member_detail', 'member_detail_network_id', $network_id, $data_member_detail);

            if ($is_bank_update != FALSE) {

                $this->function_lib->update_data('sys_member_bank', 'member_bank_network_id', $network_id, $data_member_bank);
            }
            // $this->function_lib->update_data('sys_member_bank', 'member_bank_network_id', $network_id, $data_member_bank);

            $this->function_lib->update_data('sys_member_devisor', 'member_devisor_network_id', $network_id, $data_member_devisor);
            $this->function_lib->update_data('sys_member_account', 'member_account_network_id', $network_id, $data_member_account);
            $this->session->set_userdata($array_items);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function password() {
        $data['page_title'] = 'Ubah Password';
        $data['arr_breadcrumbs'] = array(
            'Ubah Password' => 'voffice/systems/password',
        );

        $data['query'] = $this->function_lib->get_detail_data('sys_network', 'network_id', $this->session->userdata('network_id'));
        $data['form_action'] = 'voffice/systems/act_password';

        template('member', 'voffice/systems_password_edit_view', $data);
    }

    function act_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_password', '<b>Password Lama</b>', 'required|callback_password_check[' . $this->session->userdata('network_id') . ']');
        $this->form_validation->set_rules('password', '<b>Password Baru</b>', 'required|matches[password_conf]');
        $this->form_validation->set_rules('password_conf', '<b>Ulangi Password Baru</b>', 'required');

        // VALIDASI PIN SERIAL
        $this->form_validation->set_rules('validate_pin', '<b>PIN Serial</b>', 'required|callback_validate_pin');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            redirect($this->input->post('uri_string'));
        } else {
            $network_id = $this->session->userdata('network_id');
            $member_account_password = $this->input->post('password');

            $data = array();
            $data['member_account_password'] = $this->encrypt->encode($member_account_password, $this->config->item('key_member'));
            $this->function_lib->update_data('sys_member_account', 'member_account_network_id', $network_id, $data);
            $this->session->set_userdata($data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    public function username_check($str, $id = null) {
        $check = $this->systems_model->check_username($str, $id);
        if ($check == true) {
            $this->form_validation->set_message('username_check', '%s telah digunakan.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function password_check($str, $id) {
        $ecrypted_password = $this->systems_model->get_member_password($id);
        $member_password = $this->encrypt->decode($ecrypted_password, $this->config->item('key_member'));
        if ($str === $member_password) {
            return TRUE;
        } else {
            $this->form_validation->set_message('password_check', '%s belum benar.');
            return FALSE;
        }
    }

    function network_group_show() {
        $data['arr_breadcrumbs'] = array(
            'Alih Pengguna' => '#',
            'Kelola Anggota Grup' => 'voffice/systems/network_group_show',
        );

        template('member', 'voffice/systems_network_group_show_view', $data);
    }

    function act_network_group_show() {

        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';
        $arr_output['success'] = '';

        // delete
        if ($this->input->post('delete') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_deleted = $item_undeleted = 0;
                foreach ($arr_item as $id) {
                    $parent_network_id = $this->session->userdata('parent_group_network_id');
                    $this->systems_model->delete_network_group($parent_network_id, $id);
                    $item_deleted++;
                }

                // network_group
                $sql_network_group = "
                    SELECT network_id, 
                    network_code 
                    FROM sys_network_group 
                    INNER JOIN sys_network ON network_id = network_group_member_network_id 
                    WHERE network_group_parent_network_id = '" . $parent_network_id . "' 
                    AND network_group_is_approve = '1'
                ";
                $query_network_group = $this->db->query($sql_network_group);
                $arr_member_group = array();
                if ($query_network_group->num_rows() > 0) {
                    array_push($arr_member_group, $this->session->userdata('network_code'));
                    foreach ($query_network_group->result() as $row_network_group) {
                        $arr_member_group[$row_network_group->network_id] = $row_network_group->network_code;
                    }
                    $parent_group_network_id = $this->session->userdata('network_id');
                } else {
                    $parent_group_network_id = 0;
                }

                $array_items = array(
                    'parent_group_network_id' => $parent_group_network_id,
                    'arr_member_group' => $arr_member_group,
                );

                $this->session->set_userdata($array_items);

                $arr_output['message'] = 'Proses berhasil dilakukan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
                $arr_output['success'] = '1';
                $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Proses berhasil dilakukan.</div>');
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
                $arr_output['success'] = '0';
            }
        }

        echo json_encode($arr_output);
    }

    function get_network_group_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "sys_network_group";
        $params['join'] = "INNER JOIN view_network_member ON network_id = network_group_member_network_id";
        $params['where_detail'] = "network_group_parent_network_id = '" . $this->session->userdata('network_id') . "'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            // is_active
            if ($row->network_group_is_approve == '1') {
                $stat = 'Telah Konfirmasi';
                $image_stat = 'tick.png';
            } else {
                $stat = 'Belum Konfirmasi';
                $image_stat = 'minus-small.png';
            }
            $is_approve = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            $entry = array('id' => $row->network_id,
                'cell' => array(
                    'network_code' => $row->network_code,
                    'member_name' => $row->member_name,
                    'member_nickname' => $row->member_nickname,
                    'network_group_is_approve' => $is_approve,
                    'network_group_input_datetime' => convert_datetime($row->network_group_input_datetime, 'id'),
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function network_group_add() {
        $data['arr_breadcrumbs'] = array(
            'Alih Pengguna' => '#',
            'Kelola Anggota Grup' => 'voffice/systems/network_group_show',
            'Tambah Anggota Grup' => 'voffice/systems/network_group_add',
        );

        $data['form_action'] = 'voffice/systems/act_network_group_add';

        template('member', 'voffice/systems_network_group_add_view', $data);
    }

    function act_network_group_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('code', '<b>Kode Member</b>', 'required|callback_member_check');
        $this->form_validation->set_rules('pin', '<b>PIN Member</b>', 'required|callback_pin_check[' . $this->input->post('code') . ']');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_code', $this->input->post('code'));
            redirect($this->input->post('uri_string'));
        } else {
            $parent_network_id = $this->session->userdata('network_id');
            $network_code = $this->input->post('code');
            $network_id = $this->mlm_function->get_network_id($network_code);
            $datetime = date("Y-m-d H:i:s");

            $data = array();
            $data['network_group_parent_network_id'] = $parent_network_id;
            $data['network_group_member_network_id'] = $network_id;
            $data['network_group_input_datetime'] = $datetime;
            $this->function_lib->insert_data('sys_network_group', $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Member berhasil didaftarkan di group anda.<br />Silakan login sebagai <b>' . $network_code . '</b> untuk konfirmasi pendaftaran Anggota Grup.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    public function member_check($network_code) {
        if ($network_code == $this->session->userdata('network_code')) {
            $this->form_validation->set_message('member_check', '%s harus selain Kode Member anda.');
            return FALSE;
        } else {
            $network_id = $this->mlm_function->get_network_id($network_code);
            if ($network_id != '') {
                $check_parent = $this->systems_model->check_group_parent($network_id);
                if ($check_parent == true) {
                    $check_member = $this->systems_model->check_group_member($network_id);
                    if ($check_member == true) {
                        return TRUE;
                    } else {
                        $this->form_validation->set_message('member_check', '%s telah terdaftar sebagai Anggota Grup.');
                        return FALSE;
                    }
                } else {
                    $this->form_validation->set_message('member_check', '%s telah terdaftar sebagai Kepala Grup.');
                    return FALSE;
                }
            } else {
                $this->form_validation->set_message('member_check', '%s tidak ditemukan.');
                return FALSE;
            }
        }
    }

    public function pin_check($pin, $network_code) {
        $network_id = $this->mlm_function->get_network_id($network_code);
        if ($network_id != '') {
            $check = $this->systems_model->check_pin($network_id, $pin);
            if ($check == true) {
                return TRUE;
            } else {
                $this->form_validation->set_message('pin_check', '%s belum benar.');
                return FALSE;
            }
        } else {
            $this->form_validation->set_message('pin_check', '%s belum benar.');
            return FALSE;
        }
    }

    function network_group_approve() {
        $data = array();
        $data['network_group_is_approve'] = 1;
        $this->function_lib->update_data('sys_network_group', 'network_group_member_network_id', $this->session->userdata('network_id'), $data);
        $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Akun anda berhasil terdaftar sebagai Anggota Grup.</div>');
        redirect('voffice/dashboard');
    }

    function network_group_deny() {
        $this->function_lib->delete_data('sys_network_group', 'network_group_member_network_id', $this->session->userdata('network_id'));
        $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Penolakan Anggota Grup berhasil diproses.</div>');
        redirect('voffice/dashboard');
    }

    function switch_user($network_code = '') {
        if ($network_code == '') {
            $network_code = $this->session->userdata('network_code');
        }

        $parent_group_network_id = $this->session->userdata('parent_group_network_id');
        $member_group_network_id = $this->mlm_function->get_network_id($network_code);
        if ($member_group_network_id != '') {

            $check_network_group = $this->systems_model->check_network_group($parent_group_network_id, $member_group_network_id);
            if ($member_group_network_id == $parent_group_network_id || $check_network_group) {
                $query = $this->systems_model->get_detail($member_group_network_id);
                if ($query->num_rows() > 0) {
                    $row = $query->row();
                    $datetime = date('Y-m-d H:i:s');

                    $array_items = array(
                        'network_id' => $row->network_id,
                        'network_code' => $row->network_code,
                        'member_name' => $row->member_name,
                        'member_nickname' => $row->member_nickname,
                        'member_last_login' => $row->member_last_login,
                        'member_detail_image' => $row->member_detail_image,
                        'member_logged_in' => TRUE,
                    );
                    $this->session->set_userdata($array_items);

                    $data = array();
                    $data['member_access_log_network_id'] = $row->network_id;
                    $data['member_access_log_session_id'] = $this->session->userdata('session_id');
                    $data['member_access_log_ip_address'] = $this->session->userdata('ip_address');
                    $data['member_access_log_login_datetime'] = $datetime;
                    $this->db->insert('sys_member_access_log', $data);

                    $data = array();
                    $data['member_last_login'] = $datetime;
                    $this->function_lib->update_data('sys_member', 'member_network_id', $row->network_id, $data);

                    $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Alih Pengguna berhasil dilakukan.</div>');
                } else {
                    $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Alih Pengguna gagal dilakukan.</div>');
                }
            } else {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Alih Pengguna gagal dilakukan. Member tidak terdaftar pada Anggota Grup anda.</div>');
            }
        } else {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Alih Pengguna gagal dilakukan.</div>');
        }

        redirect('voffice/dashboard');
    }

    public function validate_phone($num) {
        $is_error = false;
        // validasi karakter (hanya angka)
        if ( ! ctype_digit($num)) {
            $is_error = true;
            $msg = 'Nomor Handphone hanya boleh mengandung karakter angka.';
        }

        // blacklist phone_number
        $black_list = array('12345678', '01234567');
        $max_length = 8;
        for ($i=0; $i <= $max_length; $i++) { 
            $black_list[] = str_repeat($i, $max_length);
        }
        if ($is_error == false && in_array(substr($num, 0, $max_length), $black_list)) {
            $is_error = true;
            $msg = 'Nomor Handphone tidak valid.';
        }

        if (!$is_error) {
            return true;
        } else {
            $this->form_validation->set_message('validate_phone', $msg);
            return false;
        }
    }

    public function validate_name($name, $label='Nama') {
        $is_error = false;
        // validasi karakter (hanya angka dan spasi)
        if ( ! preg_match("/^[a-zA-Z ]+$/", $name)) {
            $is_error = true;
            $msg = $label . ' hanya boleh mengandung karakter huruf dan spasi.';
        }

        if (!$is_error) {
            return true;
        } else {
            $this->form_validation->set_message('validate_name', $msg);
            return false;
        }
    }

    public function validate_pin($pin) {
        $is_valid = $this->systems_model->check_pin($this->session->userdata('network_id'), $pin);
        if ($is_valid) {
            return true;
        } else {
            $this->form_validation->set_message('validate_pin', '<b>PIN Serial</b> salah.');
            return false;
        }
    }

}
