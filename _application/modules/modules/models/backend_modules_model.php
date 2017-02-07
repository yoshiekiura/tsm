<?php

/*
 * Backend Modules Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_modules_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_list() {
        $sql = "SELECT * FROM site_modules WHERE modules_is_active = '1' ORDER BY modules_name ASC";
        return $this->db->query($sql);
    }

}

?>