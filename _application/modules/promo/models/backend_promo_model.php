<?php

/*
 * Backend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_promo_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function list_promo() {
        $sql = "SELECT * FROM site_promo WHERE promo_is_active = '1' ORDER BY promo_title ASC";
        return $this->db->query($sql);
    }

}

?>