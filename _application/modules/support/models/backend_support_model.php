<?php

/*
 * Backend Support Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_support_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function update_order_by($id, $sort) {
        $sql_current = "SELECT support_order_by FROM site_support WHERE support_id = '" . $id . "'";
        $query_current = $this->db->query($sql_current);
        $row_current = $query_current->row();
        $order_by = $row_current->support_order_by;
        
        $sql_total = "SELECT COUNT(*) AS row_count FROM site_support";
        $query_total = $this->db->query($sql_total);
        $row_total = $query_total->row();
        $total = $row_total->row_count;
        
        if(($sort == 'up' && $order_by > 1) || ($sort == 'down' && $order_by < $total)) {
            if ($sort == 'up') {
                $sql = "
                    SELECT support_id, 
                    support_order_by 
                    FROM site_support 
                    WHERE support_order_by <= " . $order_by . " 
                    AND support_id <> '" . $id . "' 
                    ORDER BY support_order_by DESC 
                    LIMIT 1
                ";
            } elseif ($sort == 'down') {
                $sql = "
                    SELECT support_id, 
                    support_order_by 
                    FROM site_support 
                    WHERE support_order_by >= " . $order_by . " 
                    AND support_id <> '" . $id . "' 
                    ORDER BY support_order_by ASC 
                ";
            }
            $query = $this->db->query($sql);
            $row = $query->row();

            $sql_update = "
                UPDATE site_support 
                SET support_order_by = '" . $order_by . "' 
                WHERE support_id = '" . $row->support_id . "'
            ";
            $this->db->query($sql_update);

            $sql_update = "
                UPDATE site_support 
                SET support_order_by = '" . $row->support_order_by . "' 
                WHERE support_id = '" . $id . "'
            ";
            $this->db->query($sql_update);
            
            return true;
        } else {
            return false;
        }
    }

}

?>