<?php

/*
 * Member Testimony Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Testimony_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_detail($id = 0, $network_id = 0) {
        $sql = "
            SELECT * 
            FROM sys_testimony 
            WHERE testimony_id = '" . $id . "' 
            AND testimony_network_id = '" . $network_id . "'
        ";
        return $this->db->query($sql);
    }
    
    function update($id, $network_id, $data) {
        $this->db->where('testimony_id', $id);
        $this->db->where('testimony_network_id', $network_id);
        $this->db->update('sys_testimony', $data);
    }

}

?>