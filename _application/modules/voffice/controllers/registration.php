<?php

date_default_timezone_set("Asia/Jakarta");
/*
 * Member Registration Controller
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registration extends Member_Controller {

    function __construct() {
        parent::__construct();

        $this->plan_type = 'binary';
        $this->is_send_sms = FALSE;
        $this->load->helper('is_serialized');

        $this->load->library('mlm/binary/mlm_binary_lib', null, $this->plan_type);
        $this->load->library('mlm/binary/netgrow_node', null, 'netgrow_node');
        $this->load->library('mlm/binary/netgrow_sponsor', null, 'netgrow_sponsor');
        $this->load->library('mlm/binary/netgrow_match', null, 'netgrow_match');
        $this->load->library('mlm/binary/netgrow_level_match', null, 'netgrow_level_match');

        $this->load->library(array('encrypt', 'payment_lib'));
        $this->config->load('key');

        $this->payment_registration = TRUE;
    }

    public function index() {
        $this->new_reg();
    }

    public function new_reg($upline_network_code = '', $position_text = '') {
        $data['page_title'] = 'Registrasi Member (Pasang Baru)';
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'Geneologi' => 'voffice/network/geneology/' . base64_decode($upline_network_code),
            'Registrasi Member (Pasang Baru)' => '#'
            );

        $data['reg_nama'] = '';
        $data['reg_email'] = '';
        $data['reg_handphone'] = '';
        $data['reg_id_bank'] = '';
        $data['reg_cabang_bank'] = '';
        $data['reg_kota_bank'] = '';
        $data['reg_nasabah_bank'] = '';
        $data['reg_no_rekening_bank'] = '';

        $data['reg_sponsor'] = $this->session->userdata('network_code');
        $data['reg_upline'] = base64_decode($upline_network_code);
        $data['reg_posisi'] = base64_decode($position_text);
        $data['type_reg_text'] = 'Pasang Baru';

        $data['query_bank'] = $this->function_lib->get_list_bank();
        $data['form_action'] = 'voffice/registration/process';
        template('member', 'voffice/registration_view', $data);
    }

    public function clone_reg($upline_network_code = '', $position_text = '') {
        $data['page_title'] = 'Registrasi Member (Kloning)';
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'Geneologi' => 'voffice/network/geneology/' . base64_decode($upline_network_code),
            'Registrasi Member (Kloning)' => '#'
            );

        $arr_member_detail = $this->mlm_function->get_arr_member_detail($this->session->userdata('network_id'));
        if ($arr_member_detail) {
            $data['reg_nama'] = $arr_member_detail['member_name'];
            $data['reg_email'] = $arr_member_detail['member_email'];
            $data['reg_handphone'] = $arr_member_detail['member_mobilephone'];
            $data['reg_id_bank'] = $arr_member_detail['member_bank_id'];
            $data['reg_cabang_bank'] = $arr_member_detail['member_bank_branch'];
            $data['reg_kota_bank'] = $arr_member_detail['member_bank_city'];
            $data['reg_nasabah_bank'] = $arr_member_detail['member_bank_account_name'];
            $data['reg_no_rekening_bank'] = $arr_member_detail['member_bank_account_no'];
        } else {
            $data['reg_nama'] = '';
            $data['reg_email'] = '';
            $data['reg_handphone'] = '';
            $data['reg_id_bank'] = '';
            $data['reg_cabang_bank'] = '';
            $data['reg_kota_bank'] = '';
            $data['reg_nasabah_bank'] = '';
            $data['reg_no_rekening_bank'] = '';
        }

        $data['reg_sponsor'] = $this->session->userdata('network_code');
        $data['reg_upline'] = base64_decode($upline_network_code);
        $data['reg_posisi'] = base64_decode($position_text);
        $data['type_reg_text'] = 'Kloning';

        $data['query_bank'] = $this->function_lib->get_list_bank();
        $data['form_action'] = 'voffice/registration/process_clone';

        template('member', 'voffice/registration_clone_view', $data);
    }

    public function process_clone() {
        /* =========== OVERRIDE POST CLONE DATA =========== */
        $arr_member_detail = $this->mlm_function->get_arr_member_detail($this->session->userdata('network_id'));
        $_POST['reg_nama'] = $arr_member_detail['member_name'];
        $_POST['reg_email'] = $arr_member_detail['member_email'];
        $_POST['reg_handphone'] = $arr_member_detail['member_mobilephone'];
        $_POST['reg_id_bank'] = $arr_member_detail['member_bank_id'];
        $_POST['reg_cabang_bank'] = $arr_member_detail['member_bank_branch'];
        $_POST['reg_kota_bank'] = $arr_member_detail['member_bank_city'];
        $_POST['reg_nasabah_bank'] = $arr_member_detail['member_bank_account_name'];
        $_POST['reg_no_rekening_bank'] = $arr_member_detail['member_bank_account_no'];
        /* =========== OVERRIDE POST CLONE DATA =========== */
        $this->process();
    }

    public function process() {
        $datetime = date('Y-m-d h:i:s');

        if ($this->input->post('register')) {

            $arr_input_serial = $this->input->post('reg_serial');
            $arr_input_pin = $this->input->post('reg_pin');

            $this->session->set_userdata('reg', $_POST);

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $config = array(
                array(
                    'field' => 'reg_sponsor',
                    'label' => 'ID Sponsor',
                    'rules' => 'required|callback_check_sponsor'
                    ),
                array(
                    'field' => 'reg_upline',
                    'label' => 'ID Sponsor',
                    'rules' => 'required|callback_check_upline|callback_check_position'
                    ),
                array(
                    'field' => 'reg_nama',
                    'label' => 'Nama',
                    'rules' => 'required|min_length[3]|callback_validate_name'
                    ),
                array(
                    'field' => 'reg_email',
                    'label' => 'Email',
                    'rules' => 'valid_email'
                    ),
                array(
                    'field' => 'reg_password',
                    'label' => 'Password',
                    'rules' => 'required'
                    ),
                array(
                    'field' => 'reg_repassword',
                    'label' => 'Ulangi Password',
                    'rules' => 'required|matches[reg_password]'
                    ),
                array(
                    'field' => 'reg_handphone',
                    'label' => 'Nomor Handphone',
                    'rules' => 'numeric|required|min_length[5]|callback_validate_phone'
                    ),
                array(
                    'field' => 'reg_no_rekening_bank',
                    'label' => 'Nomor Rekening',
                    'rules' => 'required|min_length[8]|numeric|callback_validate_bank_account'
                    ),
                );

            if ($this->input->post('reg_paket')) {
                for ($join_paket = 1; $join_paket <= $this->input->post('reg_paket'); $join_paket++) {
                    $config = array_merge($config, array(array(
                        'field' => 'reg_serial[' . $join_paket . ']',
                        'label' => 'Kartu ke-' . $join_paket,
                        'rules' => 'required|callback_check_serial[' . $join_paket . ']'
                        ))
                    );
                }
            }

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run($this) == TRUE) {
                $arr_netgrow = $this->mlm_function->get_arr_active_netgrow();
                $date = date('Y-m-d');
                $datetime = date('Y-m-d H:i:s');
                $is_error = false;

                //$this->db->trans_begin();
                //data network
                $sponsor_network_id = $this->CI->mlm_function->get_network_id($_POST['reg_sponsor']);
                $arr_network = array();
                $arr_network['network_sponsor_network_code'] = addslashes(strtoupper($_POST['reg_sponsor']));
                $arr_network['network_upline_network_code'] = addslashes(strtoupper($_POST['reg_upline']));
                $arr_network['network_position_text'] = $_POST['reg_posisi'];
                $arr_network['network_position'] = ($arr_network['network_position_text'] == 'kiri') ? 'L' : 'R';
                $arr_network['network_sponsor_network_id'] = $sponsor_network_id;
                $arr_network['network_upline_network_id'] = $this->CI->mlm_function->get_network_id($arr_network['network_upline_network_code']);

                //data member
                $arr_member = array();
                $arr_member['member_name'] = addslashes($_POST['reg_nama']);
                $arr_member['member_country_id'] = '102';
                $arr_member['member_mobilephone'] = addslashes($_POST['reg_handphone']);
                $arr_member['member_join_datetime'] = $datetime;
                $arr_member['member_is_active'] = '1';

                //data member detail
                $arr_member_detail = array();
                $arr_member_detail['member_detail_email'] = $_POST['reg_email'];

                //data member account
                $arr_member_account = array();
                $arr_member_account['member_account_password'] = $this->encrypt->encode(addslashes($_POST['reg_password']), $this->config->item('key_member')); //default password adalah PIN
                //data bank
                $arr_member_bank = array();
                $arr_member_bank['member_bank_bank_id'] = $_POST['reg_id_bank'];
                $arr_member_bank['member_bank_account_name'] = $_POST['reg_nasabah_bank'];
                $arr_member_bank['member_bank_account_no'] = $_POST['reg_no_rekening_bank'];

                //data devisor (pewaris)
                $arr_member_devisor = array();


                $plan_type = $this->plan_type;
                $serial_type_node = $_POST['reg_paket'];
                $this->$plan_type->set_date($date);
                $this->$plan_type->set_datetime($datetime);
                $this->$plan_type->set_auto_network_code($this->sys_configuration['auto_network_code']);
                $this->$plan_type->set_serial_type_node($serial_type_node);
                // $this->$plan_type->set_data_serial($arr_serial);
                $this->$plan_type->set_data_member($arr_member);
                $this->$plan_type->set_data_member_detail($arr_member_detail);
                // $this->$plan_type->set_data_member_account($arr_member_account);
                $this->$plan_type->set_data_member_bank($arr_member_bank);
                $this->$plan_type->set_data_member_devisor($arr_member_devisor);

                $upline = 0;
                $_SESSION['network_code'] = array();

                /* INITIAL SPONSOR */
                $arr_network['network_initial_sponsor_network_id'] = $sponsor_network_id;
                /* END INITIAL SPONSOR */

                // cek no rek di sys_member_bank
                $cek_no_rek = $this->function_lib->get_one('sys_member_bank', 'member_bank_network_id', array('member_bank_account_no'=>$_POST['reg_no_rekening_bank']));
                if ( ! empty($cek_no_rek) OR $cek_no_rek != '') {
                    $parent_group_network_id = $this->function_lib->get_one('sys_network_group', 'network_group_parent_network_id', array('network_group_member_network_id'=>$cek_no_rek));
                    $parent_sponsor_network_id = $this->function_lib->get_one('sys_network', 'network_sponsor_network_id', array('network_id'=>$parent_group_network_id));

                    $arr_network['network_sponsor_network_id'] = $parent_sponsor_network_id;
                    $arr_network['network_sponsor_network_code'] = $this->function_lib->get_one('sys_network', 'network_code', array('network_id'=>$parent_sponsor_network_id));

                    $this->$plan_type->set_parent_network_group($parent_group_network_id);
                }

                for ($hu = 1; $hu <= $serial_type_node; $hu++) {
                    if ($hu > 1) {
                        if ($hu % 2 == 0) {
                            $arr_network['network_position_text'] = 'kiri';
                            $arr_network['network_position'] = 'L';
                            $upline++;
                        } else {
                            $arr_network['network_position_text'] = 'kanan';
                            $arr_network['network_position'] = 'R';
                        }
                        $arr_network['network_upline_network_code'] = $_SESSION['network_code'][$upline];
                        $arr_network['network_upline_network_id'] = $_SESSION['network_id'][$upline];
                    }

                    //data member account
                    $arr_member_account = array();
                    $arr_member_account['member_account_password'] = $this->encrypt->encode(addslashes($_POST['reg_password']), $this->config->item('key_member')); //default password adalah PIN
                    
                    $this->$plan_type->set_data_member_account($arr_member_account);
                    //data serial
                    $arr_serial = array();
                    $arr_serial['serial_id'] = addslashes($arr_input_serial[$hu]);
                    $arr_serial['serial_pin'] = addslashes($arr_input_pin[$hu]);

                    $this->$plan_type->set_data_serial($arr_serial);

                    $this->$plan_type->set_data_network($arr_network);
                    $this->$plan_type->insert_network($hu);
                    $reg_network_id = $this->$plan_type->get_network_id();


                    // ---------------------------------------------------------
                    // netgrow node

                    $this->netgrow_node->set_network_id($reg_network_id);
                    $this->netgrow_node->set_date($date);

                    //untuk set config masing-masing netgrow yang dependensi dengan titik
                    $arr_node_depend_class = array();

                    //generasi titik
                    if (in_array('gen_node', $arr_netgrow)) {
                        $arr_node_depend_class['netgrow_gen_node'] = $this->mlm_function->get_arr_netgrow_config('gen_node');
                    }

                    if (!empty($arr_node_depend_class)) {
                        $this->netgrow_node->add_node_depend($arr_node_depend_class);
                    }
                    $this->netgrow_node->execute();

                    // akhir netgrow node
                   
                    // netgrow sponsor

                    $this->netgrow_sponsor->set_network_id($reg_network_id);
                    $this->netgrow_sponsor->set_date($date);

                    //untuk set config masing-masing netgrow yang dependensi dengan sponsor
                    $arr_sponsor_depend_class = array();

                    //generasi sponsor
                    if (in_array('gen_sponsor', $arr_netgrow)) {
                        $arr_sponsor_depend_class['netgrow_gen_sponsor'] = $this->mlm_function->get_arr_netgrow_config('gen_sponsor');
                    }

                    if (!empty($arr_sponsor_depend_class)) {
                        $this->netgrow_sponsor->add_sponsor_depend($arr_sponsor_depend_class);
                    }
                    $this->netgrow_sponsor->execute();

                    // akhir netgrow sponsor
                    // ---------------------------------------------------------
                    // ---------------------------------------------------------
                    // netgrow match

                    $match_config = $this->mlm_function->get_arr_netgrow_config('match');
                    $this->netgrow_match->set_match_bool(true);
                    $this->netgrow_match->set_flushout($match_config['flushout']);
                    $this->netgrow_match->set_max_wait($match_config['max_wait']);
                    $this->netgrow_match->set_date($date);

                    //untuk set config masing-masing netgrow yang dependensi dengan pasangan
                    $arr_match_depend_class = array();

                    //generasi pasangan
                    if (in_array('gen_match', $arr_netgrow)) {
                        $arr_match_depend_class['netgrow_gen_match'] = $this->mlm_function->get_arr_netgrow_config('gen_match');
                    }

                    if (!empty($arr_match_depend_class)) {
                        $this->netgrow_match->add_match_depend($arr_match_depend_class);
                    }
                    $this->netgrow_match->execute();

                    // akhir netgrow match
                    // ---------------------------------------------------------
                    // ---------------------------------------------------------
                    // netgrow level match

                    $this->netgrow_level_match->set_date($date);

                    //untuk set config masing-masing netgrow yang dependensi dengan pasangan level
                    $arr_level_match_depend_class = array();

                    //generasi pasangan
                    if (in_array('gen_level_match', $arr_netgrow)) {
                        $arr_level_match_depend_class['netgrow_gen_level_match'] = $this->mlm_function->get_arr_netgrow_config('gen_level_match');
                    }

                    if (!empty($arr_level_match_depend_class)) {
                        $this->netgrow_level_match->add_level_match_depend($arr_level_match_depend_class);
                    }
                    $this->netgrow_level_match->execute();

                    // akhir netgrow level match
                    // ---------------------------------------------------------
                }


                //if ($this->db->trans_status() === FALSE || $is_error == true) {
                if ($is_error == true) {
                    //$this->db->trans_rollback();
                    $this->session->set_flashdata('message', '<div class="error alert alert-error"><div class="alert-title"><b>PROSES REGISTRASI GAGAL DILAKUKAN</b></div><ul><li>Terjadi kesalahan pada saat proses registrasi.</li><li>Silahkan registrasi ulang.</li></ul></div>');
                    redirect($this->input->post('uri_string'));
                } else {
                    //$this->db->trans_commit();
                    //$message = $this->$plan_type->get_message();
                    $arr_message = array();
                    $arr_message['message'] = $this->$plan_type->get_message();
                    $arr_message['message'] .= '<div class="success alert alert-success">';
                    $arr_message['message'] .= '<div class="alert-title"><b>PROSES REGISTRASI BERHASIL DILAKUKAN</b></div>';
                    $arr_message['message'] .= '<ul>';
                    $arr_message['message'] .= '<li>Registrasi member dengan nama <strong>' . $arr_member['member_name'] . '</strong> berhasil diproses.</li>';
                    // for ($hu = 1; $hu <= count($_SESSION['network_code']); $hu++) {
                    //     $arr_message['message'] .= '<li>URL web replikasi anda <strong>' . base_url() . $_SESSION['network_code'][$hu] . '</strong></li>';
                    // }

                    $arr_message['message'] .= '<li>ID Member anda adalah <strong>';
                    for ($hu = 1; $hu <= count($_SESSION['network_code']); $hu++) {
                        $arr_message['message'] .= $_SESSION['network_code'][$hu];
                        if ($hu != count($_SESSION['network_code'])) {
                            $arr_message['message'] .= ', ';
                        }
                    }
                    // $arr_message['message'] .= $payment_message;
                    $arr_message['message'] .= '</strong>. Silakan catat ID Member anda.</li>';
                    $arr_message['message'] .= '</ul>';
                    $arr_message['message'] .= '</div>';
                    $_SESSION['input_message'] = serialize($arr_message);

                    //$this->session->set_flashdata('confirmation', $message);
                    // die($_SESSION['input_message']);
                    // send sms
                    if ($this->is_send_sms) {

                        $member_name = explode(' ', $_POST['reg_nama']);
                        $sms_message = "Selamat bergabung " . $member_name[0] . ", akun & password anda : ";
                        for ($hu = 1; $hu <= count($_SESSION['network_code']); $hu++) {
                            $sms_message .= $_SESSION['network_code'][$hu] . " => " . $_POST['reg_pin'][$hu] . " ";
                            if ($hu != count($_SESSION['network_code'])) {
                                $sms_message .= '; ';
                            }
                        }
                        $this->function_lib->send_sms($arr_member['member_mobilephone'], $sms_message);
                    }
                    $_SESSION['network_code'] = array();
                    redirect('voffice/network/geneology/' . addslashes(strtoupper($_POST['reg_upline'])));
                }
            } else {
                $arr_message = array();
                $arr_message['message'] = '<div class="error alert alert-danger"><div class="alert-title"><b>PROSES REGISTRASI GAGAL DILAKUKAN</b></div><ul>' . validation_errors() . '</ul></div>';
                $_SESSION['input_message'] = serialize($arr_message);

                $this->session->set_flashdata('input_reg_sponsor', $this->input->post('reg_sponsor'));
                $this->session->set_flashdata('input_reg_upline', $this->input->post('reg_upline'));
                $this->session->set_flashdata('input_reg_paket', $this->input->post('reg_paket'));
                $this->session->set_flashdata('input_reg_posisi', $this->input->post('reg_posisi'));
                $this->session->set_flashdata('input_reg_serial', $this->input->post('reg_serial'));
                $this->session->set_flashdata('input_reg_nama', $this->input->post('reg_nama'));
                $this->session->set_flashdata('input_reg_handphone', $this->input->post('reg_handphone'));
                $this->session->set_flashdata('input_reg_id_bank', $this->input->post('reg_id_bank'));
                $this->session->set_flashdata('input_reg_nasabah_bank', $this->input->post('reg_nasabah_bank'));
                $this->session->set_flashdata('input_reg_no_rekening_bank', $this->input->post('reg_no_rekening_bank'));

                if ($this->input->post('reg_paket')) {
                    for ($join_paket = 1; $join_paket <= $this->input->post('reg_paket'); $join_paket++) {
                        $this->session->set_flashdata('input_reg_serial[$join_paket]',$_POST['reg_serial'][$join_paket]);
                        $this->session->set_flashdata('input_reg_pin[$join_paket]',$_POST['reg_pin'][$join_paket]);
                    }
                }


                redirect($this->input->post('uri_string'));
            }
        }
    }

    //cek serial
    public function check_serial($serial_id, $joinpaket) {
        $is_error = false;

        $row_serial = $this->function_lib->get_detail_data('sys_serial', 'serial_id', $serial_id)->row_array();
        if (empty($row_serial)) {
            $message = 'Serial ke-' . $joinpaket . ' yang Anda masukkan salah';
            $is_error = true;
        } else {
            if ($_POST['reg_pin'][$joinpaket] !== $row_serial['serial_pin']) {
                $is_error = true;
                $message = 'Serial/PIN ke-' . $joinpaket . ' yang Anda masukkan salah';
            } elseif ($row_serial['serial_is_active'] == '0') {
                $is_error = true;
                $message = 'Status kartu ke-' . $joinpaket . ' tidak aktif';
            } elseif ($row_serial['serial_is_used'] == '1') {
                $is_error = true;
                $message = 'Kartu ke-' . $joinpaket . ' telah digunakan';
            }
        }

        if ($joinpaket > 1) {
            for ($c = 1; $c < $joinpaket; $c++) {
                if (trim($serial_id) == trim($_POST['reg_serial'][$c])) {
                    $is_error = true;
                    $message = 'Serial ke-' . $joinpaket . ' yang Anda masukkan tidak boleh sama.';
                }
            }
        }

        if (!$is_error) {
            return true;
        } else {
            $this->form_validation->set_message('check_serial', $message);
            return false;
        }
    }

    public function check_position() {
        $is_error = false;

        if ($this->input->post('reg_sponsor') && $this->input->post('reg_upline')) {
            $sponsor_code = strtoupper(trim($this->input->post('reg_sponsor')));
            $upline_code = strtoupper(trim($this->input->post('reg_upline')));
            $position = $this->input->post('reg_posisi');

            //cek upline harus sejalur dengan sponsor
            $check_uplink = $this->mlm_function->check_uplink($upline_code, $sponsor_code);
            if ($check_uplink) {
                $upline_id = $this->mlm_function->get_network_id($upline_code);
                $row_network = $this->function_lib->get_detail_data('sys_network', 'network_id', $upline_id)->row_array();
                if (!empty($row_network)) {
                    if ($position == 'kiri' && $row_network['network_left_node_network_id'] != 0) {
                        $is_error = true;
                        $message = 'Posisi kiri dari ' . $upline_code . ' sudah ditempati, silakan cari posisi yang lain.';
                    } elseif ($position == 'kanan' && $row_network['network_right_node_network_id'] != 0) {
                        $is_error = true;
                        $message = 'Posisi kanan dari ' . $upline_code . ' sudah ditempati, silakan cari posisi yang lain.';
                    }
                } else {
                    $is_error = true;
                    $message = 'Upline dengan ID ' . $upline_code . ' tidak ditemukan, silakan cek upline anda.';
                }
            } else {
                $is_error = true;
                $message = 'Upline tidak berada pada jaringan sponsor, ilahkan cari posisi yang lain.';
            }
        } else {
            $is_error = true;
            $message = 'Sponsor dan Upline harus diisi.';
        }

        if (!$is_error) {
            return true;
        } else {
            $this->form_validation->set_message('check_position', $message);
            return false;
        }
    }

    public function get_member_name() {
        $member_name = '';
        if ($this->input->post('code')) {
            $member_name = $this->mlm_function->get_member_name_by_network_code($this->input->post('code'));
        }
        echo json_encode($member_name);
    }

    public function validate_bank_account($rek) {
        $is_error = false;
        // validasi karakter (hanya angka)
        if ( ! ctype_digit($rek)) {
            $is_error = true;
            $msg = 'Nomor Rekening hanya boleh mengandung karakter angka.';
        }

        // ambil no rekening root
        $root_rek = $this->function_lib->get_one('sys_member_bank', 'member_bank_account_no', array('member_bank_network_id'=>1));
        if ($is_error == false && $rek == $root_rek) {
            $is_error = true;
            $msg = 'Nomor Rekening tidak bisa digunakan.';
        }

        // blacklist no rek
        $black_list = array('12345678', '01234567');
        $max_length = 8;
        for ($i=0; $i <= $max_length; $i++) { 
            $black_list[] = str_repeat($i, $max_length);
        }
        if ($is_error == false && in_array(substr($rek, 0, $max_length), $black_list)) {
            $is_error = true;
            $msg = 'Nomor Rekening tidak valid.';
        }

        if (!$is_error) {
            return true;
        } else {
            $this->form_validation->set_message('validate_bank_account', $msg);
            return false;
        }
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

    public function validate_name($name) {
        $is_error = false;
        // validasi karakter (hanya angka dan spasi)
        if ( ! preg_match("/^[a-zA-Z ]+$/", $name)) {
            $is_error = true;
            $msg = 'Nama hanya boleh mengandung karakter huruf dan spasi.';
        }

        if (!$is_error) {
            return true;
        } else {
            $this->form_validation->set_message('validate_name', $msg);
            return false;
        }
    }

    public function check_rekening() {
        header("Content-type: application/json");
        $result = array();
        $rek = $this->input->post('no_rek');
        $is_error = false;

        // validasi panjang karakter 
        if (strlen($rek) < 8) {
            $is_error = true;
            $result['message'] = 'Nomor Rekening harus memiliki panjang minimal 8 karakter.';
        }

        // validasi karakter (hanya angka)
        if ( ! ctype_digit($rek) && $is_error == false) {
            $is_error = true;
            $result['message'] = 'Nomor Rekening hanya boleh mengandung karakter angka.';
        }

        // ambil no rekening root
        $root_rek = $this->function_lib->get_one('sys_member_bank', 'member_bank_account_no', array('member_bank_network_id'=>1));
        if ($is_error == false && $rek == $root_rek) {
            $is_error = true;
            $result['message'] = 'Nomor Rekening tidak bisa digunakan.';
        }

        // blacklist no rek
        $black_list = array('12345678', '01234567');
        $max_length = 8;
        for ($i=0; $i <= $max_length; $i++) { 
            $black_list[] = str_repeat($i, $max_length);
        }
        if ($is_error == false && in_array(substr($rek, 0, $max_length), $black_list)) {
            $is_error = true;
            $result['message'] = 'Nomor Rekening tidak valid.';
        }

        if (!$is_error) {

            // get member bank cek no rek di sys_member_bank
            $cek_no_rek = $this->function_lib->get_one('sys_member_bank', 'member_bank_network_id', array('member_bank_account_no'=>$rek));
            if ( ! empty($cek_no_rek) OR $cek_no_rek != '') {
                $parent_group_network_id = $this->function_lib->get_one('sys_network_group', 'network_group_parent_network_id', array('network_group_member_network_id'=>$cek_no_rek));
                $parent_sponsor_network_id = $this->function_lib->get_one('sys_network', 'network_sponsor_network_id', array('network_id'=>$parent_group_network_id));

                $result['sponsor_network_id'] = $parent_sponsor_network_id;
                $result['sponsor_network_code'] = $this->function_lib->get_one('sys_network', 'network_code', array('network_id'=>$parent_sponsor_network_id));
                $result['sponsor_name'] = $this->mlm_function->get_member_name($parent_sponsor_network_id);
                $result['message'] = 'Perubahan Data Sponsor.';
                $result['change'] = 'yes';
            } else {
                $result['message'] = 'Nomor Rekening valid.';
                $result['change'] = 'no';
            }
            $result['status'] = 'success';
        } else {
            $result['status'] = 'failed';
        }

        echo json_encode($result);
    }

}

