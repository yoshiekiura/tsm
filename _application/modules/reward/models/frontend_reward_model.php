<?php

/**
 * Description of frontend_bank_account_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_reward_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_reward_active() {        
        $this->db->where('reward_is_active', '1');
        $this->db->limit(10);
        return $this->db->get('sys_reward');
    }
    function get_reward_active_by_type($reward_type) {        
        $this->db->where('reward_is_active', '1');
        $this->db->where('reward_type_member_type', $reward_type);
        $this->db->join('sys_reward_type b','b.reward_type_id = a.reward_type_id');
        // $this->db->limit(10);
        return $this->db->get('sys_reward a');
    }

    function get_reward_active_by_id($reward_id) {        
        $this->db->where('reward_is_active', '1');
        $this->db->where('reward_type_id', $reward_id);
        // $this->db->join('sys_reward_type b','b.reward_type_id = a.reward_type_id');
        // $this->db->limit(10);
        return $this->db->get('sys_reward a');
    }
    
    function get_reward_info($reward_id) {
        $this->db->select('*');
        $this->db->where('reward_id',$reward_id);
        
        return $this->db->get('sys_reward');
    }
    
    function get_reward_member($id, $offset = 0, $limit = 20) {            

        $this->db->select(' reward_qualified_reward_bonus,reward_qualified_reward_value, reward_qualified_date as tanggal_reward,                
                member_name,network_code');
//        $this->db->where('reward_qualified_status_status = reward_qualified_status');
        $this->db->where('reward_qualified_reward_id',$id);
        $this->db->from('sys_reward_qualified');
        $this->db->join('sys_network','reward_qualified_network_id = network_id');
        $this->db->join('sys_member','reward_qualified_network_id = member_network_id');
//        $this->db->join('sys_reward_qualified_status','reward_qualified_status_reward_qualified_id = reward_qualified_id');        
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_member_qualified_reward($reward_type, $reward_id,$offset = '', $limit = '') {
        
        $this->db->select('member_name,reward_qualified_date as tanggal_reward');
        // $this->db->where('reward_type_member_type', $reward_type);
        $this->db->where('reward_id', $reward_id);
        $this->db->from('sys_reward_qualified');
        $this->db->join('sys_reward a','reward_qualified_reward_id = a.reward_id');
        $this->db->join('sys_reward_type b','b.reward_type_id = a.reward_type_id');
        $this->db->join('sys_member', 'member_network_id = reward_qualified_network_id');
        $this->db->order_by('tanggal_reward', 'desc');
        // if($limit != '' && $offset != '') {
            $this->db->offset($offset);
            $this->db->limit($limit);
        // }
        return $this->db->get();

    }
}

?>
