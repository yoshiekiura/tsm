<?php

/*
 * Backend Reward Model
 *
 * @author	Hanan Kusuma
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_reward_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_data_member_reward($params, $count = false) {
        $params['where_detail'] = "member_is_active != '0' AND reward_qualified_status = 'pending' ";
        $params['join'] = "
                INNER JOIN sys_network ON reward_qualified_network_id = network_id
                INNER JOIN sys_member ON reward_qualified_network_id = member_network_id
        ";
        $params['table'] = 'sys_reward_qualified';
        $query = $this->function_lib->get_query_data($params, $count);

        $total = 0;
        $prev_network_id = '';
        $max_reward_to_approve = 0;
        $reward_list = array();

        foreach ($query->result() as $row) {

            $entry = array(
                'id' => $row->reward_qualified_id,
                'reward_qualified_id' => $row->reward_qualified_id,
                'network_code' => $row->network_code,
                'member_name' => $row->member_name,
                'reward_qualified_reward_bonus' => $row->reward_qualified_reward_bonus,
                'member_mobilephone' => $row->member_mobilephone,
                'reward_qualified_date' => convert_date($row->reward_qualified_date, 'id'),
                'reward_qualified_reward_value' => number_format($row->reward_qualified_reward_value)
            );

            $reward_list[] = (object) $entry;
            $total++;
        }
        
        if($count){
            return $total;
        }else{
            return $reward_list;
        }

    }

    function get_member_reward_data($params, $count=false) {
        extract($this->function_lib->get_query_condition($params, $count));
        if ($count) {
            $parent_select = "COUNT(*) AS row_count";
        } else {
            $parent_select = "*";
        }
        $sql = "SELECT
            $parent_select
            FROM (
                SELECT 
                    *,
                    IF(reward_qualified_status = 'pending', '-', status_datetime) as process_date,
                    IF(reward_qualified_status = 'pending', '-', status_administrator_id) as administrator_id,
                    IF(reward_qualified_status = 'pending', '-', status_administrator_name) as administrator_name
                    FROM (
                    SELECT 
                        sys_member.member_name, 
                        sys_network.network_code, 
                        sys_reward.*,
                        sys_reward_qualified.*,
                        (   
                         SELECT reward_qualified_status_datetime FROM sys_reward_qualified_status
                         WHERE reward_qualified_status_reward_qualified_id = reward_qualified_id
                         ORDER BY reward_qualified_status_id ASC LIMIT 1
                        ) as claim_datetime,
                        (   
                         SELECT reward_qualified_status_datetime FROM sys_reward_qualified_status
                         WHERE reward_qualified_status_reward_qualified_id = reward_qualified_id
                         ORDER BY reward_qualified_status_id DESC LIMIT 1
                        ) as status_datetime,
                        (   
                         SELECT reward_qualified_status_administrator_id FROM sys_reward_qualified_status
                         WHERE reward_qualified_status_reward_qualified_id = reward_qualified_id
                         ORDER BY reward_qualified_status_id DESC LIMIT 1
                        ) as status_administrator_id,
                        (   
                         SELECT reward_qualified_status_administrator_name FROM sys_reward_qualified_status
                         WHERE reward_qualified_status_reward_qualified_id = reward_qualified_id
                         ORDER BY reward_qualified_status_id DESC LIMIT 1
                        ) as status_administrator_name
                        FROM sys_reward_qualified
                        INNER JOIN sys_reward ON reward_qualified_reward_id = reward_id
                        INNER JOIN sys_network ON network_id = reward_qualified_network_id
                        INNER JOIN sys_member ON member_network_id = reward_qualified_network_id
                    ) as result
            ) as results
            $where 
            $group_by 
            $sort
            $limit
        ";

        $query = $this->db->query($sql);
        
        if($count) {
            $row = $query->row();
            return $row->row_count;
        } else {
            return $query;
        }

    }

    // public function get_reward_info($reward_id, $count = 'false') {
    //     $select = 'member_name, reward_type_id, reward_name, network_code,
    //                member_mobilephone, reward_qualified_network_id,
    //                reward_qualified_reward_value ,
    //                bank_name, member_bank_account_no, member_detail_sex,
    //                reward_qualified_reward_nett_value';
    //     $this->db->select($select);
    //     $this->db->where('reward_qualified_id', $reward_id);
    //     $this->db->join('sys_reward', 'reward_id = reward_qualified_reward_id', 'inner');
    //     $this->db->join('sys_member', 'member_network_id = reward_qualified_network_id', 'inner');
    //     $this->db->join('sys_member_bank', 'member_bank_network_id = reward_qualified_network_id', 'inner');
    //     $this->db->join('sys_member_detail', 'member_detail_network_id = reward_qualified_network_id', 'inner');
    //     $this->db->join('sys_network', 'network_id = reward_qualified_network_id', 'inner');
    //     $this->db->join('ref_bank', 'bank_id = member_bank_bank_id', 'inner');

    //     $query = $this->db->get('sys_reward_qualified');

    //     return $query->row();
    // }


}
