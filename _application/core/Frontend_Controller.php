<?php

/*
 * Core Public Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller {
    
    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        
        //ini buat clear cache agar kalo setelah login tidak bisa di back lewat button back di browser
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        
        $this->CI->module_url = base_url() . 'frontend/' . $this->CI->router->fetch_module();
        
        //$this->output->enable_profiler(true);
        
        //verifikasi login member ada 2 file
        //dari widget (core/Frontend_Controller) & halaman login (voffice/login)
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        if($this->input->post('login_v_office'))
        {
            $this->load->model('voffice/login_model');
            $config = array(
               array(
                    'field'   => 'username',
                    'label'   => 'Username',
                    'rules'   => 'trim|htmlspecialchars|required'
                ),
                array(
                    'field'   => 'password',
                    'label'   => 'Password',
                    'rules'   => 'trim|htmlspecialchars|required'
                ),
                array(
                    'field'   => 'kode_unik',
                    'label'   => 'Kode Unik',
                    'rules'   => 'required|callback_check_captcha'
                )
            );
            
            $this->form_validation->set_rules($config);
            if($this->form_validation->run($this) == TRUE) {
                $input['username'] = $this->input->post('username');
                $input['password'] = $this->input->post('password');
                
                $verify = $this->login_model->process_login($input);
                if ($verify === 'success') {
                    $this->session->set_userdata($this->login_model->get_session($input));
                    redirect('voffice/dashboard');
                } elseif ($verify === 'inactive') {
                    $this->session->set_flashdata('login_widget_message', '<div class="error alert alert-block"><div class="alert-title"><b>LOGIN GAGAL</b></div><ul><li>Akun Anda tidak aktif.</li><li>Silakan hubungi Administrator untuk mengaktifkan akun anda.</li></ul></div>');
                    redirect($this->input->post('uri_string') . '#login_widget');
                } else {
                    $this->session->set_flashdata('login_widget_message', '<div class="error alert alert-error"><div class="alert-title"><b>LOGIN GAGAL</b></div><ul><li>Username atau Password yang anda masukkan salah.</li></ul></div>');
                    redirect($this->input->post('uri_string') . '#login_widget');
                }
            } else {
                $this->session->set_flashdata('login_widget_message', '<div class="error alert alert-error"><div class="alert-title"><b>LOGIN GAGAL</b></div><ul>' . validation_errors() . '</ul></div>');
                redirect($this->input->post('uri_string') . '#login_widget');
            }
        }
    }
    
    public function check_captcha($str) {
        $this->load->library('captcha');
        if($this->captcha->verify($str)) {
            return true;
        } else {
            $this->form_validation->set_message('check_captcha', '%s yang anda masukkan salah.');
            return false;
        }
    }

}

?>