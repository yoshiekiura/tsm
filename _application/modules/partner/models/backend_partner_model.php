<?php

/*
 * Backend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_partner_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function list_partner() {
        $sql = "SELECT * FROM site_partner WHERE partner_is_active = '1' ORDER BY partner_title ASC";
        return $this->db->query($sql);
    }

}

?>