<?php

/*
 * Cron Common Model
 *
 * @author	Yudha Wirawan Sakti
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Cron_peringkat_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_network_id() {
        $sql = "SELECT network_id FROM sys_network";
        $query = $this->db->query($sql);
        $row = $query->row();
        $network_id = $row->network_id;
        return $network_id;
    }
    
    function get_count_member($date, $id) {
        $sql = "SELECT IFNULL(COUNT(profit_sharing_grade_network_id) ,0) AS count_grade FROM (
                SELECT profit_sharing_grade_network_id, MAX(profit_sharing_grade_profit_sharing_grade_title_id) AS top_grade_id
                FROM sys_profit_sharing_grade WHERE LEFT(profit_sharing_grade_date, 7) = '".$date."'
                GROUP BY profit_sharing_grade_network_id
                )result WHERE top_grade_id =".$id."";
        $query = $this->db->query($sql);
        $row = $query->row();
        $count_grade = $row->count_grade;
        return $count_grade;
    }

    function insert_network_code($data) {
        $this->db->insert('sys_stock_network_code', $data);
    }
    
    function insert_log($data) {
        $this->db->insert('cron_log', $data);
    }
    
    function get_member_qualified_sl() {
        $sql = "
                SELECT netgrow_sponsor_network_id, count(netgrow_sponsor_downline_network_id) AS count_sponsoring
                FROM sys_netgrow_sponsor
                INNER JOIN sys_profit_sharing_qualified_status ON profit_sharing_qualified_status_network_id = netgrow_sponsor_network_id 
                AND profit_sharing_qualified_status_is_qualified = 0               
                GROUP BY netgrow_sponsor_network_id
                HAVING count_sponsoring >=4
            ";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    function get_arr_grade(){
        $sql = "
                SELECT profit_sharing_grade_title_id, profit_sharing_grade_title_code 
                FROM sys_profit_sharing_grade_title
                WHERE profit_sharing_grade_title_is_active
            ";
        $query = $this->db->query($sql) ;
        
        return $query;
    }

}

?>