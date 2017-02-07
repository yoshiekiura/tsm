<?php

/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of frontend_serial_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_serial_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_serial_by_id($serial_id) {
        $this->db->join('sys_serial_buyer', 'serial_buyer_serial_id=serial_id', 'left');
        $this->db->join('sys_serial_user', 'serial_user_serial_id=serial_id', 'left');
        $this->db->where('serial_id', $serial_id);
        return $this->db->get('sys_serial');
    }
}

?>
