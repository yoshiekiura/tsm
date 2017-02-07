<?php

/*
 * Cron Common Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Cron_common_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_num_stock_network_code() {
        return $this->db->count_all_results('sys_stock_network_code');
    }
    
    function get_last_stock_network_code() {
        $sql = "SELECT MAX(stock_network_code_value) AS stock_network_code_value FROM sys_stock_network_code";
        $query = $this->db->query($sql);
        $row = $query->row();
        $last_stock_network_code = $row->stock_network_code_value;
        return $last_stock_network_code;
    }
    
    function get_last_network_code() {
        $sql = "SELECT MAX(network_code) AS network_code FROM sys_network";
        $query = $this->db->query($sql);
        $row = $query->row();
        $last_network_code = $row->network_code;
        return $last_network_code;
    }
    
    function insert_network_code($data) {
        $this->db->insert('sys_stock_network_code', $data);
    }
    
    function insert_log($data) {
        $this->db->insert('cron_log', $data);
    }

    function get_active_reward() {
        $sql = "
            SELECT reward_id, reward_cond_node_left as syarat_kiri, reward_cond_node_right AS syarat_kanan,
            reward_bonus,reward_bonus_value
            FROM sys_reward
            WHERE reward_is_active = '1'
        ";

        return $this->db->query($sql);
    }


    function get_member_qualified_reward($node_left_condition = 0,$node_right_condition = 0, $year) {
        $sql = "
                SELECT netgrow_master_network_id AS network_id, left_node, right_node
                FROM (
                    SELECT netgrow_master_network_id, SUM(netgrow_master_node_left) as left_node,
                    SUM(netgrow_master_node_right) AS right_node
                    FROM sys_netgrow_master 
                    WHERE YEAR(netgrow_master_date) = '".$year."'
                    GROUP BY netgrow_master_network_id
                )result
                WHERE left_node >= $node_left_condition AND right_node >= $node_right_condition
                
            ";

        $query = $this->db->query($sql);

        return $query;
    }

    function update_report_summary_bonus($arr_bonus) {
        
        foreach ($arr_bonus as $row) {
            $this->db->select_sum('bonus_' . $row['name'] . '_acc', $row['name'] . '_acc');
            $this->db->select_sum('bonus_' . $row['name'] . '_paid', $row['name'] . '_paid');
        }
        $query = $this->db->get('sys_bonus');
        if ($query->num_rows() > 0) {
            foreach ($arr_bonus as $bonus) {
                // check if it exist in report
                $old_bonus_name = $this->function_lib->get_one('report_summary_bonus', 'report_bonus_item_name', array('report_bonus_item_name'=>$bonus['name']));
                if (empty($old_bonus_name) OR $old_bonus_name == '') {
                    // then, insert
                    $ins['report_bonus_item_name'] = $bonus['name'];
                    $ins['report_bonus_item_label'] = $bonus['label'];
                    $ins['report_bonus_acc'] = $query->row($bonus['name'] . '_acc');
                    $ins['report_bonus_paid'] = $query->row($bonus['name'] . '_paid');
                    $this->db->insert('report_summary_bonus', $ins);
                } else {
                    // then, update
                    $upd['report_bonus_acc'] = $query->row($bonus['name'] . '_acc');
                    $upd['report_bonus_paid'] = $query->row($bonus['name'] . '_paid');
                    $this->db->update('report_summary_bonus', $upd, array('report_bonus_item_name'=>$bonus['name']));
                }
            }
        }
    }

    function update_bonus_saldo_periode($periode, $start_date, $end_date, $select) {
        $this->db->where("bonus_log_date BETWEEN '{$start_date}' AND '{$end_date}'");
        $this->db->select('bonus_log_network_id, ' . $select);
        $query = $this->db->get('sys_bonus_log');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $bonus_log) {
                /* UPDATE bonus_[daily|weekly|monthly]_saldo */
                $data = array();
                $data['bonus_' . $periode . '_saldo'] = $bonus_log[$periode . '_bonus'];
                $this->function_lib->update_data('sys_bonus', 'bonus_network_id', $bonus_log['bonus_log_network_id'], $data);
            }
        }
    }

}

?>