<?php

/**
 * Description of frontend_testimony_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_testimony_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_testimony_list($offset = 0, $limit = 20) {
        $this->db->select("*, DATE_FORMAT(testimony_datetime, '%M %D, %Y') AS testimony_date", false);
        $this->db->from('view_testimony');
        $this->db->where(array('testimony_is_active' => '1'));
        $this->db->order_by('testimony_datetime', 'desc');
        $this->db->limit($limit, $offset);

        return $this->db->get();
    }
    
    function get_random_testimony($limit) {
        $this->db->select("*, DATE_FORMAT(testimony_datetime, '%M %D, %Y') AS testimony_date", false);
        $this->db->from('view_testimony');
        $this->db->where('testimony_is_active', '1');
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        
        return $this->db->get();
    }
}

?>
