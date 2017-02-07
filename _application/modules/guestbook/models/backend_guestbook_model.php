<?php

/*
 * Backend Guestbook Model
 *
 * @author	Ardiansyah Prasaja
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_guestbook_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function get_detail($id) {
        $sql = "
            SELECT site_guestbook.*, ref_country.country_name AS guestbook_country_name 
            FROM site_guestbook
            LEFT JOIN ref_country ON ref_country.country_id=site_guestbook.guestbook_country_id 
            WHERE site_guestbook.guestbook_id = '" . $id . "'
        ";
        return $this->db->query($sql);
    }
    
    function get_list_configuration() {
        $sql = "
            SELECT * 
            FROM site_guestbook_configuration 
            WHERE guestbook_configuration_is_show = '1' 
            ORDER BY guestbook_configuration_order_by ASC
        ";
        return $this->db->query($sql);
    }
}

?>
