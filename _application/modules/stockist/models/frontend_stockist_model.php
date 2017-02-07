<?php

/*
 * Frontend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Frontend_stockist_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_stockist_list($offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(stockist_input_datetime, '%M %D, %Y') AS stockist_input_date", false);
        $this->db->from('site_stockist');
        $this->db->where(array('stockist_is_active' => '1'));
        $this->db->order_by('stockist_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_stockist_detail($id) {
        $this->db->select("*, DATE_FORMAT(stockist_input_datetime, '%M %D, %Y') AS stockist_input_date", false);
        $this->db->from('site_stockist');
        $this->db->where('stockist_id', $id);
        $this->db->where('stockist_is_active', '1');
        
        return $this->db->get();
    }
    
    function get_random_stockist() {
        $this->db->select("*, DATE_FORMAT(stockist_input_datetime, '%M %D, %Y') AS stockist_input_date", false);
        $this->db->from('site_stockist');
        $this->db->where('stockist_is_active', '1');
        $this->db->order_by('RAND()');
        $this->db->limit(1);
        
        return $this->db->get();
    }
    
    function get_stockist_comments($id, $par_id = 'all', $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(stockist_comments_datetime, '%M %D, %Y') AS stockist_comments_date", false);
        $this->db->from('site_stockist_comments');
        $this->db->where('stockist_comments_stockist_id', $id);
        if($par_id != 'all') {
            $this->db->where('stockist_comments_par_id', $par_id);
        }
        $this->db->where('stockist_comments_is_approved', '1');
        $this->db->where('stockist_comments_is_active', '1');
        if($par_id != 'all' && $par_id != 0) {
            $this->db->order_by('stockist_comments_datetime', 'asc');
        } else {
            $this->db->order_by('stockist_comments_datetime', 'desc');
        }
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_stockist_feed($limit) {
        $this->db->select('*');
        $this->db->from('site_stockist');
        $this->db->where('stockist_is_active', '1');
        $this->db->order_by('stockist_input_datetime', 'desc');
        $this->db->limit($limit);
        
        return $this->db->get();
    }
    
    function get_stockist_search_result($keyword, $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(stockist_input_datetime, '%M %D, %Y') AS stockist_input_date", false);
        $this->db->from('site_stockist');
        $this->db->like('stockist_title', $keyword);
        $this->db->or_like('stockist_short_content', $keyword);
        $this->db->or_like('stockist_content', $keyword);
        $this->db->where(array('stockist_is_active' => '1'));
        $this->db->order_by('stockist_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }
    
    function insert_stockist_comments($data) {
        $result = $this->db->insert('site_stockist_comments', $data);
        if ($result) {
            
            return true;
        } else {
            
            return false;
        }
    }
    
    function check_email_stockist_subscribe($email) {
        $this->db->select('1', false);
        $this->db->from('site_stockist_subscribe');
        $this->db->where('stockist_subscribe_email', $email);
        
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            
            return false;
        } else {
            
            return true;
        }
    }
    
    function insert_stockist_subscribe($data) {
        $result = $this->db->insert('site_stockist_subscribe', $data);
        if ($result) {
            
            return true;
        } else {
            
            return false;
        }
    }

}

?>