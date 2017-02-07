<?php

/*
 * MLM Netgrow Match Libraries
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Netgrow_match {

    var $CI = null;
    protected $db;
    protected $match_bool = TRUE;
    protected $flushout = 0;
    protected $max_wait = 0;
    protected $date;
    protected $add_match_depend = array();

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->library(array('function_lib', 'mlm_function'));
    }
    
    /*
     * Method untuk meng-handle dependensi pasangan
     * @param Array $arr_class_name
     */
    public function add_match_depend($arr_class_name) {
        foreach ($arr_class_name as $class_name => $config) {
            include_once($class_name . ".php");
            $this->add_match_depend[$class_name] = $config;
            $this->$class_name = new $class_name;
        }
    }
    
    /*
     * Method untuk eksekusi penghitungan pasangan
     */
    public function execute() {
        //ambil netgrow hari ini
        $sql_netgrow_today = "
            SELECT * 
            FROM sys_netgrow_master 
            WHERE netgrow_master_date = '" . $this->date . "'
        ";
        $query_netgrow_today = $this->CI->db->query($sql_netgrow_today);
        if($query_netgrow_today->num_rows() > 0) {
            foreach($query_netgrow_today->result() as $row_netgrow_today) {
                $network_id = $row_netgrow_today->netgrow_master_network_id;
                $active_left = $row_netgrow_today->netgrow_master_node_left;
                $active_right = $row_netgrow_today->netgrow_master_node_right;
                $match_today = $row_netgrow_today->netgrow_master_match;
                $match = 0;
                $match_real = 0;
                
                //ambil netgrow sebelumnya
                $sql_netgrow_prev = "
                    SELECT * 
                    FROM sys_netgrow_master 
                    WHERE netgrow_master_network_id = '" . $network_id . "'
                    AND netgrow_master_date < '" . $this->date . "' 
                    ORDER BY netgrow_master_id DESC LIMIT 1
                ";
                $query_netgrow_prev = $this->CI->db->query($sql_netgrow_prev);
                if($query_netgrow_prev->num_rows() > 0) {
                    $row_netgrow_prev = $query_netgrow_prev->row();
                    $wait_left = $row_netgrow_prev->netgrow_master_wait_left;
                    $wait_right = $row_netgrow_prev->netgrow_master_wait_right;
                } else {
                    $wait_left = $wait_right = 0;
                }

                //penentuan jumlah titik menunggu & jumlah pasangan
                $total_left = $wait_left + $active_left;
                $total_right = $wait_right + $active_right;

                if ($total_left == $total_right) {
                    $match = $match_real = $total_right;
                    $wait_right = 0;
                    $wait_left = 0;
                } elseif ($total_left > $total_right) {
                    $match = $match_real = $total_right;
                    $wait_left = $total_left - $total_right;
                    $wait_right = 0;
                } elseif ($total_left < $total_right) {
                    $match = $match_real = $total_left;
                    $wait_right = $total_right - $total_left;
                    $wait_left = 0;
                }
                
                if($this->max_wait > 0) {
                    if($wait_left >= $this->max_wait) {
                        $wait_left = $this->max_wait;
                    }
                    if($wait_right >= $this->max_wait) {
                        $wait_right = $this->max_wait;
                    }
                }
                
                if ($match >= $this->flushout) {
                    $match = $this->flushout;
                }
                
                //update
                $sql_update = "
                    UPDATE sys_netgrow_master 
                    SET netgrow_master_wait_left = '" . $wait_left . "', 
                    netgrow_master_wait_right = '" . $wait_right . "', 
                    netgrow_master_match = '" . $match_real . "' 
                    WHERE netgrow_master_network_id = '" . $network_id . "' 
                    AND netgrow_master_date = '" . $this->date . "'
                ";
                $this->CI->db->query($sql_update);
                
                $match_new = $match - $match_today;
                if ($match_new > 0 && $this->match_bool == TRUE) {
					$sql_netgrow_match = "";
					//$cek_netgrow_match = $this->CI->function_lib->get_one('sys_netgrow_match', 'netgrow_match_id', array('netgrow_match_network_id' => $network_id, 'netgrow_match_date' => $this->date));
					$sql_cek_netgrow_match = "SELECT 1 FROM sys_netgrow_match WHERE netgrow_match_network_id = " . $network_id . " AND netgrow_match_date = '" . $this->date . "'";
					$query_cek_netgrow_match = $this->CI->db->query($sql_cek_netgrow_match);
                    //if (empty($cek_netgrow_match)) {
                    if ($query_cek_netgrow_match->num_rows() == 0) {
                        $sql_netgrow_match = "
                            INSERT INTO sys_netgrow_match 
                            SET netgrow_match_network_id = '" . $network_id . "', 
                            netgrow_match_value = '" . $match . "', 
                            netgrow_match_date = '" . $this->date . "'
                        ";
						$this->CI->db->query($sql_netgrow_match);
                    } else {
                        $sql_netgrow_match = "
                            UPDATE sys_netgrow_match 
                            SET netgrow_match_value = '" . $match . "' 
                            WHERE netgrow_match_network_id = '" . $network_id . "' 
                            AND netgrow_match_date = '" . $this->date . "'
                        ";
						$this->CI->db->query($sql_netgrow_match);
                    }
                    
                    //generate dependensi terhadap pasangan
                    if (count($this->add_match_depend) > 0) {
                        foreach ($this->add_match_depend as $class_name => $config) {
                            $this->$class_name->set_network_id($network_id);
                            $this->$class_name->set_date($this->date);
                            
                            //cek jika mengandung gen maka harus ada config level
                            preg_match("/gen/", strval($class_name), $matches);
                            if (!empty($matches)) {
                                $this->$class_name->set_max_level($config['level']);
                            }
                            $this->$class_name->execute();
                        }
                    }
                    
                }
            }
        }
    }
    
    
    /* -------------------------------------------------------------------------
     * setter
     * -------------------------------------------------------------------------
     */
    public function set_flushout($flushout) {
        $this->flushout = $flushout;
        return $this;
    }
    
    public function set_max_wait($max_wait) {
        $this->max_wait = $max_wait;
        return $this;
    }
    
    public function set_date($date) {
        $this->date = $date;
        return $this;
    }
    
    public function set_match_bool($boolean = TRUE) {
        $this->match_bool = $boolean;
        return $this;
    }

}

?>