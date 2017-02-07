<?php

/*
 * Auth Login Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_data_administrator_by_username($username) {
        $sql = "
            SELECT * 
            FROM site_administrator 
            INNER JOIN site_administrator_group ON administrator_group_id = administrator_administrator_group_id 
            WHERE administrator_username = '" . $username . "' 
        ";
        return $this->db->query($sql);
    }
    
    function get_data_administrator_last_login() {
        $sql_last_login = "
            SELECT * 
            FROM site_administrator 
            ORDER BY administrator_last_login DESC 
            LIMIT 1
        ";
        return $this->db->query($sql_last_login);
    }

}

?>