<?php

/*
 * Backend Menu Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_menu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_list($par_id = 0) {
        $sql = "SELECT * FROM site_menu WHERE menu_par_id = '" . $par_id . "' ORDER BY menu_order_by ASC";
        return $this->db->query($sql);
    }

    function update_order_by($id, $sort) {
        $sql_current = "SELECT menu_par_id, menu_order_by FROM site_menu WHERE menu_id = '" . $id . "'";
        $query_current = $this->db->query($sql_current);
        $row_current = $query_current->row();
        $par_id = $row_current->menu_par_id;
        $order_by = $row_current->menu_order_by;
        
        $sql_total = "SELECT COUNT(*) AS row_count FROM site_menu WHERE menu_par_id = '" . $par_id . "'";
        $query_total = $this->db->query($sql_total);
        $row_total = $query_total->row();
        $total = $row_total->row_count;
        
        if(($sort == 'up' && $order_by > 1) || ($sort == 'down' && $order_by < $total)) {
            if ($sort == 'up') {
                $sql = "
                    SELECT menu_id, 
                    menu_order_by 
                    FROM site_menu 
                    WHERE menu_par_id = '" . $par_id . "' 
                    AND menu_order_by <= " . $order_by . " 
                    AND menu_id <> '" . $id . "' 
                    ORDER BY menu_order_by DESC 
                    LIMIT 1
                ";
            } elseif ($sort == 'down') {
                $sql = "
                    SELECT menu_id, 
                    menu_order_by 
                    FROM site_menu 
                    WHERE menu_par_id = '" . $par_id . "' 
                    AND menu_order_by >= " . $order_by . " 
                    AND menu_id <> '" . $id . "' 
                    ORDER BY menu_order_by ASC 
                ";
            }
            $query = $this->db->query($sql);
            $row = $query->row();

            $sql_update = "
                UPDATE site_menu 
                SET menu_order_by = '" . $order_by . "' 
                WHERE menu_id = '" . $row->menu_id . "'
            ";
            $this->db->query($sql_update);

            $sql_update = "
                UPDATE site_menu 
                SET menu_order_by = '" . $row->menu_order_by . "' 
                WHERE menu_id = '" . $id . "'
            ";
            $this->db->query($sql_update);
            
            return true;
        } else {
            return false;
        }
    }

    function get_menu_title($id = 0) {
        $sql = "SELECT menu_title FROM site_menu WHERE menu_id = '" . $id . "' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            return $row->menu_title;
        } else {
            return '';
        }
    }

}

?>