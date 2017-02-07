<?php

/**
 * Description of frontend_gallery_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_gallery_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_gallery_list($offset = 0, $limit = 10) {
        $this->db->from('site_gallery_item');
        $this->db->where(array('gallery_item_is_active' => '1'));
        //$this->db->order_by('RAND()');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }
    
  
    
    public function get_gallery_detail_list($id, $offset = 0, $limit = 1) {
        $this->db->from('site_gallery_item');
        $this->db->where(array('gallery_item_is_active' => '1'));
        $this->db->where('gallery_item_gallery_id', $id);
        //$this->db->order_by('gallery_item_id');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
    
    public function get_gallery($offset = 0, $limit = 10) {
        $this->db->select("*");
        $this->db->from('site_gallery');
        $this->db->where(array('gallery_is_active' => '1'));
        //$this->db->order_by('RAND()');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }
    
//    function get_gallery_detail($id, $offset = 0 , $limit = 1) {
//        $this->db->from('site_gallery_item');
//        $this->db->where('gallery_item_gallery_id', $id);
//        $this->db->where('gallery_item_is_active', '1');
//        
//        
//        return $this->db->get();
//    }
    
    function get_gallery_date($id){
        $sql = "SELECT gallery_title, gallery_date FROM site_gallery where gallery_id =".$id." ";
        $query = $this->db->query($sql);
        return $query->row();
    }
    
    public function get_gallery_category() {
        $this->db->from('site_gallery');
        $this->db->where(array('gallery_is_active' => '1'));
        $this->db->order_by('gallery_date', 'DESC');

        return $this->db->get();
    }
    
    public function get_gallery_by_category($cat = 0, $offset = 0, $limit = 9) {
        $this->db->from('site_gallery_item');
        $this->db->where(array('gallery_item_gallery_id' => $cat));
        $this->db->where(array('gallery_item_is_active' => '1'));
        $this->db->order_by('gallery_item_order_by');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
}

?>
