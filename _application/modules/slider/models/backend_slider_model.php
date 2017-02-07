<?php

/*
 * Backend Slider Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_slider_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function update_order_by($id, $sort) {
        $sql_current = "SELECT slider_block, slider_order_by FROM site_slider WHERE slider_id = '" . $id . "'";
        $query_current = $this->db->query($sql_current);
        $row_current = $query_current->row();
        $slider_block = $row_current->slider_block;
        $order_by = $row_current->slider_order_by;
        
        $sql_total = "SELECT COUNT(*) AS row_count FROM site_slider WHERE slider_block = '" . $slider_block . "'";
        $query_total = $this->db->query($sql_total);
        $row_total = $query_total->row();
        $total = $row_total->row_count;
        
        if(($sort == 'up' && $order_by > 1) || ($sort == 'down' && $order_by < $total)) {
            if ($sort == 'up') {
                $sql = "
                    SELECT slider_id, 
                    slider_order_by 
                    FROM site_slider 
                    WHERE slider_block = '" . $slider_block . "' 
                    AND slider_order_by <= " . $order_by . " 
                    AND slider_id <> '" . $id . "' 
                    ORDER BY slider_order_by DESC 
                    LIMIT 1
                ";
            } elseif ($sort == 'down') {
                $sql = "
                    SELECT slider_id, 
                    slider_order_by 
                    FROM site_slider 
                    WHERE slider_block = '" . $slider_block . "' 
                    AND slider_order_by >= " . $order_by . " 
                    AND slider_id <> '" . $id . "' 
                    ORDER BY slider_order_by ASC 
                ";
            }
            $query = $this->db->query($sql);
            $row = $query->row();

            $sql_update = "
                UPDATE site_slider 
                SET slider_order_by = '" . $order_by . "' 
                WHERE slider_id = '" . $row->slider_id . "'
            ";
            $this->db->query($sql_update);

            $sql_update = "
                UPDATE site_slider 
                SET slider_order_by = '" . $row->slider_order_by . "' 
                WHERE slider_id = '" . $id . "'
            ";
            $this->db->query($sql_update);
            
            return true;
        } else {
            return false;
        }
    }

}

?>