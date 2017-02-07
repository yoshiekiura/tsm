<?php

/*
 * Backend Event Model
 *
 * @author	Yudha Wirawan Sakti
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class backend_event_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function list_event() {
        $sql = "SELECT * FROM site_event WHERE event_is_active = '1' ORDER BY event_title ASC";
        return $this->db->query($sql);
    }

}

?>