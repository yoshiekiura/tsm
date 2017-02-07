<?php

/**
 * Description of backend_contact_us_mp_model
 *
 * @author Yusuf Rahmanto
 */
class backend_contact_us_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function list_contact_us() {
        $sql = "SELECT * FROM site_contact_us ORDER BY contact_us_id ASC";
        return $this->db->query($sql);
    }
}

?>
