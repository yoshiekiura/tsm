<?php

/*
 * Backend Bonus Transfer Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_bonus_transfer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_query_preview_data($category, $params, $count = false) {
        $this->config->load('transfer');
        $arr_all_transfer_config = $this->config->item('transfer');
        $arr_transfer_config = $arr_all_transfer_config[$category];
        $arr_bonus = $arr_transfer_config['arr_bonus'];
        
        //string untuk select jenis bonus & total bonus
        $str_select = "";
        // $str_select_sum = "";
        // $str_total_bonus = "";
        if(is_array($arr_bonus)) {
            // $str_total_bonus = "(";
            foreach($arr_bonus as $bonus_item) {
                $str_select .= 'bonus_' . $bonus_item . '_saldo AS bonus_' . $bonus_item . ', ';
                // $str_select .= "(IFNULL(bonus_log_" . $bonus_item . ", 0)) AS bonus_" . $bonus_item . ", ";
                // $str_total_bonus .= "SUM(bonus_" . $bonus_item . ") + ";
                // $str_select_sum .= "SUM(bonus_" . $bonus_item . ") AS bonus_" . $bonus_item . ", ";
            }
            // $str_total_bonus = rtrim($str_total_bonus, ' + ');
            // $str_total_bonus .= ") AS bonus_total";
            // $str_select_sum .= $str_total_bonus;
        }
        $str_select .= "bonus_{$category}_saldo AS bonus_total, bonus_network_id";
        
        //string untuk select hitungan potongan administrasi & nett transfer
        $str_select_adm_charge = "";
        if($arr_transfer_config['adm_charge_type'] == 'percent') {
            $str_select_adm_charge = "
                " . $arr_transfer_config['adm_charge'] . " AS adm_charge_percent, 
                CAST(((" . $arr_transfer_config['adm_charge'] . " / 100) * bonus_total) AS UNSIGNED) AS adm_charge, 
                CAST((bonus_total - ((" . $arr_transfer_config['adm_charge'] . " / 100)) * bonus_total) AS UNSIGNED) AS nett 
            ";
        } else {
            $str_select_adm_charge = "
                0 AS adm_charge_percent, 
                CAST(" . $arr_transfer_config['adm_charge'] . " AS UNSIGNED) AS adm_charge, 
                CAST((bonus_total - " . $arr_transfer_config['adm_charge'] . ") AS UNSIGNED) AS nett 
            ";
        }
        
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
                bank_id AS member_bank_id, 
                bank_name AS member_bank_name, 
                member_bank_city, 
                member_bank_branch, 
                member_bank_account_name, 
                member_bank_account_no, 
                result.*, 
                $str_select_adm_charge 
                FROM
                (
                    SELECT $str_select
                    FROM sys_bonus
                    WHERE 
                    bonus_{$category}_saldo >= " . $arr_transfer_config['bonus_min'] . "
                ) result
                INNER JOIN sys_network ON network_id = bonus_network_id 
                INNER JOIN sys_member ON member_network_id = network_id 
                INNER JOIN sys_member_bank ON member_bank_network_id = network_id 
                INNER JOIN ref_bank ON bank_id = member_bank_bank_id 
                WHERE member_is_active = '1' 
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
    
    function get_query_preview_detail_data($category, $network_id, $params, $count = false) {
        $this->config->load('transfer');
        $arr_all_transfer_config = $this->config->item('transfer');
        $arr_transfer_config = $arr_all_transfer_config[$category];
        $arr_bonus = $arr_transfer_config['arr_bonus'];
        
        //string untuk select jenis bonus & total bonus
        $str_select = "";
        $str_total_bonus = "";
        if(is_array($arr_bonus)) {
            $str_total_bonus = "(";
            foreach($arr_bonus as $bonus_item) {
                $str_select .= "(IFNULL(bonus_log_" . $bonus_item . ", 0)) AS bonus_" . $bonus_item . ", ";
                $str_total_bonus .= "bonus_" . $bonus_item . " + ";
            }
            $str_total_bonus = rtrim($str_total_bonus, ' + ');
            $str_total_bonus .= ") AS bonus_total";
        }
        $str_select = rtrim($str_select, ", ");
        
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
                bank_id AS member_bank_id, 
                bank_name AS member_bank_name, 
                member_bank_city, 
                member_bank_branch, 
                member_bank_account_name, 
                member_bank_account_no, 
                result.*, 
                $str_total_bonus 
                FROM
                (
                    SELECT bonus_log_id, 
                    bonus_log_network_id, 
                    $str_select 
                    FROM sys_bonus_log 
                    WHERE bonus_log_network_id = '" . $network_id . "' 
                    AND bonus_" . $category ."_is_transfered = 0
                    GROUP BY bonus_log_id 
                ) result
                INNER JOIN sys_network ON network_id = bonus_log_network_id 
                INNER JOIN sys_member ON member_network_id = network_id 
                INNER JOIN sys_member_bank ON member_bank_network_id = network_id 
                INNER JOIN ref_bank ON bank_id = member_bank_bank_id 
            ) result 
            $where AND bonus_total > 0 $sort $limit
        ";
        $query = $this->db->query($sql);
        
        if($count) {
            $row = $query->row();
            return $row->row_count;
        } else {
            return $query;
        }
    }
    
    function get_list_bonus_transfer_by_datetime($datetime = '', $params = array(), $count = false) {
        
        //string untuk select jenis bonus
        $arr_bonus = $this->mlm_function->get_arr_transfer_bonus_active($datetime);
        $str_select = "";
        if(is_array($arr_bonus)) {
            foreach($arr_bonus as $bonus_item) {
                $str_select .= "SUM(bonus_transfer_detail_" . $bonus_item . ") AS bonus_transfer_detail_" . $bonus_item . ", ";
            }
        }
        $str_select = rtrim($str_select, ", ");
        
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT network_id, 
                network_code, 
                member_name, 
                member_nickname, 
                result.* 
                FROM 
                (
                    SELECT sys_bonus_transfer.*, 
                    (
                        CASE bonus_transfer_status 
                        WHEN 'pending' THEN 'PENDING' 
                        WHEN 'failed' THEN 'GAGAL' 
                        WHEN 'success' THEN 'SUKSES' 
                        ELSE '-'
                        END
                    ) AS bonus_transfer_status_label, 
                    $str_select
                    FROM sys_bonus_transfer 
                    INNER JOIN sys_bonus_transfer_detail ON bonus_transfer_detail_bonus_transfer_id = bonus_transfer_id 
                    WHERE bonus_transfer_datetime = '" . $datetime . "'
                    GROUP BY bonus_transfer_id
                ) result 
                INNER JOIN sys_network ON network_id = bonus_transfer_network_id 
                INNER JOIN sys_member ON member_network_id = network_id 
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

    
    function get_list_bonus_transfer_pending_by_datetime($datetime = '', $params = array(), $count = false) {
        
        //string untuk select jenis bonus
        $arr_bonus = $this->mlm_function->get_arr_transfer_bonus_active($datetime);
        $str_select = "";
        if(is_array($arr_bonus)) {
            foreach($arr_bonus as $bonus_item) {
                $str_select .= "SUM(bonus_transfer_detail_" . $bonus_item . ") AS bonus_transfer_detail_" . $bonus_item . ", ";
            }
        }
        $str_select = rtrim($str_select, ", ");
        
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT network_id, 
                network_code, 
                member_name, 
                member_nickname, 
                result.* 
                FROM 
                (
                    SELECT sys_bonus_transfer.*, 
                    (
                        CASE bonus_transfer_status 
                        WHEN 'pending' THEN 'PENDING' 
                        WHEN 'failed' THEN 'GAGAL' 
                        WHEN 'success' THEN 'SUKSES' 
                        ELSE '-'
                        END
                    ) AS bonus_transfer_status_label, 
                    $str_select
                    FROM sys_bonus_transfer 
                    INNER JOIN sys_bonus_transfer_detail ON bonus_transfer_detail_bonus_transfer_id = bonus_transfer_id 
                    WHERE bonus_transfer_datetime = '" . $datetime . "' AND bonus_transfer_status = 'pending'
                    GROUP BY bonus_transfer_id
                ) result 
                INNER JOIN sys_network ON network_id = bonus_transfer_network_id 
                INNER JOIN sys_member ON member_network_id = network_id 
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

    function get_transfer_detail_data($transfer_id){
        $sql = "SELECT bonus_transfer_detail_bonus_log_id 
            FROM sys_bonus_transfer_detail
            WHERE bonus_transfer_detail_bonus_transfer_id = $transfer_id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function update_bonus_saldo($data, $network_id) {
        foreach ($data as  $item => $value) {
            $this->db->set($item, $value, FALSE);
        }
        $this->db->where('bonus_network_id', $network_id);
        $this->db->update('sys_bonus');
    }

    public function get_sum_bonus_detail($category, $transfer_id) {
        $arr_all_transfer_config = $this->config->item('transfer');
        $arr_bonus = $arr_all_transfer_config[$category]['arr_bonus'];
        $str_select = '';
        foreach ($arr_bonus as $bonus_item) {
            $str_select .= 'IFNULL(SUM(bonus_transfer_detail_' . $bonus_item . '), 0) as bonus_' . $bonus_item . ', ';
        }
        $str_select = rtrim($str_select, ", ");
        $sql = "SELECT $str_select 
            FROM sys_bonus_transfer_detail
            WHERE bonus_transfer_detail_bonus_transfer_id = $transfer_id";

        $query = $this->db->query($sql);
        return $query;
    }

    /* Duplicated From Cron Model */
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
    
}
