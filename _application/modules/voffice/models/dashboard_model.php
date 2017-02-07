<?php

/*
 * Member Dashboard Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_homepage() {
        $sql = "SELECT * FROM site_page_dashboard WHERE page_dashboard_is_active = '1'";
        return $this->db->query($sql);
    }
    
    function get_unapproved_network_group($network_id) {
        $sql = "
            SELECT * 
            FROM sys_network_group 
            INNER JOIN view_network_member ON network_id = network_group_parent_network_id 
            WHERE network_group_member_network_id = '" . $network_id . "' 
            AND network_group_is_approve = '0'
        ";
        return $this->db->query($sql);
    }
    
    function get_downline_current_month($network_id, $year = '', $month = '') {
        if($year == '') {
            $year = date('Y');
        }
        
        if($month == '') {
            $month = date('m');
        }
        
        $sql = "
            SELECT network_code, 
            member_name, 
            member_join_datetime, 
            member_image, 
            sponsor_network_code, 
            sponsor_member_name 
            FROM sys_netgrow_node 
            INNER JOIN view_member ON network_id = netgrow_node_downline_network_id 
            WHERE netgrow_node_network_id = '" . $network_id . "' 
            AND YEAR(netgrow_node_date) = '" . $year . "' 
            AND MONTH(netgrow_node_date) = '" . $month . "'
        ";
        return $this->db->query($sql);
    }
    
    function get_str_reward_bonus_qualified($network_id, $year = '', $month = '') {
        if($year == '') {
            $year = date('Y');
        }
        
        if($month == '') {
            $month = date('m');
        }
        
        $sql = "
            SELECT GROUP_CONCAT(reward_qualified_reward_bonus SEPARATOR ', ') AS str_reward_bonus 
            FROM sys_reward_qualified 
            WHERE reward_qualified_network_id = '" . $network_id . "' 
            AND YEAR(reward_qualified_date) = '" . $year . "' 
            AND MONTH(reward_qualified_date) = '" . $month . "' 
            GROUP BY reward_qualified_network_id 
            ORDER BY reward_qualified_date ASC 
            LIMIT 1
        ";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            $str_reward_bonus = $row->str_reward_bonus;
        } else {
            $str_reward_bonus = '-';
        }
        
        return $str_reward_bonus;
    }
    
    function get_ewallet_product_balance($network_id) {
        $sql = "
            SELECT ewallet_product_balance 
            FROM sys_ewallet_product 
            WHERE ewallet_product_network_id = '" . $network_id . "' 
        ";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            $ewallet_product_balance = $row->ewallet_product_balance;
        } else {
            $ewallet_product_balance = 0;
        }
        
        return $ewallet_product_balance;
    }
    
    function get_bonus_log_subtotal_current_month($network_id, $year = '', $month = '') {
        if($year == '') {
            $year = date('Y');
        }
        
        if($month == '') {
            $month = date('m');
        }
        
        $str_select_bonus_log_subtotal = $this->mlm_function->get_string_bonus_log_subtotal_select();
        $sql = "
            SELECT $str_select_bonus_log_subtotal 
            FROM sys_bonus_log 
            WHERE bonus_log_network_id = '" . $network_id . "' 
            AND YEAR(bonus_log_date) = '" . $year . "' 
            AND MONTH(bonus_log_date) = '" . $month . "' 
        ";
        return $this->db->query($sql);
    }
    
    function get_sponsoring_count_current_month($network_id, $year = '', $month = '') {
        if($year == '') {
            $year = date('Y');
        }
        
        if($month == '') {
            $month = date('m');
        }
        
        $sql = "
            SELECT COUNT(netgrow_sponsor_id) AS sponsoring_count 
            FROM sys_netgrow_sponsor 
            WHERE netgrow_sponsor_network_id = '" . $network_id . "' 
            AND YEAR(netgrow_sponsor_date) = '" . $year . "' 
            AND MONTH(netgrow_sponsor_date) = '" . $month . "'
        ";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            $sponsoring_count = $row->sponsoring_count;
        } else {
            $sponsoring_count = 0;
        }
        
        return $sponsoring_count;
    }
    
    function get_arr_node_current_month($network_id, $year = '', $month = '') {
        if($year == '') {
            $year = date('Y');
        }
        
        if($month == '') {
            $month = date('m');
        }
        
        $arr_node = array(
            'left' => 0, 
            'right' => 0
        );
        $sql = "
            SELECT SUM(IF(netgrow_node_position = 'L', 1, 0)) AS node_left, 
            SUM(IF(netgrow_node_position = 'R', 1, 0)) AS node_right 
            FROM sys_netgrow_node 
            WHERE netgrow_node_network_id = " . $network_id . " 
            AND YEAR(netgrow_node_date) = '" . $year . "'
            AND MONTH(netgrow_node_date) = '" . $month . "'
        ";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            
            $arr_node['left'] = $row->node_left;
            $arr_node['right'] = $row->node_right;
        }
        
        return $arr_node;
    }
    
    function get_arr_bonus_acc($network_id = 0) {
        $arr_bonus_acc = array(
            'bonus_sponsor_acc' => 0,
            'bonus_gen_sponsor_acc' => 0,
            'bonus_profit_sharing_acc' => 0,
            'bonus_royalty_payment_acc' => 0,
        );
        $sql = "
            SELECT bonus_sponsor_acc, 
            bonus_gen_sponsor_acc, 
            bonus_profit_sharing_acc, 
            bonus_royalty_payment_acc 
            FROM sys_bonus 
            WHERE bonus_network_id = " . $network_id . "
        ";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            $arr_bonus_acc['bonus_sponsor_acc'] = $row->bonus_sponsor_acc;
            $arr_bonus_acc['bonus_gen_sponsor_acc'] = $row->bonus_gen_sponsor_acc;
            $arr_bonus_acc['bonus_profit_sharing_acc'] = $row->bonus_profit_sharing_acc;
            $arr_bonus_acc['bonus_royalty_payment_acc'] = $row->bonus_royalty_payment_acc;
        }
        
        return $arr_bonus_acc;
    }

    function get_total_sponsoring($network_id, $date=FALSE){
        $sql = "
            SELECT COUNT(netgrow_sponsor_downline_network_id) AS total_sponsoring
            FROM sys_netgrow_sponsor 
            WHERE netgrow_sponsor_network_id = $network_id 
            ";

        if ($date !== FALSE) {
            $sql .= " AND netgrow_sponsor_date = '".$date."'";
        }

        $query = $this->db->query($sql);

        $result = $query->row();

        return $result->total_sponsoring;
    }

    function get_total_match($network_id, $date=FALSE){
        $sql = "
            SELECT SUM(netgrow_match_value) AS total_matching
            FROM sys_netgrow_match 
            WHERE netgrow_match_network_id = $network_id 
            ";

        if ($date !== FALSE) {
            $sql .= " AND netgrow_match_date = '".$date."'";
        }

        $query = $this->db->query($sql);

        $result = $query->row();

        return $result->total_matching;
    }

    function get_total_arr_node($network_id, $level=FALSE, $date=FALSE) {
        $arr_node = array(
            'left' => 0, 
            'right' => 0
        );
        $sql = "
            SELECT SUM(IF(netgrow_node_position = 'L', 1, 0)) AS node_left, 
            SUM(IF(netgrow_node_position = 'R', 1, 0)) AS node_right 
            FROM sys_netgrow_node 
            WHERE netgrow_node_network_id = " . $network_id . "
        ";
        if ($level !== FALSE) {
            $sql .= " AND netgrow_node_level = ".$level;
        }
        if ($date !== FALSE) {
            $sql .= " AND netgrow_node_date = '".$date."'";
        }
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            $arr_node['left'] = $row->node_left;
            $arr_node['right'] = $row->node_right;
        }
        return $arr_node;
    }

    function get_total_bonus_log_subtotal($network_id) {
        $str_select_bonus_log_subtotal = $this->mlm_function->get_string_bonus_log_subtotal_select();
        $sql = "
            SELECT $str_select_bonus_log_subtotal 
            FROM sys_bonus_log 
            WHERE bonus_log_network_id = '" . $network_id . "'
        ";
        return $this->db->query($sql);
    }

}
