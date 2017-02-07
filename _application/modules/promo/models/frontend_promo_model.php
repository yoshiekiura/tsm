<?php

/*
 * Frontend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Frontend_promo_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_promo_list($offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(promo_input_datetime, '%M %D, %Y') AS promo_input_date", false);
        $this->db->from('site_promo');
        $this->db->where(array('promo_is_active' => '1'));
        $this->db->order_by('promo_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_promo_detail($id) {
        $this->db->select("*, DATE_FORMAT(promo_input_datetime, '%M %D, %Y') AS promo_input_date", false);
        $this->db->from('site_promo');
        $this->db->where('promo_id', $id);
        $this->db->where('promo_is_active', '1');
        
        return $this->db->get();
    }
    
    function get_random_promo() {
        $this->db->select("*, DATE_FORMAT(promo_input_datetime, '%M %D, %Y') AS promo_input_date", false);
        $this->db->from('site_promo');
        $this->db->where('promo_is_active', '1');
        $this->db->order_by('RAND()');
        $this->db->limit(1);
        
        return $this->db->get();
    }
    
    function get_promo_comments($id, $par_id = 'all', $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(promo_comments_datetime, '%M %D, %Y') AS promo_comments_date", false);
        $this->db->from('site_promo_comments');
        $this->db->where('promo_comments_promo_id', $id);
        if($par_id != 'all') {
            $this->db->where('promo_comments_par_id', $par_id);
        }
        $this->db->where('promo_comments_is_approved', '1');
        $this->db->where('promo_comments_is_active', '1');
        if($par_id != 'all' && $par_id != 0) {
            $this->db->order_by('promo_comments_datetime', 'asc');
        } else {
            $this->db->order_by('promo_comments_datetime', 'desc');
        }
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_promo_feed($limit) {
        $this->db->select('*');
        $this->db->from('site_promo');
        $this->db->where('promo_is_active', '1');
        $this->db->order_by('promo_input_datetime', 'desc');
        $this->db->limit($limit);
        
        return $this->db->get();
    }
    
    function get_promo_search_result($keyword, $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(promo_input_datetime, '%M %D, %Y') AS promo_input_date", false);
        $this->db->from('site_promo');
        $this->db->like('promo_title', $keyword);
        $this->db->or_like('promo_short_content', $keyword);
        $this->db->or_like('promo_content', $keyword);
        $this->db->where(array('promo_is_active' => '1'));
        $this->db->order_by('promo_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }
    
    function insert_promo_comments($data) {
        $result = $this->db->insert('site_promo_comments', $data);
        if ($result) {
            
            return true;
        } else {
            
            return false;
        }
    }
    
    function check_email_promo_subscribe($email) {
        $this->db->select('1', false);
        $this->db->from('site_promo_subscribe');
        $this->db->where('promo_subscribe_email', $email);
        
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            
            return false;
        } else {
            
            return true;
        }
    }
    
    function insert_promo_subscribe($data) {
        $result = $this->db->insert('site_promo_subscribe', $data);
        if ($result) {
            
            return true;
        } else {
            
            return false;
        }
    }

}

?>