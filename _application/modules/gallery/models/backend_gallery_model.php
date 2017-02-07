<?php

/*
 * Backend Gallery Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_gallery_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_list() {
        $sql = "SELECT * FROM site_gallery WHERE gallery_is_active = '1' ORDER BY gallery_title ASC";
        return $this->db->query($sql);
    }
    
    function get_list_item($id) {
        $sql = "SELECT * FROM site_gallery INNER JOIN  site_gallery_item ON gallery_id = gallery_item_gallery_id WHERE gallery_id = '".$id."'";
        return $this->db->query($sql);
    }

    function update_item_order_by($id, $sort) {
        $sql_current = "SELECT gallery_item_gallery_id, gallery_item_order_by FROM site_gallery_item WHERE gallery_item_id = '" . $id . "'";
        $query_current = $this->db->query($sql_current);
        $row_current = $query_current->row();
        $gallery_id = $row_current->gallery_item_gallery_id;
        $order_by = $row_current->gallery_item_order_by;
        
        $sql_total = "SELECT COUNT(*) AS row_count FROM site_gallery_item WHERE gallery_item_gallery_id = '" . $gallery_id . "'";
        $query_total = $this->db->query($sql_total);
        $row_total = $query_total->row();
        $total = $row_total->row_count;
        
        if(($sort == 'up' && $order_by > 1) || ($sort == 'down' && $order_by < $total)) {
            if ($sort == 'up') {
                $sql = "
                    SELECT gallery_item_id, 
                    gallery_item_order_by 
                    FROM site_gallery_item 
                    WHERE gallery_item_gallery_id = '" . $gallery_id . "' 
                    AND gallery_item_order_by <= " . $order_by . " 
                    AND gallery_item_id <> '" . $id . "' 
                    ORDER BY gallery_item_order_by DESC 
                    LIMIT 1
                ";
            } elseif ($sort == 'down') {
                $sql = "
                    SELECT gallery_item_id, 
                    gallery_item_order_by 
                    FROM site_gallery_item 
                    WHERE gallery_item_gallery_id = '" . $gallery_id . "' 
                    AND gallery_item_order_by >= " . $order_by . " 
                    AND gallery_item_id <> '" . $id . "' 
                    ORDER BY gallery_item_order_by ASC 
                ";
            }
            $query = $this->db->query($sql);
            $row = $query->row();

            $sql_update = "
                UPDATE site_gallery_item 
                SET gallery_item_order_by = '" . $order_by . "' 
                WHERE gallery_item_id = '" . $row->gallery_item_id . "'
            ";
            $this->db->query($sql_update);

            $sql_update = "
                UPDATE site_gallery_item 
                SET gallery_item_order_by = '" . $row->gallery_item_order_by . "' 
                WHERE gallery_item_id = '" . $id . "'
            ";
            $this->db->query($sql_update);
            
            return true;
        } else {
            return false;
        }
    }

}

?>