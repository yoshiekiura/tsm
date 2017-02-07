<?php

/*
 * Frontend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Frontend_partner_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_partner_list($offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(partner_input_datetime, '%M %D, %Y') AS partner_input_date", false);
        $this->db->from('site_partner');
        $this->db->where(array('partner_is_active' => '1'));
        $this->db->order_by('partner_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_partner_detail($id) {
        $this->db->select("*, DATE_FORMAT(partner_input_datetime, '%M %D, %Y') AS partner_input_date", false);
        $this->db->from('site_partner');
        $this->db->where('partner_id', $id);
        $this->db->where('partner_is_active', '1');
        
        return $this->db->get();
    }
    
    function get_random_partner() {
        $this->db->select("*, DATE_FORMAT(partner_input_datetime, '%M %D, %Y') AS partner_input_date", false);
        $this->db->from('site_partner');
        $this->db->where('partner_is_active', '1');
        $this->db->order_by('RAND()');
        $this->db->limit(1);
        
        return $this->db->get();
    }
    
    function get_partner_comments($id, $par_id = 'all', $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(partner_comments_datetime, '%M %D, %Y') AS partner_comments_date", false);
        $this->db->from('site_partner_comments');
        $this->db->where('partner_comments_partner_id', $id);
        if($par_id != 'all') {
            $this->db->where('partner_comments_par_id', $par_id);
        }
        $this->db->where('partner_comments_is_approved', '1');
        $this->db->where('partner_comments_is_active', '1');
        if($par_id != 'all' && $par_id != 0) {
            $this->db->order_by('partner_comments_datetime', 'asc');
        } else {
            $this->db->order_by('partner_comments_datetime', 'desc');
        }
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_partner_feed($limit) {
        $this->db->select('*');
        $this->db->from('site_partner');
        $this->db->where('partner_is_active', '1');
        $this->db->order_by('partner_input_datetime', 'desc');
        $this->db->limit($limit);
        
        return $this->db->get();
    }
    
    function get_partner_search_result($keyword, $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(partner_input_datetime, '%M %D, %Y') AS partner_input_date", false);
        $this->db->from('site_partner');
        $this->db->like('partner_title', $keyword);
        $this->db->or_like('partner_short_content', $keyword);
        $this->db->or_like('partner_content', $keyword);
        $this->db->where(array('partner_is_active' => '1'));
        $this->db->order_by('partner_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }
    
    function insert_partner_comments($data) {
        $result = $this->db->insert('site_partner_comments', $data);
        if ($result) {
            
            return true;
        } else {
            
            return false;
        }
    }
    
    function check_email_partner_subscribe($email) {
        $this->db->select('1', false);
        $this->db->from('site_partner_subscribe');
        $this->db->where('partner_subscribe_email', $email);
        
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            
            return false;
        } else {
            
            return true;
        }
    }
    
    function insert_partner_subscribe($data) {
        $result = $this->db->insert('site_partner_subscribe', $data);
        if ($result) {
            
            return true;
        } else {
            
            return false;
        }
    }

}

?>