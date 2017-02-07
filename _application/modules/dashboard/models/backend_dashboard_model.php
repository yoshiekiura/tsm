<?php

/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of backend_dashboard_model
 *
 * @author Yusuf Rahmanto
 */
class backend_dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function sum_bonus_log($arr_bonus, $date) {
        foreach ($arr_bonus as $row) {
            $this->db->select_sum('bonus_log_' . $row['name'], 'log_' . $row['name']);
        }
        $this->db->where('bonus_log_date >=', $date['start']);
        $this->db->where('bonus_log_date <=', $date['end']);
        return $this->db->get('sys_bonus_log');
    }

    function sum_transfer($arr_bonus, $date) {
        foreach ($arr_bonus as $row) {
            $this->db->select_sum('bonus_transfer_detail_' . $row['name'], 'transfer_' . $row['name']);
        }
        $this->db->join('sys_bonus_transfer_detail', 'bonus_transfer_detail_bonus_transfer_id=bonus_transfer_id', 'left');
        $this->db->where('DATE(bonus_transfer_datetime) >=', $date['start']);
        $this->db->where('DATE(bonus_transfer_datetime) <=', $date['end']);
        return $this->db->get('sys_bonus_transfer');
    }

    function get_total_bonus_paid(){
        $sql = "SELECT SUM(bonus_transfer_nett) AS total_bonus FROM sys_bonus_transfer_status 
                INNER JOIN
                sys_bonus_transfer ON bonus_transfer_id = bonus_transfer_status_id 
                WHERE bonus_transfer_status_status = 'success'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function sum_total_bonus() {
        $sql = "SELECT SUM(bonus_sponsor_acc) AS bonus_sponsor, 
                           SUM(bonus_gen_sponsor_acc) AS bonus_gen_sponsor, 
                           SUM(bonus_profit_sharing_acc) AS bonus_profit_sharing, 
                           SUM(bonus_royalty_payment_acc) AS bonus_royalti FROM sys_bonus";
        $query = $this->db->query($sql);
        return $query->row();
    }

    /* MEMBER */
    function get_total_member($date=FALSE, $periode='day') {
        if ($date !== FALSE) {
            if ($periode == 'day') {
                $this->db->where('DATE(member_join_datetime)', $date);
            } elseif ($periode == 'week') {
                $timestamp = mktime(0, 0, 0, date('n', strtotime($date)), date('j', strtotime($date))-7, date('Y', strtotime($date)));
                $yesterweek = date('Y-m-d', $timestamp);
                $this->db->where("DATE(member_join_datetime) BETWEEN '$yesterweek' AND '$date'");
            } elseif ($periode == 'month') {
                $this->db->where('MONTH(member_join_datetime)', date('m', strtotime($date)));
            } elseif ($periode == 'year') {
                $this->db->where('YEAR(member_join_datetime)', date('Y', strtotime($date)));
            }
        }
        $this->db->where('member_is_active', '1');
        $this->db->join('sys_member', 'member_network_id=network_id', 'left');
        return $this->db->count_all_results('sys_network');
    }
    /* END MEMBER */

    /* SERIAL */
    function get_serial_type() {
        $this->db->where('serial_type_is_active', '1');
        return $this->db->get('sys_serial_type');
    }

    function get_total_serial() {
        return $this->db->count_all('sys_serial');
    }

    function get_total_serial_active() {
        $this->db->where('serial_is_active', '1');
        return $this->db->count_all_results('sys_serial');
    }

    function get_total_serial_used() {
        $this->db->where('serial_is_used', '1');
        return $this->db->count_all_results('sys_serial');
    }

    function sum_penggunaan_serial($date) {
        $this->db->where('DATE(serial_user_datetime)', $date);
        $this->db->select('COUNT(serial_id) AS total');
        $this->db->where('serial_is_used', '1');
        $this->db->join('sys_serial_user', 'serial_user_serial_id=serial_id', 'left');
        return $this->db->get('sys_serial');
    }
    /* END SERIAL */

    /* BONUS */
    function get_total_bonus() {
        $query = $this->db->get('report_summary_bonus');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function get_total_sponsoring($date=FALSE){
        $sql = "
            SELECT COUNT(netgrow_sponsor_downline_network_id) AS total_sponsoring
            FROM sys_netgrow_sponsor 
            ";

        if ($date !== FALSE) {
            $sql .= " WHERE netgrow_sponsor_date = '".$date."'";
        }

        $query = $this->db->query($sql);

        $result = $query->row();

        return $result->total_sponsoring;
    }

    function get_total_match($date=FALSE){
        $sql = "
            SELECT SUM(netgrow_match_value) AS total_matching
            FROM sys_netgrow_match 
            ";

        if ($date !== FALSE) {
            $sql .= " WHERE netgrow_match_date = '".$date."'";
        }

        $query = $this->db->query($sql);

        $result = $query->row();

        return $result->total_matching;
    }

    function get_total_arr_node($level=FALSE, $date=FALSE) {
        $arr_node = array(
            'left' => 0, 
            'right' => 0
        );
        $sql = "
            SELECT SUM(IF(netgrow_node_position = 'L', 1, 0)) AS node_left, 
            SUM(IF(netgrow_node_position = 'R', 1, 0)) AS node_right 
            FROM sys_netgrow_node WHERE 1
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

    function calculate_bonus_sponsor_daily($bonus_value, $max_level) {
        $total_bonus = 0;
        $total_sponsoring = $this->get_total_sponsoring(date('Y-m-d'));
        $total_bonus = $total_sponsoring * $bonus_value;
        return ($total_bonus);
    }

    function calculate_bonus_node_daily($bonus_value, $max_level) {
        $total_bonus = 0;
        foreach ($bonus_value as $level => $value) {
            $total_node_bonus = $this->get_total_arr_node($level, date('Y-m-d'));
            $total_node = $total_node_bonus['left'] + $total_node_bonus['right'];
            $total_bonus_pre = ($total_node * $value);
            $total_bonus += $total_bonus_pre;
        }   
        return ($total_bonus);
    }

    function calculate_bonus_match_daily($bonus_value, $max_level) {
        $total_bonus = 0;
        $total_matching = $this->get_total_match(date('Y-m-d'));
        $total_bonus = $total_matching * $bonus_value;
        return ($total_bonus);
    }
    /* END BONUS */

}
