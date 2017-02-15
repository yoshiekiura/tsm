<?php

/**
 * Description of backend_message_model
 *
 * @author Yusuf Rahmanto
 */
class backend_message_model extends CI_Model {

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
}

?>
