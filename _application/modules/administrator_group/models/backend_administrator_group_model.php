<?php

/*
 * Backend Administrator Group Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_administrator_group_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_list($type = 'superuser') {
        $where = "WHERE 1";
        if($type != 'superuser') {
            $where .= " AND administrator_group_type != 'superuser'";
        }
        $sql = "
            SELECT * 
            FROM site_administrator_group 
            " . $where . " AND administrator_group_is_active = '1' 
            ORDER BY administrator_group_title ASC
        ";
        return $this->db->query($sql);
    }
    
    function get_detail($id, $type = 'administrator') {
        $where = "";
        if($type != 'superuser') {
            $where = "AND administrator_group_type != 'superuser'";
        }
        $sql = "SELECT * FROM site_administrator_group WHERE administrator_group_id = '" . $id . "' " . $where;
        return $this->db->query($sql);
    }
    
    function get_list_privilege($id) {
        $sql = "
            SELECT administrator_menu_id, 
            administrator_privilege_action 
            FROM site_administrator_privilege 
            INNER JOIN site_administrator_menu ON administrator_menu_id = administrator_privilege_administrator_menu_id 
            WHERE administrator_privilege_administrator_group_id = '" . $id . "'
        ";
        return $this->db->query($sql);
    }
    
    function check_delete($id) {
        $sql = "
            SELECT SUM(item) AS item 
            FROM 
            (
                SELECT COUNT(*) AS item FROM site_administrator WHERE administrator_administrator_group_id = '" . $id . "'
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