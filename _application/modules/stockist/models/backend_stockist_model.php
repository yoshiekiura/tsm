<?php

/*
 * Backend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_stockist_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function list_stockist() {
        $sql = "SELECT * FROM site_stockist WHERE stockist_is_active = '1' ORDER BY stockist_title ASC";
        return $this->db->query($sql);
    }

}

?>