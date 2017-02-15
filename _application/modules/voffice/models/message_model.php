<?php

/*
 * Member Message Model
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Message_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_parent_message($message_id) {
        $this->db->from('site_message');
        $this->db->where('message_id', $message_id);
        $this->db->where('message_par_id', '0');

        return $this->db->get();
    }
    
    function get_last_receive($message_id, $network_id) {
        $this->db->from('site_message');
        $this->db->where('message_id', $message_id);
        $this->db->or_where('message_par_id', $message_id);
        $this->db->where('message_sender_network_id !=', $network_id);
        $this->db->order_by('message_input_datetime', 'desc');
        $this->db->limit(1);

        return $this->db->get();
    }
    
    function get_last_message($message_id) {
        $this->db->from('site_message');
        $this->db->where('message_id', $message_id);
        $this->db->or_where('message_par_id', $message_id);
        $this->db->order_by('message_input_datetime', 'desc');
        $this->db->limit(1);

        return $this->db->get();
    }
    
    function get_detail_message($message_id, $offset = 0, $limit = 10) {
        $this->db->from('site_message');
        $this->db->where('message_id', $message_id);
        $this->db->or_where('message_par_id', $message_id);
        $this->db->order_by('message_input_datetime', 'asc');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
    
    function get_message_unread_count($message_receiver_network_id = '') {
        $sql = "
            SELECT COUNT(*) AS row_count 
            FROM 
            (
                SELECT message_id
                FROM site_message 
                WHERE message_is_read = '0' 
                AND message_par_id = '0' 
                AND message_receiver_network_id = '" . $message_receiver_network_id . "'
                UNION ALL
                SELECT message_par_id AS message_id
                FROM site_message 
                WHERE message_is_read = '0' 
                AND message_par_id != '0' 
                AND message_receiver_network_id = '" . $message_receiver_network_id . "'
            ) result 
        ";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->row_count;
    }
}

?>
