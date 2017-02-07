<?php

/*
 * Core Member Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_Controller extends MY_Controller {
    
    var $CI;
    
    function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        
        //ini buat clear cache agar kalo setelah logout tidak bisa di back lewat button back di browser
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        
        $this->CI->module_url = base_url() . $this->CI->router->fetch_module() . '/' . $this->CI->router->fetch_class();
        
        //$this->output->enable_profiler(true);
        $this->load->library('authentication');
        
        if(!$this->authentication->auth_member()) {
            //show_error('Shove off, this is for member.');
            $referer = rawurlencode('http://' . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', $_SERVER['REQUEST_URI']) . '/');
            $origin = isset($_SERVER['HTTP_REFERER']) ? rawurlencode($_SERVER['HTTP_REFERER']) : $referer;
            redirect('voffice/login?redirect_url=' . $origin);
            
        } else {
            return TRUE;
        }
    }

}

?>
