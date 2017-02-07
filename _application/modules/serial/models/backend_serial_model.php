<?php

/*
 * Backend Serial Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_serial_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_default_serial_type_id() {
        $sql = "SELECT serial_type_id FROM sys_serial_type WHERE serial_type_is_active = '1' ORDER BY serial_type_id ASC LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            $serial_type_id = $row->serial_type_id;
        } else {
            $serial_type_id = '0';
        }
        return $serial_type_id;
    }
    
    function get_serial_type_price($serial_id, $date) {
        $sql = "
            SELECT serial_type_price_log_value 
            FROM sys_serial 
            INNER JOIN sys_serial_type ON serial_type_id = serial_serial_type_id 
            LEFT JOIN sys_serial_type_price_log ON serial_type_price_log_serial_type_id = serial_type_id 
            WHERE serial_id = '" . $serial_id . "' 
            AND DATE(serial_type_price_log_datetime) <= '" . $date . "' 
            ORDER BY serial_type_price_log_datetime DESC 
            LIMIT 1
        ";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            $serial_type_price = $row->serial_type_price_log_value;
        } else {
            $serial_type_price = 0;
        }
        return $serial_type_price;
    }
    
    function get_last_serial() {
        $sql = "
            SELECT * 
            FROM sys_serial 
            ORDER BY serial_id DESC 
            LIMIT 1
        ";
        return $this->db->query($sql);
    }
    
    function get_list_serial_by_unix_datetime($unix_datetime) {
        $sql = "
            SELECT serial_type_label, 
            serial_id, 
            serial_pin, 
            serial_network_code 
            FROM sys_serial 
            INNER JOIN sys_serial_type ON serial_type_id = serial_serial_type_id 
            WHERE serial_create_datetime = FROM_UNIXTIME('" . $unix_datetime . "')
        ";
        return $this->db->query($sql);
    }
    
    function check_active($id) {
        $sql = "SELECT COUNT(*) AS item FROM sys_serial WHERE serial_id = '" . $id . "' AND serial_is_active = '1'";
        $query = $this->db->query($sql);
        $row = $query->row();
        $item = $row->item;
        
        if($item > 0) {
            return false;
        } else {
            return true;
        }
    }
    
    function check_used($id) {
        $sql = "SELECT COUNT(*) AS item FROM sys_serial WHERE serial_id = '" . $id . "' AND serial_is_used = '1'";
        $query = $this->db->query($sql);
        $row = $query->row();
        $item = $row->item;
        
        if($item > 0) {
            return false;
        } else {
            return true;
        }
    }
    
    function check_sold($id) {
        $sql = "SELECT COUNT(*) AS item FROM sys_serial WHERE serial_id = '" . $id . "' AND serial_is_sold = '1'";
        $query = $this->db->query($sql);
        $row = $query->row();
        $item = $row->item;
        
        if($item > 0) {
            return false;
        } else {
            return true;
        }
    }
    
    function get_query_serial_price_data($params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT serial_type_id, 
                serial_type_name, 
                serial_type_label, 
                serial_type_node, 
                (
                    SELECT serial_type_price_log_value 
                    FROM sys_serial_type_price_log 
                    WHERE serial_type_price_log_serial_type_id = serial_type_id 
                    ORDER BY serial_type_price_log_datetime DESC 
                    LIMIT 1
                ) AS serial_type_price 
                FROM sys_serial_type 
                WHERE serial_type_is_active = '1' 
                ORDER BY serial_type_node ASC
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
    
    function get_detail($id = 0) {
        $sql = "
            SELECT serial_type_label, 
            serial_type_price_log_value 
            FROM sys_serial_type_price_log 
            INNER JOIN sys_serial_type ON serial_type_id = serial_type_price_log_serial_type_id 
            WHERE serial_type_price_log_serial_type_id = '" . $id . "' 
            ORDER BY serial_type_price_log_datetime DESC 
            LIMIT 1
        ";
        return $this->db->query($sql);
    }
    
}

?>