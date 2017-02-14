<?php

/**
 * Description of frontend_reward_model
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
    
    function get_reward_info($reward_id) {
        $this->db->select('*');
        $this->db->where('reward_id',$reward_id);
        return $this->db->get('sys_reward');
    }

    function get_member_qualified_reward($reward_id, $offset = FALSE, $limit = FALSE, $count = FALSE) {
        
        if ($count == TRUE) {
            $this->db->select('COUNT(*) as total');
            $this->db->where('reward_qualified_reward_id', $reward_id);
            $this->db->where('reward_qualified_status', 'approved');
            $q = $this->db->get('sys_reward_qualified');
            return $q->row('total');
        } else {
            $this->db->select('member_name, reward_qualified_date as tanggal_claim');
            $this->db->where('reward_qualified_reward_id', $reward_id);
            $this->db->where('reward_qualified_status', 'approved');
            $this->db->join('sys_member', 'member_network_id = reward_qualified_network_id');
            $this->db->order_by('reward_qualified_date', 'desc');
            $this->db->offset($offset);
            $this->db->limit($limit);
            $q = $this->db->get('sys_reward_qualified');
            if ($q->num_rows() > 0) {
                return $q->result();
            } else {
                return array(); 
            }
        }

    }

}
