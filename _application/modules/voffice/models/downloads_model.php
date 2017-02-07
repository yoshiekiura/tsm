<?php

/*
 * Member Downloads Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Downloads_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function update_downloads_count($id) {
        $sql = "UPDATE site_downloads SET downloads_count = downloads_count + 1 WHERE downloads_id = '" . $id . "'";
        $this->db->query($sql);
    }

}

?>