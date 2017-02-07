<?php
/*
 * Auth Login Controller
 */
// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('auth/login_model');
        $this->load->library('encrypt');
        $this->config->load('key');
    }

    public function index() {
        $this->login();
    }
    
    public function login() {
        
        //ini buat clear cache agar kalo setelah login tidak bisa di back lewat button back di browser
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        
        //cek apakah masih ada session administrator
        if($this->session->userdata('administrator_logged_in')) {
            redirect('backend/dashboard');
        } else {
            $this->load->helper('form');
            if(isset($_GET['redirect_url']) && trim($_GET['redirect_url']) != '') {
                $data['redirect_url'] = $_GET['redirect_url'];
            } else {
                $data['redirect_url'] = '';
            }
            template('backend', 'login', $data);
        }
    }

    public function verify() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', '<b>Username</b>', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('password', '<b>Password</b>', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('kode_unik', '<b>Kode unik</b>', 'required|callback_check_captcha');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', validation_errors());
            $this->session->set_flashdata('username', $this->input->post('username'));
            $redirect_url = $this->input->post('redirect_url');
            if(trim($redirect_url) != '') {
                $redirect = _backend_login_uri . '?redirect_url=' . rawurlencode($redirect_url);
            } else {
                $redirect = _backend_login_uri;
            }
        } else {
            $username = addslashes($this->input->post('username'));
            $password = addslashes($this->input->post('password'));
            $redirect_url = $this->input->post('redirect_url');
            $query = $this->login_model->get_data_administrator_by_username($username);
            if($query->num_rows() > 0) {
                $row = $query->row();
                if (($row->administrator_username === $username) && ($this->encrypt->decode($row->administrator_password, $this->config->item('key_administrator')) === $password)) {
                    if ($row->administrator_group_is_active == '0') {
                        
                        //group_inactive
                        $this->session->set_flashdata('confirmation', '<p>Grup Akun Anda tidak aktif.</p><p>Silakan hubungi Administrator Pusat untuk mengaktifkan Grup Akun Anda.</p>');
                        $this->session->set_flashdata('username', $this->input->post('username'));
                        if(trim($redirect_url) != '') {
                            $redirect = _backend_login_uri . '?redirect_url=' . rawurlencode($redirect_url);
                        } else {
                            $redirect = _backend_login_uri;
                        }
                        
                    } elseif($row->administrator_is_active == '0') {
                        
                        //inactive
                        $this->session->set_flashdata('confirmation', '<p>Akun Anda tidak aktif.</p><p>Silakan hubungi Administrator Pusat untuk mengaktifkan Akun Anda.</p>');
                        $this->session->set_flashdata('username', $this->input->post('username'));
                        if(trim($redirect_url) != '') {
                            $redirect = _backend_login_uri . '?redirect_url=' . rawurlencode($redirect_url);
                        } else {
                            $redirect = _backend_login_uri;
                        }
                        
                    } else {
                        
                        //sukses
                        $query_last_login = $this->login_model->get_data_administrator_last_login();
                        $row_last_login = $query_last_login->row();
                        
                        $array_items = array(
                            'administrator_id' => $row->administrator_id,
                            'administrator_group_id' => $row->administrator_group_id,
                            'administrator_group_title' => $row->administrator_group_title,
                            'administrator_group_type' => $row->administrator_group_type,
                            'administrator_username' => $row->administrator_username,
                            'administrator_password' => $row->administrator_password,
                            'administrator_name' => $row->administrator_name,
                            'administrator_email' => $row->administrator_email,
                            'administrator_image' => $row->administrator_image,
                            'administrator_last_login' => $row->administrator_last_login,
                            'administrator_logged_in' => TRUE,
                            'administrator_last_last_login' => $row_last_login->administrator_last_login,
                            'administrator_last_username' => $row_last_login->administrator_username,
                            'administrator_last_name' => $row_last_login->administrator_name,
                            'filemanager' => TRUE
                        );
                        $this->session->set_userdata($array_items);

                        $data = array();
                        $data['administrator_last_login'] = date('Y-m-d H:i:s');
                        $this->function_lib->update_data('site_administrator', 'administrator_id', $row->administrator_id, $data);
                        
                        if(trim($redirect_url) != '') {
                            $redirect = rawurldecode($redirect_url);
                        } else {
                            $redirect = 'backend/dashboard';
                        }
                        
                    }
                } else {
                    
                    //password salah
                    $this->session->set_flashdata('confirmation', '<p><b>Username</b> atau <b>Password</b> yang Anda masukkan salah.</p>');
                    $this->session->set_flashdata('username', $this->input->post('username'));
                    if(trim($redirect_url) != '') {
                        $redirect = _backend_login_uri . '?redirect_url=' . rawurlencode($redirect_url);
                    } else {
                        $redirect = _backend_login_uri;
                    }
                    
                }
            } else {
                
                //data tidak ditemukan
                $this->session->set_flashdata('confirmation', '<p><b>Username</b> atau <b>Password</b> yang Anda masukkan salah.</p>');
                $this->session->set_flashdata('username', $this->input->post('username'));
                if(trim($redirect_url) != '') {
                    $redirect = _backend_login_uri . '?redirect_url=' . rawurlencode($redirect_url);
                } else {
                    $redirect = _backend_login_uri;
                }
                
            }
        }
        
        redirect($redirect);
    }
    
    function check_captcha($str){
        $this->load->library('captcha');
        if($this->captcha->verify($str)) {
            return true;
        } else {
            $this->form_validation->set_message('check_captcha', '%s yang anda masukkan salah.');
            return false;
        }
    }
    
    public function captcha() {
        $this->load->library('captcha');
        $config = array(
            'background_image' => _dir_captcha . 'captcha-login-1.png',
            'image_width' => 265,
            'image_height' => 54,
        );
        $this->captcha->generate_image($config);
    }

}
