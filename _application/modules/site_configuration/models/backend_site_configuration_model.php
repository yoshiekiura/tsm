<?php

/*
 * Backend Site Configuration Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_site_configuration_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_list() {
        $sql = "
            SELECT * 
            FROM site_configuration 
            WHERE configuration_is_show = '1' 
            ORDER BY configuration_order_by ASC
        ";
        return $this->db->query($sql);
    }

}

?>