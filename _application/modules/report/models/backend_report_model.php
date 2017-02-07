<?php

/*
 * Backend Report Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_query_bonus_log_data($params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        
        $arr_active_bonus = $this->mlm_function->get_arr_active_bonus();
        $str_select = "";
        if(is_array($arr_active_bonus)) {
            foreach($arr_active_bonus as $bonus_item) {
                $str_select .= "IFNULL(SUM(bonus_log_" . $bonus_item['name'] . "), 0) AS bonus_log_" . $bonus_item['name'] . "_in, ";
                $str_select .= "IFNULL(SUM(bonus_transfer_detail_" . $bonus_item['name'] . "), 0) AS bonus_log_" . $bonus_item['name'] . "_out, ";
                $str_select .= "(IFNULL(SUM(bonus_log_" . $bonus_item['name'] . "), 0) - IFNULL(SUM(bonus_transfer_detail_" . $bonus_item['name'] . "), 0)) AS bonus_log_" . $bonus_item['name'] . "_saldo, ";
            }
        }
        $str_select = rtrim($str_select, ", ");
        
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT bonus_log_id, 
                bonus_log_date, 
                $str_select 
                FROM sys_bonus_log 
                LEFT JOIN sys_bonus_transfer_detail ON bonus_log_id = bonus_transfer_detail_bonus_log_id 
                LEFT JOIN sys_bonus_transfer ON bonus_transfer_id = bonus_transfer_detail_bonus_transfer_id AND bonus_transfer_status NOT IN ('failed') 
                GROUP BY bonus_log_date
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