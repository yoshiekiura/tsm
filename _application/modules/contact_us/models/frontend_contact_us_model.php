<?php

/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of frontend_page_mp_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_contact_us_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_contact_us($id) {
        $sql = "SELECT * FROM site_contact_us WHERE contact_us_is_active = '1' AND contact_us_id = '{$id}'";
        return $this->db->query($sql);
    }
    
    public function get_contact_us_all($id) {
        $sql = "SELECT * FROM site_contact_us WHERE contact_us_is_active = '1' AND contact_us_id != '{$id}'";
        return $this->db->query($sql);
    }
    
}
?>
