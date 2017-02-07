<?php

/*
 * Backend Report Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service_reward extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('report/backend_report_model');
        $this->load->helper('form');
    }

    function index() {
        // do nothing
    }

    function get_reward_log_data_service() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->get_member_reward_data($params);
        $total = $this->get_member_reward_data($params, true);

        header("Content-type: application/json");
        // print_r(json_encode($query->result()));die();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        $administrator = array('-'=>'-');
        foreach ($query->result() as $row) {
            
            //status
            if ($row->reward_qualified_status == 'approved') {
                $status = '<span class="btn btn-success" style="width:80px; padding:2px 5px !important; font-size:7pt; cursor:default;">' . strtoupper($row->reward_qualified_status) . '</span>';
            } else if($row->reward_qualified_status == 'rejected') {
                $status = '<span class="btn btn-danger" style="width:80px; padding:2px 5px !important; font-size:7pt; cursor:default;">' . strtoupper($row->reward_qualified_status) . '</span>';
            } else {
                $status = '<span class="btn btn-warning" style="width:80px; padding:2px 5px !important; font-size:7pt; cursor:default;">' . strtoupper($row->reward_qualified_status) . '</span>';
            }

            if ( ! isset($administrator[$row->administrator_id])) {
                $administrator[$row->administrator_id] = $row->administrator_name;
            }
            
            $entry = array('id' => $row->reward_qualified_id,
                'cell' => array(
                    'no' => $page++,
                    'network_code' => $row->network_code,
                    'member_name' => $row->member_name,
                    'reward_cond_node_left' => $this->function_lib->set_number_format($row->reward_cond_node_left),
                    'reward_cond_node_right' => $this->function_lib->set_number_format($row->reward_cond_node_right),
                    'reward_qualified_condition_node_left' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_left),
                    'reward_qualified_condition_node_right' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_right),
                    'reward_qualified_reward_bonus' => $row->reward_qualified_reward_bonus,
                    'reward_qualified_status' => $status,
                    'reward_qualified_status_raw' => $row->reward_qualified_status,
                    'reward_qualified_date' => convert_date($row->reward_qualified_date, 'id'),
                    'claim_datetime' => date_converter($row->claim_datetime, 'd F Y H:i:s'),
                    'process_date' => (($row->process_date != '-') ? date_converter($row->process_date, 'd F Y H:i:s') : '-'),
                    'administrator_name' => $administrator[$row->administrator_id],
                ),
            );
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
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
}