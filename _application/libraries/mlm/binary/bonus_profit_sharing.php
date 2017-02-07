<?php

/*
 * MLM Bonus Profit Sharing (GTL) Libraries
 *
 * @author  Hanan Kusuma
 * @copyright   Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Bonus_profit_sharing {

    var $CI = null;
    protected $db;
    protected $start_date;
    protected $end_date;
    protected $log_date;
    protected $bonus_value;
    protected $max_level;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();

        $this->bonus_alocation = 250000;
    }

    /*
     * Method untuk eksekusi bonus titik
     */

    public function execute() {
        $monthly_activation_total = $this->get_total_monthly_activation($this->start_date, $this->end_date);

        $data_sharing_index = array();

        for ($sp_level = 1; $sp_level <= $this->max_level; $sp_level++) {
            $bonus_index = $this->bonus_value[$sp_level];
            $count_member_by_level = $this->get_member_profit_sharing($sp_level, true);
            $data_member_by_level = $this->get_member_profit_sharing($sp_level);

            if ($count_member_by_level > 0) {
                $bonus_amount = floor($monthly_activation_total / $count_member_by_level) * $bonus_index * $this->bonus_alocation;

                if ($bonus_amount > 0) {
                    foreach ($data_member_by_level->result() as $row) {
                        $sql_check = "
                        SELECT 1 
                        FROM sys_bonus_log 
                        WHERE bonus_log_network_id = '" . $row->network_id . "' 
                        AND bonus_log_date = '" . $this->log_date . "'
                    ";

                        $query_check = $this->CI->db->query($sql_check);
                        if ($query_check->num_rows() > 0) {
                            $sql_update = "
                            UPDATE sys_bonus_log 
                            SET bonus_log_profit_sharing = bonus_log_profit_sharing + " . $bonus_amount . " 
                            WHERE bonus_log_network_id = '" . $row->network_id . "' 
                            AND bonus_log_date = '" . $this->log_date . "'
                        ";
                            $this->CI->db->query($sql_update);
                        } else {
                            $sql_insert = "
                            INSERT INTO sys_bonus_log 
                            SET bonus_log_network_id = '" . $row->network_id . "', 
                            bonus_log_profit_sharing = '" . $bonus_amount . "', 
                            bonus_log_date = '" . $this->log_date . "'
                        ";
                            $this->CI->db->query($sql_insert);
                        }


                        //Update  summary bonus nya
                        $this->update_summary_bonus($row->network_id, $bonus_amount);
                    }
                }
            }

            $data_sharing_index['profit_sharing_index_qualified_lv_' . $sp_level] = $count_member_by_level;
            $data_sharing_index['profit_sharing_index_percent_lv_' . $sp_level] = $bonus_index * 100;
            $data_sharing_index['profit_sharing_index_bonus_constanta'] = $this->bonus_alocation;
        }

        $data_sharing_index['profit_sharing_index_member_activation'] = $monthly_activation_total;
        $data_sharing_index['profit_sharing_index_date'] = $this->log_date;

        $this->CI->function_lib->insert_data('sys_profit_sharing_index', $data_sharing_index);
    }

    /* -------------------------------------------------------------------------
     * setter
     * -------------------------------------------------------------------------
     */

    public function set_start_date($start_date) {
        $this->start_date = $start_date;
        return $this;
    }

    public function set_end_date($end_date) {
        $this->end_date = $end_date;
        return $this;
    }

    public function set_log_date($log_date) {
        $this->log_date = $log_date;
        return $this;
    }

    public function set_bonus_value($bonus_value) {
        $this->bonus_value = $bonus_value;
        return $this;
    }

    public function set_max_level($max_level) {
        $this->max_level = $max_level;
        return $this;
    }

    function get_member_profit_sharing($grade_id, $count = false) {
        if ($count) {
            $str_select = "count(*) as total_member";
        } else {
            $str_select = "network_id, top_grade_id";
        }

        $sql = "
            SELECT $str_select
            FROM (
                SELECT profit_sharing_grade_network_id as network_id, 
                MAX(profit_sharing_grade_profit_sharing_grade_title_id) as top_grade_id
                FROM sys_profit_sharing_grade
                GROUP BY profit_sharing_grade_network_id
            )result
            WHERE top_grade_id = '$grade_id'
        ";

        $query = $this->CI->db->query($sql);

        if ($count) {
            $row = $query->row();
            return $row->total_member;
        } else {
            return $query;
        }
    }

    function get_total_monthly_activation($start_date, $end_date) {
        $sql = " SELECT count(network_id) as total_member
                FROM sys_network
                INNER JOIN sys_member ON member_network_id = network_id
                WHERE DATE(member_join_datetime) BETWEEN '" . $start_date . "' AND '" . $end_date . "'
         ";

        $query = $this->CI->db->query($sql);

        return $query->row()->total_member;
    }

    function update_summary_bonus($network_id, $amount) {
        $sql_check = "
                        SELECT 1 
                        FROM sys_bonus
                        WHERE bonus_network_id = '" . $network_id . "' 
                    ";

        $query_check = $this->CI->db->query($sql_check);
        if ($query_check->num_rows() > 0) {
            $sql_update_summary_bonus = "UPDATE sys_bonus 
                                    SET bonus_profit_sharing_acc = bonus_profit_sharing_acc + $amount
                                    WHERE bonus_network_id = $network_id
                                    ";
            $this->CI->db->query($sql_update_summary_bonus);
        }else {
            $sql_insert_summary_bonus = "INSERT INTO sys_bonus SET bonus_network_id = $network_id, bonus_profit_sharing_acc = $amount";
            $this->CI->db->query($sql_insert_summary_bonus);
        }
    }

}

?>