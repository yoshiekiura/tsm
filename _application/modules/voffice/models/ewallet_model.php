<?php

/**
 * Description of ewallet_model
 *
 * @author el-fatih
 */
class ewallet_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_saldo_ewallet_product($network_id) {
        $saldo_ewallet_product = $this->function_lib->get_one('sys_ewallet_product', 'ewallet_product_balance', array('ewallet_product_network_id' => $network_id));
        if($saldo_ewallet_product == '') {
            $saldo_ewallet_product = 0;
        }

        return $saldo_ewallet_product;
    }

    function get_query_data($network_id, $params, $count = false) {
        
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT ewallet_product_log_id,
                ewallet_product_log_type, 
                ewallet_product_log_value, 
                ewallet_product_log_note, 
                ewallet_product_log_datetime
                FROM sys_ewallet_product_log 
                $where_detail 
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
