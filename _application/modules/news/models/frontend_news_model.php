<?php

/*
 * Frontend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Frontend_news_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_news_list($offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(news_input_datetime, '%M %D, %Y') AS news_input_date", false);
        $this->db->from('site_news');
        $this->db->where(array('news_is_active' => '1'));
        $this->db->order_by('news_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_news_detail($id) {
        $this->db->select("*, DATE_FORMAT(news_input_datetime, '%M %D, %Y') AS news_input_date", false);
        $this->db->from('site_news');
        $this->db->where('news_id', $id);
        $this->db->where('news_is_active', '1');
        
        return $this->db->get();
    }
    
    function get_random_news() {
        $this->db->select("*, DATE_FORMAT(news_input_datetime, '%M %D, %Y') AS news_input_date", false);
        $this->db->from('site_news');
        $this->db->where('news_is_active', '1');
        $this->db->order_by('RAND()');
        $this->db->limit(1);
        
        return $this->db->get();
    }
    
    function get_news_comments($id, $par_id = 'all', $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(news_comments_datetime, '%M %D, %Y') AS news_comments_date", false);
        $this->db->from('site_news_comments');
        $this->db->where('news_comments_news_id', $id);
        if($par_id != 'all') {
            $this->db->where('news_comments_par_id', $par_id);
        }
        $this->db->where('news_comments_is_approved', '1');
        $this->db->where('news_comments_is_active', '1');
        if($par_id != 'all' && $par_id != 0) {
            $this->db->order_by('news_comments_datetime', 'asc');
        } else {
            $this->db->order_by('news_comments_datetime', 'desc');
        }
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_news_feed($limit) {
        $this->db->select('*');
        $this->db->from('site_news');
        $this->db->where('news_is_active', '1');
        $this->db->order_by('news_input_datetime', 'desc');
        $this->db->limit($limit);
        
        return $this->db->get();
    }
    
    function get_news_search_result($keyword, $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(news_input_datetime, '%M %D, %Y') AS news_input_date", false);
        $this->db->from('site_news');
        $this->db->like('news_title', $keyword);
        $this->db->or_like('news_short_content', $keyword);
        $this->db->or_like('news_content', $keyword);
        $this->db->where(array('news_is_active' => '1'));
        $this->db->order_by('news_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }
    
    function insert_news_comments($data) {
        $result = $this->db->insert('site_news_comments', $data);
        if ($result) {
            
            return true;
        } else {
            
            return false;
        }
    }
    
    function check_email_news_subscribe($email) {
        $this->db->select('1', false);
        $this->db->from('site_news_subscribe');
        $this->db->where('news_subscribe_email', $email);
        
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            
            return false;
        } else {
            
            return true;
        }
    }
    
    function insert_news_subscribe($data) {
        $result = $this->db->insert('site_news_subscribe', $data);
        if ($result) {
            
            return true;
        } else {
            
            return false;
        }
    }

}

?>