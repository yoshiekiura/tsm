<?php

/*
 * MLM Bonus Gen Node Libraries
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Bonus_gen_node {

    var $CI = null;
    protected $db;
    protected $start_date;
    protected $end_date;
    protected $log_date;
    protected $bonus_value;
    protected $max_level;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }
    
    /*
     * Method untuk eksekusi bonus titik
     */
    public function execute() {
        $sql = "
            SELECT netgrow_gen_node_network_id, 
            netgrow_gen_node_level, 
            COUNT(*) AS gen_node_count 
            FROM sys_netgrow_gen_node 
            WHERE netgrow_gen_node_date BETWEEN '" . $this->start_date . "' AND '" . $this->end_date . "' 
            AND netgrow_gen_node_level <= " . $this->max_level . "
            GROUP BY netgrow_gen_node_network_id, netgrow_gen_node_level 
        ";
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $network_id = $row->netgrow_gen_node_network_id;
                $level = $row->netgrow_gen_node_level;
                $count = $row->gen_node_count;
                $bonus_value = (isset($this->bonus_value[$level])) ? $this->bonus_value[$level] : 0;
                $bonus_amount = $count * $bonus_value;
                
                if($bonus_amount > 0) {
                    $sql_check = "
                        SELECT 1 
                        FROM sys_bonus_log 
                        WHERE bonus_log_network_id = '" . $network_id . "' 
                        AND bonus_log_date = '" . $this->log_date . "'
                    ";
                    $query_check = $this->CI->db->query($sql_check);
                    if($query_check->num_rows() > 0) {
                        $sql_update = "
                            UPDATE sys_bonus_log 
                            SET bonus_log_gen_node = bonus_log_gen_node + " . $bonus_amount . " 
                            WHERE bonus_log_network_id = '" . $network_id . "' 
                            AND bonus_log_date = '" . $this->log_date . "'
                        ";
                        $this->CI->db->query($sql_update);
                    } else {
                        $sql_insert = "
                            INSERT INTO sys_bonus_log 
                            SET bonus_log_network_id = '" . $network_id . "', 
                            bonus_log_gen_node = '" . $bonus_amount . "', 
                            bonus_log_date = '" . $this->log_date . "'
                        ";
                        $this->CI->db->query($sql_insert);
                    }
                }
            }
        }
    }
    
    
    /* -------------------------------------------------------------------------
     * setter
     * -------------------------------------------------------------------------
     */
    public function set_start_date($start_date) {
        $this->start_date = $start_date;
        return $this;
    }
    
    public function set_end_date($end_date) {
        $this->end_date = $end_date;
        return $this;
    }
    
    public function set_log_date($log_date) {
        $this->log_date = $log_date;
        return $this;
    }
    
    public function set_bonus_value($bonus_value) {
        $this->bonus_value = $bonus_value;
        return $this;
    }
    
    public function set_max_level($max_level) {
        $this->max_level = $max_level;
        return $this;
    }
    
}

?>