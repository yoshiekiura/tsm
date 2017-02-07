<?php
/*
 * Member Logout Controller
 */
// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('voffice/logout_model');
    }

    public function index() {
        $this->logout_model->process_logout();
        redirect('voffice/login');
    }

}
