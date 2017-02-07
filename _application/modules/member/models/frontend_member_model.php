<?php

/*
 * Frontend Member Model
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class frontend_member_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_new_member($limit) {
        $this->db->select("network_code, member_name, member_city_id, member_detail_image, DATE_FORMAT(member_join_datetime, '%M %D, %Y') AS member_join_date", false);
        $this->db->from('sys_network');
        $this->db->join('sys_member','member_network_id=network_id','left');
        $this->db->join('sys_member_detail','member_detail_network_id=network_id','left');
        $this->db->where('member_is_active', '1');
        $this->db->order_by('member_join_datetime', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get();
    }
    
    function get_top_income($limit) {
        $bonus = '';
        $c=1;
        $arr_bonus = $this->mlm_function->get_arr_active_bonus();
        foreach($arr_bonus as $val_bonus){
            $bonus .= 'bonus_log_'.$val_bonus['name'];
            if($c<count($arr_bonus)) $bonus .=' + ';
            $c++;
        }
        $this->db->select("network_code, member_name, member_city_id, member_detail_image, DATE_FORMAT(member_join_datetime, '%M %D, %Y') AS member_join_date", false);
        $this->db->from('sys_network');
        $this->db->join('sys_member','member_network_id=network_id','left');
        $this->db->join('sys_member_detail','member_detail_network_id=network_id','left');
        $this->db->join('sys_bonus_log','bonus_log_id=network_id','left');
        $this->db->where('member_is_active', '1');
        $this->db->where($bonus.' >', '0');
        $this->db->group_by('network_id');
        $this->db->order_by("SUM({$bonus})", 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get();
    }
    
    function get_top_sponsor($limit) {
        $this->db->select("network_code, member_name, member_city_id, member_detail_image, DATE_FORMAT(member_join_datetime, '%M %D, %Y') AS member_join_date", false);
        $this->db->from('sys_network');
        $this->db->join('sys_member','member_network_id=network_id','left');
        $this->db->join('sys_member_detail','member_detail_network_id=network_id','left');
        $this->db->join('sys_netgrow_sponsor','netgrow_sponsor_network_id=network_id','left');
        $this->db->where('member_is_active', '1');
        $this->db->group_by('network_id');
        $this->db->order_by("COUNT(netgrow_sponsor_id)", 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get();
    }
    
    function get_total_member($date = '') {
        if(!empty($date)) $this->db->where('DATE(member_join_datetime)', $date);
        $this->db->from('sys_member');
        
        return $this->db->count_all_results();
    }
}

?>
