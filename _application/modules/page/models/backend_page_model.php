<?php

/*
 * Backend Page Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_page_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_list($par_id = 0) {
        $sql = "SELECT * FROM site_page WHERE page_par_id = '" . $par_id . "' ORDER BY page_id ASC";
        return $this->db->query($sql);
    }

}

?>