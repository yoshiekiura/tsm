<?php

/**
 * Description of frontend_catalog_model
 *
 * @author Yusuf Rahmanto
 */
class Frontend_catalog_item_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_catalog_list($offset = 0, $limit = 9) {
        $this->db->from('site_catalog_item_detail');
        $this->db->where(array('catalog_item_detail_is_active' => '1'));
        $this->db->order_by('RAND()');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
    
    public function get_catalog_detail_list($id, $offset = 0, $limit = 1) {
        $this->db->from('site_catalog_item_detail');
        $this->db->where(array('catalog_item_detail_is_active' => '1'));
        $this->db->where('catalog_item_detail_item_id', $id);
        //$this->db->order_by('catalog_item_id');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
    
    public function get_catalog($offset = 0, $limit = 9) {
        $this->db->from('site_catalog_item');
        $this->db->where(array('catalog_item_is_active' => '1'));
        //$this->db->order_by('RAND()');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
    
//    function get_catalog_detail($id, $offset = 0 , $limit = 1) {
//        $this->db->from('site_catalog_item_detail');
//        $this->db->where('catalog_item_detail_item_id', $id);
//        $this->db->where('catalog_item_detail_is_active', '1');
//        
//        
//        return $this->db->get();
//    }
    
    function get_catalog_item_date($id){
        $sql = "SELECT catalog_item_title, catalog_item_date FROM site_catalog_item where catalog_item_id =".$id." ";
        $query = $this->db->query($sql);
        return $query->row();
    }
    
    public function get_catalog_category() {
        $this->db->from('site_catalog_item');
        $this->db->where(array('catalog_item_is_active' => '1'));
        $this->db->order_by('catalog_item_date', 'DESC');

        return $this->db->get();
    }
    
    public function get_catalog_by_category($cat = 0, $offset = 0, $limit = 9) {
        $this->db->from('site_catalog_item_detail');
        $this->db->where(array('catalog_item_detail_item_id' => $cat));
        $this->db->where(array('catalog_item_detail_is_active' => '1'));
        $this->db->order_by('catalog_item_detail_order_by');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
}

?>
