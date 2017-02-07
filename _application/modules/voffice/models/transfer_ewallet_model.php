<?php

/*
 * Member Transfer Ewallet Model
 *
 * @author	Yudha Wirawan S
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Transfer_ewallet_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_query_log_data($network_id, $params, $count = false) {
        
        $str_select = $this->mlm_function->get_string_bonus_log_select();
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT bonus_log_id, bonus_log_date, 
                $str_select 
                FROM sys_bonus_log 
                WHERE bonus_log_network_id = '" . $network_id . "'
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
    
    function get_query_transfer_data($network_id, $params, $count = false) {
        $arr_transfer_category = $this->mlm_function->get_arr_transfer_category();
        $str_case_category = "";
        if(is_array($arr_transfer_category)) {
            foreach($arr_transfer_category as $name => $label) {
                $str_case_category .= "WHEN '" . $name . "' THEN '" . $label . "' ";
            }
        }
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT *, 
                (
                    CASE bonus_transfer_category 
                    $str_case_category 
                    ELSE '-'
                    END
                ) AS bonus_transfer_category_label, 
                (
                    CASE bonus_transfer_status 
                    WHEN 'pending' THEN 'PENDING' 
                    WHEN 'failed' THEN 'GAGAL' 
                    WHEN 'success' THEN 'SUKSES' 
                    ELSE '-'
                    END
                ) AS bonus_transfer_status_label 
                FROM sys_bonus_transfer 
                WHERE bonus_transfer_network_id = '" . $network_id . "'
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
    
    function get_detail_bonus_transfer_detail($bonus_transfer_id, $arr_bonus) {
        
        //string untuk select jenis bonus
        $str_select_sum = "";
        if(is_array($arr_bonus)) {
            foreach($arr_bonus as $bonus_item) {
                $str_select_sum .= "SUM(bonus_transfer_detail_" . $bonus_item . ") AS bonus_transfer_detail_" . $bonus_item . ", ";
            }
        }
        $str_select_sum = rtrim($str_select_sum, ", ");
        
        $sql = "
            SELECT $str_select_sum 
            FROM sys_bonus_transfer_detail 
            WHERE bonus_transfer_detail_bonus_transfer_id = '" . $bonus_transfer_id . "'
        ";
        return $this->db->query($sql);
    }

}

?>