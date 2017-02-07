<?php

/*
 * Frontend Page Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Frontend_page_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_homepage() {
        $sql = "SELECT * FROM site_page_home WHERE page_home_location = 'frontend' LIMIT 1";
        return $this->db->query($sql);
    }
    
    public function get_page($id) {
        $sql = "SELECT * FROM site_page WHERE page_id = '" . $id . "' LIMIT 1";
        return $this->db->query($sql);
    }

}

?>