<?php

/**
 * Description of frontend_support_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_support_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_support_active() {
        $this->db->where('support_is_active', '1');
        return $this->db->get('site_support');
    }
}

?>
