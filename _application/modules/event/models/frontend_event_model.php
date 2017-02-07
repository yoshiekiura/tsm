<?php

/*
 * Frontend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Frontend_event_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_event_list_2($offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->where(array('event_is_active' => '1', 'event_category' => 'event'));
        //$this->db->where(array('event_category' => 'event'));
        $this->db->order_by('event_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    public function get_event_list($offset = 0, $limit = 10) {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->where(array('event_is_active' => '1'));
        $this->db->order_by('event_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);
        return $this->db->get();
    }

    public function get_random_list($offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->where(array('event_is_active' => '1', 'event_category' => 'event'));
        //$this->db->where(array('event_category' => 'event'));
        $this->db->order_by('event_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_event_detail($id) {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->where('event_id', $id);
        $this->db->where('event_is_active', '1');

        return $this->db->get();
    }

    function get_event_random($id) {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->where('event_id !=', $id);
        $this->db->where('event_is_active', '1');
        $this->db->where('event_category', 'event');
        $this->db->order_by('event_id', 'ASC');

        return $this->db->get();
    }

    function get_random_event() {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->where('event_is_active', '1');
        $this->db->order_by('RAND()');
        $this->db->limit(1);

        return $this->db->get();
    }

    function get_event_comments($id, $par_id = 'all', $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(event_comments_datetime, '%M %D, %Y') AS event_comments_date", false);
        $this->db->from('site_event_comments');
        $this->db->where('event_comments_event_id', $id);
        if ($par_id != 'all') {
            $this->db->where('event_comments_par_id', $par_id);
        }
        $this->db->where('event_comments_is_approved', '1');
        $this->db->where('event_comments_is_active', '1');
        if ($par_id != 'all' && $par_id != 0) {
            $this->db->order_by('event_comments_datetime', 'asc');
        } else {
            $this->db->order_by('event_comments_datetime', 'desc');
        }
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_event_feed($limit) {
        $this->db->select('*');
        $this->db->from('site_event');
        $this->db->where('event_is_active', '1');
        $this->db->order_by('event_input_datetime', 'desc');
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_event_search_result($keyword, $offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->like('event_title', $keyword);
        $this->db->or_like('event_short_content', $keyword);
        $this->db->or_like('event_content', $keyword);
        $this->db->where(array('event_is_active' => '1'));
        $this->db->order_by('event_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    function insert_event_comments($data) {
        $result = $this->db->insert('site_event_comments', $data);
        if ($result) {

            return true;
        } else {

            return false;
        }
    }

    function check_email_event_subscribe($email) {
        $this->db->select('1', false);
        $this->db->from('site_event_subscribe');
        $this->db->where('event_subscribe_email', $email);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return false;
        } else {

            return true;
        }
    }

    function insert_event_subscribe($data) {
        $result = $this->db->insert('site_event_subscribe', $data);
        if ($result) {

            return true;
        } else {

            return false;
        }
    }

}

?>