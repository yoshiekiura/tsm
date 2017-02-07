<?php

/**
 * Description of backend_page_mp_model
 *
 * @author Yusuf Rahmanto
 */
class backend_page_mp_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function list_mp() {
        $sql = "SELECT * FROM site_page_mp ORDER BY page_mp_id ASC";
        return $this->db->query($sql);
    }
}

?>
