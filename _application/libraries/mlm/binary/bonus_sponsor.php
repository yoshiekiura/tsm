<?php

/*
 * MLM Bonus Sponsor Libraries
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Bonus_sponsor {

    var $CI = null;
    protected $db;
    protected $start_date;
    protected $end_date;
    protected $log_date;
    protected $bonus_value;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->datetime = date("Y-m-d H:i:s");
    }

    /*
     * Method untuk eksekusi bonus sponsor
     */

    public function execute() {

        $sql = "
            SELECT netgrow_sponsor_network_id, 
            COUNT(*) AS sponsoring_count  
            FROM sys_netgrow_sponsor 
            WHERE netgrow_sponsor_date BETWEEN '" . $this->start_date . "' AND '" . $this->end_date . "' 
            GROUP BY netgrow_sponsor_network_id
        ";

        $query = $this->CI->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $network_id = $row->netgrow_sponsor_network_id;
                $count = $row->sponsoring_count;
                $bonus_amount = $count * $this->bonus_value;

                if ($bonus_amount > 0) {
                    
                    $sql_check = "
                        SELECT 1 
                        FROM sys_bonus_log 
                        WHERE bonus_log_network_id = '" . $network_id . "' 
                        AND bonus_log_date = '" . $this->log_date . "'
                    ";
                    $query_check = $this->CI->db->query($sql_check);
                    if ($query_check->num_rows() > 0) {
                        $sql_update = "
                            UPDATE sys_bonus_log 
                            SET bonus_log_sponsor = bonus_log_sponsor + " . $bonus_amount . " 
                            WHERE bonus_log_network_id = '" . $network_id . "' 
                            AND bonus_log_date = '" . $this->log_date . "'
                        ";
                        $this->CI->db->query($sql_update);
                    } else {
                        $sql_insert = "
                            INSERT INTO sys_bonus_log 
                            SET bonus_log_network_id = '" . $network_id . "', 
                            bonus_log_sponsor = '" . $bonus_amount . "', 
                            bonus_log_date = '" . $this->log_date . "'
                        ";
                        $this->CI->db->query($sql_insert);
                    }

                    //UPDATE table sys_bonus
                    $sql_check = "
                        SELECT 1 
                        FROM sys_bonus 
                        WHERE bonus_network_id = '" . $network_id . "' 
                    ";
                    $query_check = $this->CI->db->query($sql_check);
                    if ($query_check->num_rows() > 0) {
                        $sql_update = "
                            UPDATE sys_bonus 
                            SET bonus_sponsor_acc = bonus_sponsor_acc + " . $bonus_amount . " ,
                            bonus_total_saldo = bonus_total_saldo + " . $bonus_amount . " ,
                            bonus_sponsor_saldo = bonus_sponsor_saldo + " . $bonus_amount . " 
                            WHERE bonus_network_id = '" . $network_id . "' 
                        ";
                        $this->CI->db->query($sql_update);
                    } else {
                        $sql_insert = "
                            INSERT INTO sys_bonus 
                            SET bonus_network_id = '" . $network_id . "', 
                            bonus_sponsor_acc = " . $bonus_amount . ",
                            bonus_sponsor_saldo = " . $bonus_amount . ",
                            bonus_total_saldo = " . $bonus_amount . "
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

}

?>