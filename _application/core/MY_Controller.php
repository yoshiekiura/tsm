<?php

/*
 * Core MY Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller {
    
    var $CI;
    
    function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        
        //$this->output->enable_profiler(true);
        $this->CI->site_configuration = $this->function_lib->get_site_configuration();
        $this->CI->sys_configuration = $this->function_lib->get_sys_configuration();
        $this->CI->arr_flashdata = $this->session->all_flashdata();
    }

}
