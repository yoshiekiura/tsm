<?php

/*
 * Frontend Registration Controller
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();

        $this->plan_type = 'binary';

        $this->load->model('frontend_registration_model');
        $this->load->library('mlm/binary/mlm_binary_lib', null, $this->plan_type);
        $this->load->library('mlm/binary/netgrow_node', null, 'netgrow_node');
        $this->load->library('mlm/binary/netgrow_sponsor', null, 'netgrow_sponsor');
        $this->load->library('mlm/binary/netgrow_match', null, 'netgrow_match');
        $this->load->library('mlm/binary/netgrow_level_match', null, 'netgrow_level_match');

        $this->load->library(array('encrypt', 'payment_lib'));
        $this->config->load('key');
        $this->load->helper('is_serialized');

        $this->payment_registration = false;
        $this->is_send_sms = false;
    }

    public function index() {
       // $data['arr_breadcrumbs'] = array(
       //      'Data' => '#',
       //      'Registrasi' => 'registrasi',
           
       //  );
       //  $data['query_bank'] = $this->function_lib->get_list_bank();
       //  $data['form_action'] = 'registration/process';
       //  $data['title'] = 'Registrasi Member';
       //  template('frontend', 'registration/frontend_registration_view', $data);
    }

    public function process() {
        die();
        $datetime = date('Y-m-d h:i:s');

        if ($this->input->post('register')) {
            $_SESSION['registration_message'] = '';

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
                    'rules' => 'required|min_length[3]'
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
                    'label' => 'Konfirmasi Password',
                    'rules' => 'required|matches[reg_password]'
                ),
                array(
                    'field' => 'reg_handphone',
                    'label' => 'Nomor Handphone',
                    'rules' => 'numeric|required|min_length[5]'
                ),
            );

            if ($this->input->post('reg_paket')) {
                for ($join_paket = 1; $join_paket <= $this->input->post('reg_paket'); $join_paket++) {
                    $config = array_merge($config, array(array(
                            'field' => 'reg_serial[' . $join_paket . ']',
                            'label' => 'Kartu ke-' . $join_paket,
                            'rules' => 'required|callback_check_serial[' . $join_paket . ']'
                        )
                            )
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
                $arr_network = array();
                $arr_network['network_sponsor_network_code'] = addslashes(strtoupper($_POST['reg_sponsor']));
                $arr_network['network_upline_network_code'] = addslashes(strtoupper($_POST['reg_upline']));
                $arr_network['network_position_text'] = $_POST['reg_posisi'];
                $arr_network['network_position'] = ($arr_network['network_position_text'] == 'kiri') ? 'L' : 'R';
                $arr_network['network_sponsor_network_id'] = $this->CI->mlm_function->get_network_id($arr_network['network_sponsor_network_code']);
                $arr_network['network_upline_network_id'] = $this->CI->mlm_function->get_network_id($arr_network['network_upline_network_code']);


                //data member
                $arr_member = array();
                $arr_member['member_name'] = addslashes($_POST['reg_nama']);
                $arr_member['member_nickname'] = addslashes($_POST['reg_nama']);
                $arr_member['member_country_id'] = '102';
                $arr_member['member_mobilephone'] = addslashes($_POST['reg_handphone']);
                $arr_member['member_join_datetime'] = $datetime;
                $arr_member['member_is_active'] = '1';

                //data member detail
                $arr_member_detail = array();

//                //data member account
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
//                $this->$plan_type->set_data_serial($arr_serial);
                $this->$plan_type->set_data_member($arr_member);
                $this->$plan_type->set_data_member_detail($arr_member_detail);
//                $this->$plan_type->set_data_member_account($arr_member_account);
                $this->$plan_type->set_data_member_bank($arr_member_bank);
                $this->$plan_type->set_data_member_devisor($arr_member_devisor);

                $upline = 0;
                $_SESSION['network_code'] = array();
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
                        $arr_network['network_sponsor_network_code'] = $_SESSION['network_code'][$upline];
                        $arr_network['network_sponsor_network_id'] = $_SESSION['network_id'][$upline];
                        $arr_network['network_upline_network_code'] = $_SESSION['network_code'][$upline];
                        $arr_network['network_upline_network_id'] = $_SESSION['network_id'][$upline];
                    }

                    //data member account
                    $arr_member_account = array();
                    $arr_member_account['member_account_password'] = $this->encrypt->encode(addslashes($arr_input_pin[$hu]), $this->config->item('key_member')); //default password adalah PIN
                    //
                    $this->$plan_type->set_data_member_account($arr_member_account);
                    //data serial
                    $arr_serial = array();
                    $arr_serial['serial_id'] = addslashes($arr_input_serial[$hu]);
                    $arr_serial['serial_pin'] = addslashes($arr_input_pin[$hu]);
                    $arr_serial['registered_network_id'] = $this->session->userdata('network_id');

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
                    // ---------------------------------------------------------
                    // ---------------------------------------------------------
                    // netgrow qualified
                    // $this->netgrow_qualified->set_network_id($reg_network_id);
                    // $this->netgrow_qualified->set_date($date);
                    // $this->netgrow_qualified->execute();
                    // akhir netgrow qualified
                    // ---------------------------------------------------------
                    // ---------------------------------------------------------
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
                    //Registrasi ke payment


                    if ($this->payment_registration) {
                        if ($hu > 1) {
                            $params['member_phone_number'] = addslashes($_POST['reg_handphone']) . '-' . $hu;
                        } else {
                            $params['member_phone_number'] = addslashes($_POST['reg_handphone']);
                        }
                        $params['member_code'] = addslashes($_SESSION['network_code'][$hu]);
                        $params['member_name'] = addslashes($_POST['reg_nama']);
                        $params['member_email'] = addslashes($_POST['reg_email']);
                        $params['username'] = addslashes($_SESSION['network_code'][$hu]);
                        $params['password'] = addslashes($_POST['reg_password']);
                        $this->payment_lib->payment_registration($params);
                    }
                }

                //$check_network_id = $this->CI->function_lib->get_one('sys_log_income', 'income_log_network_id', 'income_log_network_id = "' . $_SESSION['network_id'][1] . '"');
                $join_paket_value = $this->CI->function_lib->get_one('sys_join_paket', 'paket_value', 'paket_type_id = "' . $serial_type_node . '"');


                $sql_insert_log = "
               INSERT INTO sys_log_income 
               SET income_log_network_id = '" . $_SESSION['network_id'][1] . "', 
               income_log_join_paket = '" . $serial_type_node . "', 
               income_log_value_paket = '" . $join_paket_value . "',
               income_log_datetime = '" . $datetime . "'";
                $this->CI->db->query($sql_insert_log);


                //if ($this->db->trans_status() === FALSE || $is_error == true) {
                if ($is_error == true) {
                    //$this->db->trans_rollback();
                    $message ='<div class="error alert alert-error"><div class="alert-title"><b>PROSES REGISTRASI GAGAL DILAKUKAN</b></div><ul><li>Terjadi kesalahan pada saat proses registrasi.</li><li>Silahkan registrasi ulang.</li></ul></div>';
                    $_SESSION['registration_message'] = serialize($message);
                    //$this->session->set_flashdata('message', '<div class="error alert alert-error"><div class="alert-title"><b>PROSES REGISTRASI GAGAL DILAKUKAN</b></div><ul><li>Terjadi kesalahan pada saat proses registrasi.</li><li>Silahkan registrasi ulang.</li></ul></div>');
                    redirect($this->input->post('uri_string'));
                } else {
                    //$this->db->trans_commit();
                    $message = $this->$plan_type->get_message();

                    $message .= '<div class="success alert alert-success">';
                    $message .= '<div class="alert-title"><b>PROSES REGISTRASI BERHASIL DILAKUKAN</b></div>';
                    $message .= '<ul>';
                    $message .= '<li>Registrasi member dengan nama <strong>' . $arr_member['member_name'] . '</strong> berhasil diproses.</li>';

                    $message .= '<li>ID Member anda adalah <strong>';
                    for ($hu = 1; $hu <= count($_SESSION['network_code']); $hu++) {
                        $message .= $_SESSION['network_code'][$hu];
                        if ($hu != count($_SESSION['network_code'])) {
                            $message .= ', ';
                        }
                    }
                    $message .= '</strong>. Silakan catat ID Member anda.</li>';
                    $message .= '</ul>';
                    $message .= '</div>';

                    // $this->session->set_flashdata('confirmation',$message);
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
                    $_SESSION['registration_message'] = serialize($message);

                    redirect($this->input->post('uri_string'));
                }
            } else {

                $message = '<div class="error alert alert-danger"><div class="alert-title"><b>PROSES REGISTRASI GAGAL DILAKUKAN</b></div><ul>' . validation_errors() . '</ul></div>';
                $_SESSION['registration_message'] = serialize($message);
//                $this->session->set_userdata('registration_message', serialize($message));
                // for ($i = 1; $i <= $this->input->post('reg_paket'); $i++) {
                //     $this->session->set_flashdata('input_reg_serial[' . $i . ']', $arr_serial[$i]);
                //     $this->session->set_flashdata('input_reg_pin[' . $i . ']', $arr_pin[$i]);
                // }

                $this->session->set_flashdata('input_reg_sponsor', $this->input->post('reg_sponsor'));
                $this->session->set_flashdata('input_reg_upline', $this->input->post('reg_upline'));
                $this->session->set_flashdata('input_reg_paket', $this->input->post('reg_paket'));
                $this->session->set_flashdata('input_reg_posisi', $this->input->post('reg_posisi'));
                $this->session->set_flashdata('input_reg_serial', $this->input->post('reg_serial'));
                $this->session->set_flashdata('input_reg_nama', $this->input->post('reg_nama'));
                $this->session->set_flashdata('input_reg_password', $this->input->post('reg_password'));
                $this->session->set_flashdata('input_reg_repassword', $this->input->post('reg_repassword'));
                $this->session->set_flashdata('input_reg_handphone', $this->input->post('reg_handphone'));
                $this->session->set_flashdata('input_reg_id_bank', $this->input->post('reg_id_bank'));
                $this->session->set_flashdata('input_reg_nasabah_bank', $this->input->post('reg_nasabah_bank'));
                $this->session->set_flashdata('input_reg_bank_city', $this->input->post('reg_kota_bank'));
                $this->session->set_flashdata('input_reg_cabang_bank', $this->input->post('reg_cabang_bank'));
                $this->session->set_flashdata('input_reg_no_rekening_bank', $this->input->post('reg_no_rekening_bank'));
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
                $message = 'Serial/PIN ke' . $joinpaket . ' yang Anda masukkan salah';
            } elseif ($row_serial['serial_is_active'] == '0') {
                $is_error = true;
                $message = 'Status kartu ke-' . $joinpaket . ' tidak aktif';
            } elseif ($row_serial['serial_is_used'] == '1') {
                $is_error = true;
                $message = 'Kartu ke' . $joinpaket . ' telah digunakan';
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

}

?>
