<?php

/*
 * Auth Logout Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Logout_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function process_logout() {
        $array_items = array(
            'administrator_id' => null,
            'administrator_group_id' => null,
            'administrator_group_title' => null,
            'administrator_group_type' => null,
            'administrator_username' => null,
            'administrator_password' => null,
            'administrator_name' => null,
            'administrator_email' => null,
            'administrator_image' => null,
            'administrator_last_login' => null,
            'administrator_last_username' => null,
            'administrator_last_last_login' => null,
            'administrator_logged_in' => false,
            'filemanager' => false,
        );
        $this->session->unset_userdata($array_items);
        if ($this->session->userdata('administrator_logged_in')) {
            $this->session->unset_userdata($this->session->all_userdata());
            $this->session->sess_destroy();
        }
        $_SESSION = array();
    }

}

?>