<?php

/**
 * Description of frontend_menu_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_menu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_menu_frontend() {
        $this->db->from('site_menu');
        $this->db->where('menu_block', 'sidebar');
        $this->db->where('menu_is_active', '1');
        $this->db->order_by('menu_order_by', 'ASC');
        
        return $this->db->get();
    }
    
    function get_menu_top($menu_par_id = null) {
        $where_option = "";
        
        $this->db->from('site_menu');
        $this->db->where('menu_block', 'top');
        if($menu_par_id != null) {
            $this->db->where('menu_par_id', $menu_par_id);            
        }
        $this->db->where('menu_is_active', '1');
        $this->db->order_by('menu_order_by', 'ASC');
        
        return $this->db->get();
    }

    function get_menu_block($block='top', $menu_par_id = null) {
        $where_option = "";
        
        $this->db->from('site_menu');
        $this->db->where('menu_block', $block);
        if($menu_par_id != null) {
            $this->db->where('menu_par_id', $menu_par_id);            
        }
        $this->db->where('menu_is_active', '1');
        $this->db->order_by('menu_order_by', 'ASC');
        
        return $this->db->get();
    }
}
