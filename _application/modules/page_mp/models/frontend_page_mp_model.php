<?php

/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of frontend_page_mp_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_page_mp_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    
    public function get_mp() {
        $sql = "SELECT * FROM site_page_mp WHERE page_mp_is_active = '1' ORDER BY page_mp_id ASC";
        return $this->db->query($sql);
    }
    public function get_page_mp($id) {
        $sql = "SELECT * FROM site_page_mp WHERE page_mp_is_active = '1' AND page_mp_id = '{$id}'";
        return $this->db->query($sql);
    }
    
    public function get_page_mp_all($id) {
        $sql = "SELECT * FROM site_page_mp WHERE page_mp_is_active = '1' AND page_mp_id != '{$id}'";
        return $this->db->query($sql);
    }
    
}
?>
