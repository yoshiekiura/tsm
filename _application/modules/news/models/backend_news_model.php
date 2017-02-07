<?php

/*
 * Backend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_news_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function list_news() {
        $sql = "SELECT * FROM site_news WHERE news_is_active = '1' ORDER BY news_title ASC";
        return $this->db->query($sql);
    }

}

?>