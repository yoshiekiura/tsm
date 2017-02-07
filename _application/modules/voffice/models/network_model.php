<?php

/*
 * Member Network Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Network_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_detail_member($id) {
        $sql = "
            SELECT main_network.*, 
            (
                CASE main_network.network_position 
                WHEN 'L' THEN 'Kiri' 
                WHEN 'R' THEN 'Kanan' 
                ELSE '-'
                END
            ) AS network_position_text, 
            main_member.*, 
            (
                CASE main_member_detail.member_detail_sex 
                WHEN 'male' THEN 'Pria' 
                WHEN 'female' THEN 'Wanita' 
                ELSE '-'
                END
            ) AS member_detail_sex_text, 
            main_member_detail.*, 
            main_member_bank.*, 
            main_member_devisor.*, 
            main_member_account.*, 
            main_serial.*, 
            main_city.city_id AS member_city_id, 
            main_city.city_name AS member_city_name, 
            main_city.province_id AS member_province_id, 
            main_city.province_name AS member_province_name, 
            main_city.region_id AS member_region_id, 
            main_city.region_name AS member_region_name, 
            main_country.country_id AS member_country_id, 
            main_country.country_name AS member_country_name, 
            main_bank.bank_id AS member_bank_id, 
            main_bank.bank_name AS member_bank_name, 
            IFNULL(sponsor_network.network_id, 0) AS sponsor_network_id, 
            IFNULL(sponsor_network.network_code, '-') AS sponsor_network_code, 
            IFNULL(sponsor_member.member_name, '-') AS sponsor_member_name, 
            IFNULL(sponsor_member.member_nickname, '-') AS sponsor_member_nickname, 
            IFNULL(upline_network.network_id, 0) AS upline_network_id, 
            IFNULL(upline_network.network_code, '-') AS upline_network_code, 
            IFNULL(upline_member.member_name, '-') AS upline_member_name, 
            IFNULL(upline_member.member_nickname, '-') AS upline_member_nickname 
            FROM sys_network main_network 
            INNER JOIN sys_member main_member ON member_network_id = main_network.network_id 
            LEFT JOIN view_city main_city ON main_city.city_id = main_member.member_city_id 
            LEFT JOIN ref_country main_country ON main_country.country_id = main_member.member_country_id 
            INNER JOIN sys_member_detail main_member_detail ON main_member_detail.member_detail_network_id = main_network.network_id 
            INNER JOIN sys_member_bank main_member_bank ON main_member_bank.member_bank_network_id = main_network.network_id 
            LEFT JOIN ref_bank main_bank ON main_bank.bank_id = main_member_bank.member_bank_bank_id 
            INNER JOIN sys_member_devisor main_member_devisor ON main_member_devisor.member_devisor_network_id = main_network.network_id 
            INNER JOIN sys_member_account main_member_account ON main_member_account.member_account_network_id = main_network.network_id 
            INNER JOIN sys_serial_user main_serial_user ON main_serial_user.serial_user_network_id = main_network.network_id 
            INNER JOIN sys_serial main_serial ON main_serial.serial_id = main_serial_user.serial_user_serial_id 
            LEFT JOIN sys_network sponsor_network ON sponsor_network.network_id = main_network.network_sponsor_network_id 
            LEFT JOIN sys_member sponsor_member ON sponsor_member.member_network_id = sponsor_network.network_id 
            LEFT JOIN sys_network upline_network ON upline_network.network_id = main_network.network_upline_network_id 
            LEFT JOIN sys_member upline_member ON upline_member.member_network_id = upline_network.network_id 
            WHERE main_network.network_id = '" . $id . "'
        ";
        return $this->db->query($sql);
    }
    
    function get_query_netgrow_node_data($network_id, $params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT netgrow_node_id, 
                netgrow_node_level, 
                netgrow_node_position, 
                (
                    CASE netgrow_node_position 
                    WHEN 'L' THEN 'Kiri' 
                    WHEN 'R' THEN 'Kanan' 
                    ELSE '-'
                    END
                ) AS netgrow_node_position_text, 
                netgrow_node_date, 
                downline_network.network_id AS downline_network_id, 
                downline_network.network_code AS downline_network_code, 
                downline_network.network_left_node_network_id AS downline_frontline_left_network_id, 
                IFNULL(frontline_left_network.network_code, '-') AS downline_frontline_left_network_code, 
                downline_network.network_right_node_network_id AS downline_frontline_right_network_id, 
                IFNULL(frontline_right_network.network_code, '-') AS downline_frontline_right_network_code, 
                downline_member.member_name AS downline_member_name, 
                downline_member.member_nickname AS downline_member_nickname, 
                downline_member.member_phone AS downline_member_phone, 
                downline_member.member_mobilephone AS downline_member_mobilephone, 
                downline_member.member_join_datetime AS downline_member_join_datetime, 
                downline_member.member_is_active AS downline_member_is_active, 
                downline_city.city_id AS downline_member_city_id, 
                downline_city.city_name AS downline_member_city_name, 
                downline_city.province_id AS downline_member_province_id, 
                downline_city.province_name AS downline_member_province_name, 
                downline_city.region_id AS downline_member_region_id, 
                downline_city.region_name AS downline_member_region_name, 
                downline_country.country_id AS downline_member_country_id, 
                IFNULL(downline_country.country_name, '-') AS downline_member_country_name 
                FROM sys_netgrow_node 
                INNER JOIN sys_network downline_network ON downline_network.network_id = netgrow_node_downline_network_id 
                INNER JOIN sys_member downline_member ON downline_member.member_network_id = downline_network.network_id 
                LEFT JOIN view_city downline_city ON downline_city.city_id = downline_member.member_city_id 
                LEFT JOIN ref_country downline_country ON downline_country.country_id = downline_member.member_country_id 
                LEFT JOIN sys_network frontline_left_network ON frontline_left_network.network_id = downline_network.network_left_node_network_id 
                LEFT JOIN sys_network frontline_right_network ON frontline_right_network.network_id = downline_network.network_right_node_network_id 
                WHERE netgrow_node_network_id = '" . $network_id . "'
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
    
    function get_query_netgrow_sponsor_data($network_id, $params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT netgrow_sponsor_id, 
                netgrow_sponsor_level, 
                netgrow_sponsor_position, 
                (
                    CASE netgrow_sponsor_position 
                    WHEN 'L' THEN 'Kiri' 
                    WHEN 'R' THEN 'Kanan' 
                    ELSE '-'
                    END
                ) AS netgrow_sponsor_position_text, 
                netgrow_sponsor_date, 
                downline_network.network_id AS downline_network_id, 
                downline_network.network_code AS downline_network_code, 
                downline_network.network_left_node_network_id AS downline_frontline_left_network_id, 
                IFNULL(frontline_left_network.network_code, '-') AS downline_frontline_left_network_code, 
                downline_network.network_right_node_network_id AS downline_frontline_right_network_id, 
                IFNULL(frontline_right_network.network_code, '-') AS downline_frontline_right_network_code, 
                downline_member.member_name AS downline_member_name, 
                downline_member.member_nickname AS downline_member_nickname, 
                downline_member.member_phone AS downline_member_phone, 
                downline_member.member_mobilephone AS downline_member_mobilephone, 
                downline_member.member_join_datetime AS downline_member_join_datetime, 
                downline_member.member_is_active AS downline_member_is_active, 
                downline_city.city_id AS downline_member_city_id, 
                downline_city.city_name AS downline_member_city_name, 
                downline_city.province_id AS downline_member_province_id, 
                downline_city.province_name AS downline_member_province_name, 
                downline_city.region_id AS downline_member_region_id, 
                downline_city.region_name AS downline_member_region_name, 
                downline_country.country_id AS downline_member_country_id, 
                IFNULL(downline_country.country_name, '-') AS downline_member_country_name 
                FROM sys_netgrow_sponsor 
                INNER JOIN sys_network downline_network ON downline_network.network_id = netgrow_sponsor_downline_network_id 
                INNER JOIN sys_member downline_member ON downline_member.member_network_id = downline_network.network_id 
                LEFT JOIN view_city downline_city ON downline_city.city_id = downline_member.member_city_id 
                LEFT JOIN ref_country downline_country ON downline_country.country_id = downline_member.member_country_id 
                LEFT JOIN sys_network frontline_left_network ON frontline_left_network.network_id = downline_network.network_left_node_network_id 
                LEFT JOIN sys_network frontline_right_network ON frontline_right_network.network_id = downline_network.network_right_node_network_id 
                WHERE netgrow_sponsor_network_id = '" . $network_id . "'
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
    
    function get_query_netgrow_match_data($network_id, $params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT netgrow_match_id, 
                netgrow_match_value, 
                netgrow_match_date 
                FROM sys_netgrow_match 
                WHERE netgrow_match_network_id = '" . $network_id . "'
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
    
    function get_query_netgrow_gen_node_data($network_id, $params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT netgrow_gen_node_id, 
                netgrow_gen_node_level, 
                netgrow_gen_node_date, 
                downline_network.network_id AS downline_network_id, 
                downline_network.network_code AS downline_network_code, 
                downline_network.network_left_node_network_id AS downline_frontline_left_network_id, 
                IFNULL(frontline_left_network.network_code, '-') AS downline_frontline_left_network_code, 
                downline_network.network_right_node_network_id AS downline_frontline_right_network_id, 
                IFNULL(frontline_right_network.network_code, '-') AS downline_frontline_right_network_code, 
                downline_member.member_name AS downline_member_name, 
                downline_member.member_nickname AS downline_member_nickname, 
                downline_member.member_phone AS downline_member_phone, 
                downline_member.member_mobilephone AS downline_member_mobilephone, 
                downline_member.member_join_datetime AS downline_member_join_datetime, 
                downline_member.member_is_active AS downline_member_is_active, 
                downline_city.city_id AS downline_member_city_id, 
                downline_city.city_name AS downline_member_city_name, 
                downline_city.province_id AS downline_member_province_id, 
                downline_city.province_name AS downline_member_province_name, 
                downline_city.region_id AS downline_member_region_id, 
                downline_city.region_name AS downline_member_region_name, 
                downline_country.country_id AS downline_member_country_id, 
                IFNULL(downline_country.country_name, '-') AS downline_member_country_name 
                FROM sys_netgrow_gen_node 
                INNER JOIN sys_network downline_network ON downline_network.network_id = netgrow_gen_node_downline_network_id 
                INNER JOIN sys_member downline_member ON downline_member.member_network_id = downline_network.network_id 
                LEFT JOIN view_city downline_city ON downline_city.city_id = downline_member.member_city_id 
                LEFT JOIN ref_country downline_country ON downline_country.country_id = downline_member.member_country_id 
                LEFT JOIN sys_network frontline_left_network ON frontline_left_network.network_id = downline_network.network_left_node_network_id 
                LEFT JOIN sys_network frontline_right_network ON frontline_right_network.network_id = downline_network.network_right_node_network_id 
                WHERE netgrow_gen_node_network_id = '" . $network_id . "'
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
    
    function get_query_netgrow_gen_sponsor_data($network_id, $params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT netgrow_gen_sponsor_id, 
                netgrow_gen_sponsor_level, 
                netgrow_gen_sponsor_date, 
                downline_network.network_id AS downline_network_id, 
                downline_network.network_code AS downline_network_code, 
                downline_network.network_left_node_network_id AS downline_frontline_left_network_id, 
                IFNULL(frontline_left_network.network_code, '-') AS downline_frontline_left_network_code, 
                downline_network.network_right_node_network_id AS downline_frontline_right_network_id, 
                IFNULL(frontline_right_network.network_code, '-') AS downline_frontline_right_network_code, 
                downline_member.member_name AS downline_member_name, 
                downline_member.member_nickname AS downline_member_nickname, 
                downline_member.member_phone AS downline_member_phone, 
                downline_member.member_mobilephone AS downline_member_mobilephone, 
                downline_member.member_join_datetime AS downline_member_join_datetime, 
                downline_member.member_is_active AS downline_member_is_active, 
                downline_city.city_id AS downline_member_city_id, 
                downline_city.city_name AS downline_member_city_name, 
                downline_city.province_id AS downline_member_province_id, 
                downline_city.province_name AS downline_member_province_name, 
                downline_city.region_id AS downline_member_region_id, 
                downline_city.region_name AS downline_member_region_name, 
                downline_country.country_id AS downline_member_country_id, 
                IFNULL(downline_country.country_name, '-') AS downline_member_country_name 
                FROM sys_netgrow_gen_sponsor 
                INNER JOIN sys_network downline_network ON downline_network.network_id = netgrow_gen_sponsor_downline_network_id 
                INNER JOIN sys_member downline_member ON downline_member.member_network_id = downline_network.network_id 
                LEFT JOIN view_city downline_city ON downline_city.city_id = downline_member.member_city_id 
                LEFT JOIN ref_country downline_country ON downline_country.country_id = downline_member.member_country_id 
                LEFT JOIN sys_network frontline_left_network ON frontline_left_network.network_id = downline_network.network_left_node_network_id 
                LEFT JOIN sys_network frontline_right_network ON frontline_right_network.network_id = downline_network.network_right_node_network_id 
                WHERE netgrow_gen_sponsor_network_id = '" . $network_id . "'
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
    
    function get_query_netgrow_gen_match_data($network_id, $params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT netgrow_gen_match_id, 
                netgrow_gen_match_level, 
                netgrow_gen_match_date, 
                downline_network.network_id AS downline_network_id, 
                downline_network.network_code AS downline_network_code, 
                downline_network.network_left_node_network_id AS downline_frontline_left_network_id, 
                IFNULL(frontline_left_network.network_code, '-') AS downline_frontline_left_network_code, 
                downline_network.network_right_node_network_id AS downline_frontline_right_network_id, 
                IFNULL(frontline_right_network.network_code, '-') AS downline_frontline_right_network_code, 
                downline_member.member_name AS downline_member_name, 
                downline_member.member_nickname AS downline_member_nickname, 
                downline_member.member_phone AS downline_member_phone, 
                downline_member.member_mobilephone AS downline_member_mobilephone, 
                downline_member.member_join_datetime AS downline_member_join_datetime, 
                downline_member.member_is_active AS downline_member_is_active, 
                downline_city.city_id AS downline_member_city_id, 
                downline_city.city_name AS downline_member_city_name, 
                downline_city.province_id AS downline_member_province_id, 
                downline_city.province_name AS downline_member_province_name, 
                downline_city.region_id AS downline_member_region_id, 
                downline_city.region_name AS downline_member_region_name, 
                downline_country.country_id AS downline_member_country_id, 
                IFNULL(downline_country.country_name, '-') AS downline_member_country_name 
                FROM sys_netgrow_gen_match 
                INNER JOIN sys_network downline_network ON downline_network.network_id = netgrow_gen_match_downline_network_id 
                INNER JOIN sys_member downline_member ON downline_member.member_network_id = downline_network.network_id 
                LEFT JOIN view_city downline_city ON downline_city.city_id = downline_member.member_city_id 
                LEFT JOIN ref_country downline_country ON downline_country.country_id = downline_member.member_country_id 
                LEFT JOIN sys_network frontline_left_network ON frontline_left_network.network_id = downline_network.network_left_node_network_id 
                LEFT JOIN sys_network frontline_right_network ON frontline_right_network.network_id = downline_network.network_right_node_network_id 
                WHERE netgrow_gen_match_network_id = '" . $network_id . "'
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
    
    function get_query_netgrow_upline_sponsor_data($network_id, $params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT netgrow_upline_sponsor_id, 
                netgrow_upline_sponsor_date, 
                downline_network.network_id AS downline_network_id, 
                downline_network.network_code AS downline_network_code, 
                downline_network.network_left_node_network_id AS downline_frontline_left_network_id, 
                IFNULL(frontline_left_network.network_code, '-') AS downline_frontline_left_network_code, 
                downline_network.network_right_node_network_id AS downline_frontline_right_network_id, 
                IFNULL(frontline_right_network.network_code, '-') AS downline_frontline_right_network_code, 
                downline_member.member_name AS downline_member_name, 
                downline_member.member_nickname AS downline_member_nickname, 
                downline_member.member_phone AS downline_member_phone, 
                downline_member.member_mobilephone AS downline_member_mobilephone, 
                downline_member.member_join_datetime AS downline_member_join_datetime, 
                downline_member.member_is_active AS downline_member_is_active, 
                downline_city.city_id AS downline_member_city_id, 
                downline_city.city_name AS downline_member_city_name, 
                downline_city.province_id AS downline_member_province_id, 
                downline_city.province_name AS downline_member_province_name, 
                downline_city.region_id AS downline_member_region_id, 
                downline_city.region_name AS downline_member_region_name, 
                downline_country.country_id AS downline_member_country_id, 
                IFNULL(downline_country.country_name, '-') AS downline_member_country_name 
                FROM sys_netgrow_upline_sponsor 
                INNER JOIN sys_network downline_network ON downline_network.network_id = netgrow_upline_sponsor_downline_network_id 
                INNER JOIN sys_member downline_member ON downline_member.member_network_id = downline_network.network_id 
                LEFT JOIN view_city downline_city ON downline_city.city_id = downline_member.member_city_id 
                LEFT JOIN ref_country downline_country ON downline_country.country_id = downline_member.member_country_id 
                LEFT JOIN sys_network frontline_left_network ON frontline_left_network.network_id = downline_network.network_left_node_network_id 
                LEFT JOIN sys_network frontline_right_network ON frontline_right_network.network_id = downline_network.network_right_node_network_id 
                WHERE netgrow_upline_sponsor_network_id = '" . $network_id . "'
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
    
    function get_query_netgrow_upline_match_data($network_id, $params, $count = false) {
        extract($this->function_lib->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select 
            FROM 
            (
                SELECT netgrow_upline_match_id, 
                netgrow_upline_match_date, 
                downline_network.network_id AS downline_network_id, 
                downline_network.network_code AS downline_network_code, 
                downline_network.network_left_node_network_id AS downline_frontline_left_network_id, 
                IFNULL(frontline_left_network.network_code, '-') AS downline_frontline_left_network_code, 
                downline_network.network_right_node_network_id AS downline_frontline_right_network_id, 
                IFNULL(frontline_right_network.network_code, '-') AS downline_frontline_right_network_code, 
                downline_member.member_name AS downline_member_name, 
                downline_member.member_nickname AS downline_member_nickname, 
                downline_member.member_phone AS downline_member_phone, 
                downline_member.member_mobilephone AS downline_member_mobilephone, 
                downline_member.member_join_datetime AS downline_member_join_datetime, 
                downline_member.member_is_active AS downline_member_is_active, 
                downline_city.city_id AS downline_member_city_id, 
                downline_city.city_name AS downline_member_city_name, 
                downline_city.province_id AS downline_member_province_id, 
                downline_city.province_name AS downline_member_province_name, 
                downline_city.region_id AS downline_member_region_id, 
                downline_city.region_name AS downline_member_region_name, 
                downline_country.country_id AS downline_member_country_id, 
                IFNULL(downline_country.country_name, '-') AS downline_member_country_name 
                FROM sys_netgrow_upline_match 
                INNER JOIN sys_network downline_network ON downline_network.network_id = netgrow_upline_match_downline_network_id 
                INNER JOIN sys_member downline_member ON downline_member.member_network_id = downline_network.network_id 
                LEFT JOIN view_city downline_city ON downline_city.city_id = downline_member.member_city_id 
                LEFT JOIN ref_country downline_country ON downline_country.country_id = downline_member.member_country_id 
                LEFT JOIN sys_network frontline_left_network ON frontline_left_network.network_id = downline_network.network_left_node_network_id 
                LEFT JOIN sys_network frontline_right_network ON frontline_right_network.network_id = downline_network.network_right_node_network_id 
                WHERE netgrow_upline_match_network_id = '" . $network_id . "'
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

    function get_arr_node($network_id) {
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
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            
            $arr_node['left'] = $row->node_left;
            $arr_node['right'] = $row->node_right;
        }
        
        return $arr_node;
    }

}

?>