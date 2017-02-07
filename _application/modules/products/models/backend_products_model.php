<?php
/**
 * Description of backend_products_model
 *
 * @author Almira
 * @editor Fahrur Rifai
 */
class Backend_products_model extends CI_Model{
    //put your code here
    
     function __construct() {
        parent::__construct();
    }

    function get_list() {
        $sql = "SELECT * FROM site_products WHERE products_is_active = '1' ORDER BY products_id ASC";
        return $this->db->query($sql);
    }

    function update_item_order_by($id, $sort) {
        $sql_current = "SELECT product_item_product_id, product_item_order_by FROM site_product_item WHERE product_item_id = '" . $id . "'";
        $query_current = $this->db->query($sql_current);
        $row_current = $query_current->row();
        $products_id = $row_current->product_item_product_id;
        $order_by = $row_current->product_item_order_by;
        
        $sql_total = "SELECT COUNT(*) AS row_count FROM site_product_item WHERE product_item_product_id = '" . $products_id . "'";
        $query_total = $this->db->query($sql_total);
        $row_total = $query_total->row();
        $total = $row_total->row_count;
        
        if(($sort == 'up' && $order_by > 1) || ($sort == 'down' && $order_by < $total)) {
            if ($sort == 'up') {
                $sql = "
                    SELECT product_item_id, 
                    product_item_order_by 
                    FROM site_product_item 
                    WHERE product_item_product_id = '" . $products_id . "' 
                    AND product_item_order_by <= " . $order_by . " 
                    AND product_item_id <> '" . $id . "' 
                    ORDER BY product_item_order_by DESC 
                    LIMIT 1
                ";
            } elseif ($sort == 'down') {
                $sql = "
                    SELECT product_item_id, 
                    product_item_order_by 
                    FROM site_product_item 
                    WHERE product_item_product_id = '" . $products_id . "' 
                    AND product_item_order_by >= " . $order_by . " 
                    AND product_item_id <> '" . $id . "' 
                    ORDER BY product_item_order_by ASC 
                    
                ";
            }
            $query = $this->db->query($sql);
            $row = $query->row();

            $sql_update = "
                UPDATE site_product_item 
                SET product_item_order_by = '" . $order_by . "' 
                WHERE product_item_id = '" . $row->product_item_id . "'
            ";
            $this->db->query($sql_update);

            $sql_update = "
                UPDATE site_product_item 
                SET product_item_order_by = '" . $row->product_item_order_by . "' 
                WHERE product_item_id = '" . $id . "'
            ";
            $this->db->query($sql_update);
            
            return true;
        } else {
            return false;
        }
    }
    
    function get_list_item($product_id) {
        $sql = "SELECT product_item_id , product_item_image
                FROM site_product_item WHERE product_item_product_id = '".$product_id."'
            ";
        
        $query = $this->db->query($sql);
        return $query;
    }
}
