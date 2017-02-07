<?php

/*
 * Backend Administrator Menu Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_administrator_menu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_list($par_id = 0) {
        $sql = "SELECT * FROM site_administrator_menu WHERE administrator_menu_par_id = '" . $par_id . "' ORDER BY administrator_menu_order_by ASC";
        return $this->db->query($sql);
    }
    
    function get_menu_title($id = 0) {
        $sql = "SELECT administrator_menu_title FROM site_administrator_menu WHERE administrator_menu_id = '" . $id . "' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            return $row->administrator_menu_title;
        } else {
            return '';
        }
    }
    
    function get_menu_par_id($id = 0) {
        $sql = "SELECT administrator_menu_par_id FROM site_administrator_menu WHERE administrator_menu_id = '" . $id . "' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            return $row->administrator_menu_par_id;
        } else {
            return 0;
        }
    }

    function update_order_by($id, $sort) {
        $sql_current = "SELECT administrator_menu_par_id, administrator_menu_order_by FROM site_administrator_menu WHERE administrator_menu_id = '" . $id . "'";
        $query_current = $this->db->query($sql_current);
        $row_current = $query_current->row();
        $par_id = $row_current->administrator_menu_par_id;
        $order_by = $row_current->administrator_menu_order_by;
        
        $sql_total = "SELECT COUNT(*) AS row_count FROM site_administrator_menu WHERE administrator_menu_par_id = '" . $par_id . "'";
        $query_total = $this->db->query($sql_total);
        $row_total = $query_total->row();
        $total = $row_total->row_count;
        
        if(($sort == 'up' && $order_by > 1) || ($sort == 'down' && $order_by < $total)) {
            if ($sort == 'up') {
                $sql = "
                    SELECT administrator_menu_id, 
                    administrator_menu_order_by 
                    FROM site_administrator_menu 
                    WHERE administrator_menu_par_id = '" . $par_id . "' 
                    AND administrator_menu_order_by <= " . $order_by . " 
                    AND administrator_menu_id <> '" . $id . "' 
                    ORDER BY administrator_menu_order_by DESC 
                    LIMIT 1
                ";
            } elseif ($sort == 'down') {
                $sql = "
                    SELECT administrator_menu_id, 
                    administrator_menu_order_by 
                    FROM site_administrator_menu 
                    WHERE administrator_menu_par_id = '" . $par_id . "' 
                    AND administrator_menu_order_by >= " . $order_by . " 
                    AND administrator_menu_id <> '" . $id . "' 
                    ORDER BY administrator_menu_order_by ASC 
                ";
            }
            $query = $this->db->query($sql);
            $row = $query->row();

            $sql_update = "
                UPDATE site_administrator_menu 
                SET administrator_menu_order_by = '" . $order_by . "' 
                WHERE administrator_menu_id = '" . $row->administrator_menu_id . "'
            ";
            $this->db->query($sql_update);

            $sql_update = "
                UPDATE site_administrator_menu 
                SET administrator_menu_order_by = '" . $row->administrator_menu_order_by . "' 
                WHERE administrator_menu_id = '" . $id . "'
            ";
            $this->db->query($sql_update);
            
            return true;
        } else {
            return false;
        }
    }

}

?>