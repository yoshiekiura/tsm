<?php

/*
 * Frontend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Frontend_downloads_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_downloads_list($offset = 0, $limit = 10) {
        $this->db->select("*");
        $this->db->from('site_downloads');
        $this->db->where(array('downloads_is_active' => '1'));
        $this->db->where(array('downloads_location' => 'public'));
        $this->db->order_by('downloads_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);
        return $this->db->get();
    }

     function update_downloads_count($id) {
        $sql = "UPDATE site_downloads SET downloads_count = downloads_count + 1 WHERE downloads_id = '" . $id . "'";
        $this->db->query($sql);
    }

}

?>