<?php

/*
 * Backend Gallery Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_catalog_item_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_list() {
        $sql = "SELECT * FROM site_catalog_item WHERE catalog_item_is_active = '1' ORDER BY gallery_title ASC";
        return $this->db->query($sql);
    }
    
    function get_list_item($id) {
        $sql = "SELECT * FROM site_catalog_item INNER JOIN  site_catalog_item_detail ON catalog_item_id = catalog_item_detail_item_id WHERE catalog_item_id = '".$id."'";
        return $this->db->query($sql);
    }

    function update_item_order_by($id, $sort) {
        $sql_current = "SELECT catalog_item_detail_item_id, catalog_item_detail_order_by FROM site_catalog_item_detail WHERE catalog_item_id = '" . $id . "'";
        $query_current = $this->db->query($sql_current);
        $row_current = $query_current->row();
        $catalog_item_id = $row_current->catalog_item_detail_item_id;
        $order_by = $row_current->catalog_item_detail_order_by;
        
        $sql_total = "SELECT COUNT(*) AS row_count FROM site_catalog_item_detail WHERE catalog_item_detail_item_id = '" . $catalog_item_id . "'";
        $query_total = $this->db->query($sql_total);
        $row_total = $query_total->row();
        $total = $row_total->row_count;
        
        if(($sort == 'up' && $order_by > 1) || ($sort == 'down' && $order_by < $total)) {
            if ($sort == 'up') {
                $sql = "
                    SELECT catalog_item_id, 
                    catalog_item_detail_order_by 
                    FROM site_catalog_item_detail 
                    WHERE catalog_item_detail_item_id = '" . $catalog_item_id . "' 
                    AND catalog_item_detail_order_by <= " . $order_by . " 
                    AND catalog_item_id <> '" . $id . "' 
                    ORDER BY catalog_item_detail_order_by DESC 
                    LIMIT 1
                ";
            } elseif ($sort == 'down') {
                $sql = "
                    SELECT catalog_item_id, 
                    catalog_item_detail_order_by 
                    FROM site_catalog_item_detail 
                    WHERE catalog_item_detail_item_id = '" . $catalog_item_id . "' 
                    AND catalog_item_detail_order_by >= " . $order_by . " 
                    AND catalog_item_id <> '" . $id . "' 
                    ORDER BY catalog_item_detail_order_by ASC 
                ";
            }
            $query = $this->db->query($sql);
            $row = $query->row();

            $sql_update = "
                UPDATE site_catalog_item_detail 
                SET catalog_item_detail_order_by = '" . $order_by . "' 
                WHERE catalog_item_id = '" . $row->catalog_item_id . "'
            ";
            $this->db->query($sql_update);

            $sql_update = "
                UPDATE site_catalog_item_detail 
                SET catalog_item_detail_order_by = '" . $row->catalog_item_detail_order_by . "' 
                WHERE catalog_item_id = '" . $id . "'
            ";
            $this->db->query($sql_update);
            
            return true;
        } else {
            return false;
        }
    }

}

?>