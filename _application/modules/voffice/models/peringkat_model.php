<?php

/*
 * Member Peringkat Model
 *
 * @author	Yudha Wirawan S
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Peringkat_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_data($id) {
        $sql = 'SELECT network_id, network_code, member_name, IFNULL(profit_sharing_grade_title_name,"-") AS profit_sharing_grade_title_name, network_sponsor_network_id FROM sys_network 
                LEFT JOIN sys_member ON network_id = member_network_id
                LEFT JOIN sys_profit_sharing_grade ON profit_sharing_grade_network_id = member_network_id
                LEFT JOIN sys_profit_sharing_grade_title ON profit_sharing_grade_title_id = profit_sharing_grade_profit_sharing_grade_title_id
                WHERE network_sponsor_network_id = "'.$id.'"
                ';
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}

?>