<?php

/*
 * Backend Bank Account Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_bank_account_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_list() {
        $sql = "SELECT * FROM site_bank_account WHERE bank_account_is_active = '1' ORDER BY bank_account_name ASC";
        return $this->db->query($sql);
    }

}

?>