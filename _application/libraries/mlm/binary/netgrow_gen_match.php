<?php

/*
 * MLM Netgrow Gen Match Libraries
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Netgrow_gen_match {

    var $CI = null;
    protected $db;
    protected $network_id;
    protected $date;
    protected $max_level;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->library(array('function_lib', 'mlm_function'));
    }
    
    /*
     * Method untuk eksekusi generasi pasangan
     */
    public function execute() {
        $level = 1;
        $sponsor_id = $this->CI->mlm_function->get_sponsor_network_id($this->network_id);
        while ($level <= $this->max_level && $sponsor_id != 0) {
            $sql_insert = "
                INSERT INTO sys_netgrow_gen_match 
                SET netgrow_gen_match_network_id = '" . $sponsor_id . "', 
                netgrow_gen_match_downline_network_id = '" . $this->network_id . "', 
                netgrow_gen_match_level = '" . $level . "', 
                netgrow_gen_match_date = '" . $this->date . "'
            ";
            $this->CI->db->query($sql_insert);
            
            //cari generasi diatasnya
            $sponsor_id = $this->CI->mlm_function->get_sponsor_network_id($sponsor_id);

            $level++;
        }
    }
    
    
    /* -------------------------------------------------------------------------
     * setter
     * -------------------------------------------------------------------------
     */
    public function set_network_id($network_id) {
        $this->network_id = $network_id;
    }

    public function set_date($date) {
        $this->date = $date;
        return $this;
    }

    public function set_max_level($max_level) {
        $this->max_level = $max_level;
        return $this;
    }

}

?>