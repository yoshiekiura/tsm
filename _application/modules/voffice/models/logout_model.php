<?php

/*
 * Member Logout Model
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
        $datetime = date("Y-m-d H:i:s");

        $data = array();
        $data['member_access_log_logout_datetime'] = $datetime;
        $this->db->where('member_access_log_network_id', $this->session->userdata('network_id'));
        $this->db->where('member_access_log_session_id', $this->session->userdata('session_id'));
        $this->db->update('sys_member_access_log', $data);
        
        $array_items = array(
            'network_id' => null,
            'network_code' => null,
            'member_name' => null,
            'member_nickname' => null,
            'member_last_login' => null,
            'member_detail_image' => null,
            'member_logged_in' => false,
        );
        $this->session->unset_userdata($array_items);
        if ($this->session->userdata('member_logged_in')) {
            $this->session->unset_userdata($this->session->all_userdata());
            $this->session->sess_destroy();
        }
        $_SESSION = array();
    }

}

?>