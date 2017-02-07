<?php

/*
 * Member Page Model
 *
 * @author	@yonkz28
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Page_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_page($id) {
        $sql = "SELECT * FROM site_page WHERE page_id = '" . $id . "' LIMIT 1";
        return $this->db->query($sql);
    }

}

?>
