<?php

/*
 * Backend Catalog Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_catalog_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function update_order_by($id, $sort) {
        $sql_current = "SELECT catalog_order_by FROM site_catalog WHERE catalog_id = '" . $id . "'";
        $query_current = $this->db->query($sql_current);
        $row_current = $query_current->row();
        $order_by = $row_current->catalog_order_by;
        
        $sql_total = "SELECT COUNT(*) AS row_count FROM site_catalog";
        $query_total = $this->db->query($sql_total);
        $row_total = $query_total->row();
        $total = $row_total->row_count;
        
        if(($sort == 'up' && $order_by > 1) || ($sort == 'down' && $order_by < $total)) {
            if ($sort == 'up') {
                $sql = "
                    SELECT catalog_id, 
                    catalog_order_by 
                    FROM site_catalog 
                    WHERE catalog_order_by <= " . $order_by . " 
                    AND catalog_id <> '" . $id . "' 
                    ORDER BY catalog_order_by DESC 
                    LIMIT 1
                ";
            } elseif ($sort == 'down') {
                $sql = "
                    SELECT catalog_id, 
                    catalog_order_by 
                    FROM site_catalog 
                    WHERE catalog_order_by >= " . $order_by . " 
                    AND catalog_id <> '" . $id . "' 
                    ORDER BY catalog_order_by ASC 
                ";
            }
            $query = $this->db->query($sql);
            $row = $query->row();

            $sql_update = "
                UPDATE site_catalog 
                SET catalog_order_by = '" . $order_by . "' 
                WHERE catalog_id = '" . $row->catalog_id . "'
            ";
            $this->db->query($sql_update);

            $sql_update = "
                UPDATE site_catalog 
                SET catalog_order_by = '" . $row->catalog_order_by . "' 
                WHERE catalog_id = '" . $id . "'
            ";
            $this->db->query($sql_update);
            
            return true;
        } else {
            return false;
        }
    }

}

?>