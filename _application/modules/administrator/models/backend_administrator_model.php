<?php

/*
 * Backend Administrator Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_administrator_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_detail($id, $type = 'superuser') {
        $where = "WHERE 1";
        if($type != 'superuser') {
            $where = " AND administrator_group_type != 'superuser'";
        }
        $sql = "
            SELECT * 
            FROM site_administrator 
            INNER JOIN site_administrator_group ON administrator_group_id = administrator_administrator_group_id 
            " . $where . " AND administrator_id = " . $id . "
        ";
        return $this->db->query($sql);
    }

    function check_username($username, $id = 0) {
        $sql = "SELECT 1 FROM site_administrator WHERE administrator_username = '" . $username . "' AND administrator_id != " . $id . "";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function get_administrator_password($id) {
        $sql = "SELECT administrator_password FROM site_administrator WHERE administrator_id = " . $id . "";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->administrator_password;
        } else {
            return '';
        }
    }
    
    function check_delete($id) {
        $sql = "
            SELECT SUM(item) AS item 
            FROM 
            (
                SELECT COUNT(*) AS item FROM site_news WHERE news_input_administrator_id = " . $id . "
                UNION
                SELECT COUNT(*) AS item FROM sys_bonus_transfer_status WHERE bonus_transfer_status_administrator_id = " . $id . "
                UNION
                SELECT COUNT(*) AS item FROM sys_ewallet_cash_withdrawal_status WHERE ewallet_cash_withdrawal_status_administrator_id = " . $id . "
                UNION
                SELECT COUNT(*) AS item FROM sys_serial WHERE serial_create_administrator_id = " . $id . "
                UNION
                SELECT COUNT(*) AS item FROM sys_serial_activation WHERE serial_activation_administrator_id = " . $id . "
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