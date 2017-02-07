<?php

/*
 * Core Backend Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_Controller extends MY_Controller {
    
    var $CI;

    function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        
        //ini buat clear cache agar kalo setelah logout tidak bisa di back lewat button back di browser
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        
        $this->CI->module_url = base_url() . 'backend/' . $this->CI->router->fetch_module();
        $this->CI->service_module_url = base_url() . 'backend_service/' . $this->CI->router->fetch_module();
        
        //$this->output->enable_profiler(true);
        $this->load->library('authentication');
        
        if(!$this->authentication->auth_user()) {
            //show_error('Shove off, this is for admins.');
            $referer = rawurlencode('http://' . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', $_SERVER['REQUEST_URI']) . '/');
            $origin = isset($_SERVER['HTTP_REFERER']) ? rawurlencode($_SERVER['HTTP_REFERER']) : $referer;
            $redirect = _backend_login_uri . '?redirect_url=' . $origin;
            redirect($redirect);
            
        } elseif(!$this->authentication->privilege_user()) {
            //show_error('Shove off, this is for admins.');
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Anda tidak diotorisasi untuk halaman tersebut.</div>');
            redirect('backend/dashboard/show');
            
        } else {
            return TRUE;
        }
    }

}

?>
