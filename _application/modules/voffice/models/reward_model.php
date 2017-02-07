<?php

/*
 * Member Reward Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Reward_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_query_data($network_id, $params, $count = false) {
        
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT reward_id, 
                reward_cond_node_left, 
                reward_cond_node_right, 
                reward_bonus 
                FROM sys_reward 
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
    
    function get_arr_node($network_id, $year = '') {
        if($year == '') {
            $year = date('Y');
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
        ";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            
            $arr_node['left'] = $row->node_left;
            $arr_node['right'] = $row->node_right;
        }
        
        return $arr_node;
    }

    function get_member_reward_data($network_id, $params, $count=false) {
        extract($this->function_lib->get_query_condition($params, $count));
        if ($count) {
            $parent_select = "COUNT(*) AS row_count";
        } else {
            $parent_select = "*, 
            IF(reward_qualified_status = 'pending', '-', status_datetime) as process_date,
            IF(reward_qualified_status = 'pending', '-', status_administrator_id) as administrator_id,
            IF(reward_qualified_status = 'pending', '-', status_administrator_name) as administrator_name
            ";
        }
        $sql = "SELECT
            $parent_select
            FROM (
                SELECT *,
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
                WHERE reward_qualified_network_id = ".$network_id."
            )as result
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

}
