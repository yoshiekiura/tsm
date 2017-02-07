<?php

/*
 * Backend Testimony Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_testimony_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_detail($id = 0) {
        $sql = "
            SELECT sys_testimony.*, 
            member_name 
            FROM sys_testimony 
            INNER JOIN sys_member ON member_network_id = testimony_network_id 
            WHERE testimony_id = '" . $id . "'
        ";
        return $this->db->query($sql);
    }

}

?>