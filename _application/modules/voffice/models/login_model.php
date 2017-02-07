<?php

/*
 * Member Login Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_data_member_by_username($username) {
        $sql = "
            SELECT * 
            FROM sys_network 
            INNER JOIN sys_member ON member_network_id = network_id 
            INNER JOIN sys_member_account ON member_account_network_id = network_id 
            INNER JOIN sys_member_detail ON member_detail_network_id = network_id 
            WHERE member_account_username = '" . $username . "' 
        ";
        return $this->db->query($sql);
    }
    
    function get_list_network_group($id) {
        $sql = "
            SELECT network_id, 
            network_code 
            FROM sys_network_group 
            INNER JOIN sys_network ON network_id = network_group_member_network_id 
            WHERE network_group_parent_network_id = " . $id . " 
            AND network_group_is_approve = '1'
        ";
        return $this->db->query($sql);
    }

}

?>