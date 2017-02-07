<?php

/*
 * Backend City Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_city_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function check_delete($id) {
        $sql = "
            SELECT SUM(item) AS item 
            FROM 
            (
                SELECT COUNT(*) AS item FROM sys_member WHERE member_city_id = '" . $id . "'
            ) result
        ";
        $query = $this->db->query($sql);
        $row = $query->row();
        $item = $row->item;
        
        if($item > 0) {
            return false;
        } else {
            return true;
        }
    }

}

?>