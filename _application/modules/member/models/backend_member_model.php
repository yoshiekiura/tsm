<?php

/*
 * Backend Member Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_member_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_detail($id) {
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

    function check_username($username, $id = 0) {
        $sql = "SELECT 1 FROM sys_member_account WHERE member_account_username = '" . $username . "' AND member_account_network_id != '" . $id . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function get_list_member_group($parent_group_network_id) {
        $sql_network_group = "
            SELECT network_id, 
            network_code 
            FROM sys_network_group 
            INNER JOIN sys_network ON network_id = network_group_member_network_id 
            WHERE network_group_parent_network_id = '" . $parent_group_network_id . "' 
            AND network_group_is_approve = '1'
        ";
        return $this->db->query($sql_network_group);
    }

}

?>