<?php
/*
 * Member Login Controller
 * 
 * verifikasi login member ada 2 file
 * dari widget (core/Frontend_Controller) & halaman login (voffice/login)
 */
// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('voffice/login_model');
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
        
        $data['widget_title'] = 'Member Area';
        
        //cek apakah masih ada session member
        if($this->session->userdata('member_logged_in')) {
            redirect('voffice/dashboard');
        } else {
            $this->load->helper('form');
            if(isset($_GET['redirect_url']) && trim($_GET['redirect_url']) != '') {
                $data['redirect_url'] = $_GET['redirect_url'];
            } else {
                $data['redirect_url'] = '';
            }
            // template('member', 'login', $data);
            template('frontend', 'login', $data);
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
            redirect('voffice/login');
        } else {
            $username = addslashes($this->input->post('username'));
            $password = addslashes($this->input->post('password'));
            $redirect_url = $this->input->post('redirect_url');
            $datetime = date('Y-m-d H:i:s');
            $query = $this->login_model->get_data_member_by_username($username);
            if($query->num_rows() > 0) {
                $row = $query->row();
                if (($row->member_account_username === $username) && ($this->encrypt->decode($row->member_account_password, $this->config->item('key_member')) === $password)) {
                    if ($row->member_is_active == '0') {
                        
                        //inactive
                        $this->session->set_flashdata('confirmation', '<p>Akun Anda tidak aktif.</p><p>Silakan hubungi Customer Service kami.</p>');
                        $this->session->set_flashdata('username', $this->input->post('username'));
                        if(trim($redirect_url) != '') {
                            redirect('voffice/login?redirect_url=' . rawurlencode($redirect_url));
                        } else {
                            redirect('voffice/login');
                        }
                        
                    } else {
                        
                        //sukses
                        
                        //network_group
                        $query_network_group = $this->login_model->get_list_network_group($row->network_id);
                        $arr_member_group = array();
                        if($query_network_group->num_rows() > 0) {
                            array_push($arr_member_group, $row->network_code);
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
                        $this->db->where('member_network_id', $row->network_id);
                        $this->db->update('sys_member', $data);
                        
                        if(trim($redirect_url) != '') {
                            redirect(rawurldecode($redirect_url));
                        } else {
                            redirect('voffice/dashboard');
                        }
                        
                    }
                } else {
                    
                    //password salah
                    $this->session->set_flashdata('confirmation', '<p><b>Username</b> atau <b>Password</b> yang Anda masukkan salah.</p>');
                    $this->session->set_flashdata('username', $this->input->post('username'));
                    if(trim($redirect_url) != '') {
                        redirect('voffice/login?redirect_url=' . rawurlencode($redirect_url));
                    } else {
                        redirect('voffice/login');
                    }
                    
                }
            } else {
                
                //data tidak ditemukan
                $this->session->set_flashdata('confirmation', '<p><b>Username</b> atau <b>Password</b> yang Anda masukkan salah.</p>');
                $this->session->set_flashdata('username', $this->input->post('username'));
                if(trim($redirect_url) != '') {
                    redirect('voffice/login?redirect_url=' . rawurlencode($redirect_url));
                } else {
                    redirect('voffice/login');
                }
                
            }
        }
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
    
    public function captcha($block = 'login') {
        $this->load->library('captcha');
        
        switch ($block) {
            case 'login':
                $config = array(
                    'background_image' => _dir_captcha . 'captcha-login-1.png',
                    'image_width' => 265,
                    'image_height' => 54,
                );
                break;
            
            case 'widget':
                $config = array(
                    'background_image' => _dir_captcha . 'captcha-widget-' . rand(1, 4) . '.png',
                    'image_width' => 296,
                    'image_height' => 53,
                );
                break;
            
            default:
                $config = array();
                break;
        }
        $this->captcha->generate_image($config);
    }

}
