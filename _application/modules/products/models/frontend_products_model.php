<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of frontend_products_model
 *
 * @author Almira
 * @editor Fahrur Rifai
 */
class frontend_products_model extends CI_Model{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    public function get_products_list($offset = 0, $limit = 9) {
        $this->db->from('site_product');
        $this->db->where(array('product_is_active' => '1'));
        $this->db->order_by('product_id','DESC');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
    
    function get_products_detail($id) {
        $this->db->from('site_product');
        $this->db->where('product_id', $id);
        $this->db->where('product_is_active', '1');
        
        return $this->db->get();
    }
    
    function get_products_detail_item($id) {
        $this->db->where('product_item_is_active', '1');
        $this->db->from('site_product_item');
        $this->db->where('product_item_product_id', $id);        
        return $this->db->get();
    }
}
