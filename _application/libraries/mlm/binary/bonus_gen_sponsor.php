<?php

/*
 * MLM Bonus Gen Sponsor Libraries
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Bonus_gen_sponsor {

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
        $this->datetime = date("Y-m-d H:i:s");
    }
    
    /*
     * Method untuk eksekusi bonus titik
     */
    public function execute() {
        $arr_bonus = array();
        $sql = "
            SELECT netgrow_gen_sponsor_network_id, 
            netgrow_gen_sponsor_level, 
            COUNT(*) AS gen_sponsor_count 
            FROM sys_netgrow_gen_sponsor 
            WHERE netgrow_gen_sponsor_date BETWEEN '" . $this->start_date . "' AND '" . $this->end_date . "' 
            AND netgrow_gen_sponsor_level <= " . $this->max_level . "
            GROUP BY netgrow_gen_sponsor_network_id, netgrow_gen_sponsor_level 
        ";
        
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $network_id = $row->netgrow_gen_sponsor_network_id;
                $level = $row->netgrow_gen_sponsor_level;
                $count = $row->gen_sponsor_count;
                $bonus_value = (isset($this->bonus_value[$level])) ? $this->bonus_value[$level] : 0;
                $bonus_amount = $count * $bonus_value;

                if($bonus_amount > 0) {
                    $bonus_cash = 0.8 * $bonus_amount; // untuk bonus transfer
                    $bonus_ewallet = 0.2 * $bonus_amount; // untuk masuk ke ewallet

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
                            SET bonus_log_gen_sponsor = bonus_log_gen_sponsor + " . $bonus_cash . " 
                            WHERE bonus_log_network_id = '" . $network_id . "' 
                            AND bonus_log_date = '" . $this->log_date . "'
                        ";
                        $this->CI->db->query($sql_update);
                    } else {
                        $sql_insert = "
                            INSERT INTO sys_bonus_log 
                            SET bonus_log_network_id = '" . $network_id . "', 
                            bonus_log_gen_sponsor = '" . $bonus_cash . "', 
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
                            SET bonus_gen_sponsor_acc = bonus_gen_sponsor_acc + " . $bonus_cash . " 
                            WHERE bonus_network_id = '" . $network_id . "' 
                        ";
                        $this->CI->db->query($sql_update);
                    } else {
                        $sql_insert = "
                            INSERT INTO sys_bonus 
                            SET bonus_network_id = '" . $network_id . "', 
                            bonus_gen_sponsor_acc = '" . $bonus_cash . "'
                        ";
                        $this->CI->db->query($sql_insert);
                    }
                }
                
                if(!isset($arr_bonus[$network_id])) {
                    // $arr_bonus['network_id'] = $network_id;
                    $arr_bonus[$network_id]['cash'] = $bonus_cash;
                    $arr_bonus[$network_id]['ewallet'] = $bonus_ewallet;
                    $arr_bonus[$network_id]['total'] = $bonus_amount;
                }else{
                    $arr_bonus[$network_id]['cash'] += $bonus_cash;
                    $arr_bonus[$network_id]['ewallet'] += $bonus_ewallet;
                    $arr_bonus[$network_id]['total'] += $bonus_amount;
                    
                }
            }            
        }

        // print_r($arr_bonus);
        if(is_array($arr_bonus)){
            foreach ($arr_bonus as $key =>$value) {
                $network_id = $key;
                $cash = $value['ewallet'];
                $ewallet = $value['ewallet'];
                $total = $value['total'];
//                echo $network_id .' | ewallet : '.$ewallet.' | total bonus : '.$total.'<br>';

                $ewallet_note = '20% dari Royalti Jariyah : '.$total .', pada Tanggal '.convert_date($this->log_date,'id');
                    $sql_ewallet_log_insert = "
                        INSERT INTO sys_ewallet_product_log
                        SET ewallet_product_log_network_id = '".$network_id."',
                        ewallet_product_log_type = 'in',
                        ewallet_product_log_value = '".$ewallet."',
                        ewallet_product_log_bonus_name = 'gen_sponsor',
                        ewallet_product_log_note = '$ewallet_note',
                        ewallet_product_log_datetime = '".$this->datetime."'
                        ";
                    $this->CI->db->query($sql_ewallet_log_insert);
                    
                    //Update ewallet product balance
                    $sql_update_ewallet_balance = "
                        UPDATE sys_ewallet_product 
                        SET ewallet_product_balance = ewallet_product_balance + '".$ewallet."'
                        WHERE ewallet_product_network_id = '".$network_id."'
                        ";
                    $this->CI->db->query($sql_update_ewallet_balance);
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