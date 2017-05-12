<?php

/*
 * Backend Bonus Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_bonus_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_query_bonus_data($params, $count = false) {
        
        $str_select = $this->mlm_function->get_string_bonus_select_new();
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT network_id, 
                network_code, 
                member_name, 
                member_nickname, 
                member_phone, 
                member_mobilephone, 
                member_join_datetime, 
                member_is_active, 
                bank_id
                bank_name, 
                member_bank_city, 
                member_bank_branch, 
                member_bank_account_name, 
                member_bank_account_no, 
                $str_select 
                FROM sys_network 
                INNER JOIN sys_member ON member_network_id = network_id 
                INNER JOIN sys_member_bank ON member_bank_network_id = network_id 
                LEFT JOIN ref_bank ON bank_id = member_bank_bank_id 
                LEFT JOIN sys_bonus ON bonus_network_id = network_id 
                GROUP BY network_id 
            ) result 
            $where $sort $limit
        ";
        $query = $this->db->query($sql);
        
        if($count) {
            $row = $query->row();
            return $row->row_count;
        } else {
            return $query;
        }
    }

}

?>