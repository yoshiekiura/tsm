<?php

/*
 * Backend Cron  Model
 *
 * @author	Yudha Wirawan Sakti
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class backend_tools_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function list_cron() {
        $sql = "SELECT * FROM cron_log ORDER BY cron_log_run_datetime ASC";
        return $this->db->query($sql);
    }

}

?>