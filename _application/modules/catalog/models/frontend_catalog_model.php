<?php

/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of frontend_catalog_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_catalog_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_random_catalog($limit) {
        $this->db->from('site_catalog');
        $this->db->where('catalog_is_active', '1');
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        
        return $this->db->get();
    }
    
    function get_catalog_detail($id) {
        $this->db->from('site_catalog');
        $this->db->where('catalog_id', $id);
        $this->db->where('catalog_is_active', '1');
        
        return $this->db->get();
    }
    
    public function get_catalog_list($offset = 0, $limit = 5) {
        $this->db->from('site_catalog');
        $this->db->where(array('catalog_is_active' => '1'));
        $this->db->order_by('catalog_order_by', 'ASC');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }
}

?>
