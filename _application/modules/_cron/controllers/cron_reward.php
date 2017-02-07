<?php

/*
 * Cron Reward Controller
 *
 * @author	Yudha Wirawan S
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Cron_reward extends MY_Controller {

    function __construct() {
        parent::__construct();

        set_time_limit(0);

        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 0, date("Y")));

        //set harian
        $this->yesterday = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

        //set mingguan
        $this->weekly_start_day = 0; //0 = minggu - sabtu
        //set bulanan
        $this->monthly_start_day = 1; //tanggal yang memungkinkan: 1 s/d 28
        //set tahunan
        $this->year = date('Y');

        //$this->load->model('cron_common_model');
    }

    public function run_reward() {
        $sql = "SELECT reward_id, reward_cond_node_left, reward_cond_node_right, reward_bonus_value, reward_bonus FROM sys_reward ORDER BY reward_id ASC";
        $query = $this->db->query($sql);
        $row = $query->result();
        if ($query->num_rows() > 0) {
            foreach ($row as $reward) {
                    
 
                $sql_reward = "SELECT netgrow_master_network_id FROM
                                (SELECT netgrow_master_network_id, SUM(netgrow_master_node_left) AS jumlah_kiri, SUM(netgrow_master_node_right) AS jumlah_kanan
                                FROM sys_netgrow_master WHERE YEAR(netgrow_master_date) = '" . $this->year . "' GROUP BY netgrow_master_network_id) AS RESULT
                                WHERE jumlah_kiri >= ".$reward->reward_cond_node_left." AND jumlah_kanan >= ".$reward->reward_cond_node_right."";
                $query_reward = $this->db->query($sql_reward);
                $row_reward = $query_reward->result();
                
                if ($query_reward->num_rows() > 0) {
                    foreach ($row_reward as $data_reward) {

                        
                            //cek sudah dapat reward dengan reward_id tersebut belum
                            $reward_qualified_network_id = $this->function_lib->get_one('sys_reward_qualified', 'reward_qualified_network_id', 
                                                        'reward_qualified_reward_id = '.$reward->reward_id.' AND reward_qualified_network_id =' . $data_reward->netgrow_master_network_id);
                            
                            if (empty($reward_qualified_network_id) || $reward_qualified_network_id = '') {
                                $sql_insert_reward_qualified = "
                                            INSERT INTO sys_reward_qualified 
                                            SET reward_qualified_network_id = '" . $data_reward->netgrow_master_network_id . "', 
                                            reward_qualified_reward_id = " . $reward->reward_id . ", 
                                            reward_qualified_condition_node_left = '" . $data_reward->jumlah_kiri . "', 
                                            reward_qualified_condition_node_right = '" . $data_reward->jumlah_kanan . "',
                                            reward_qualified_reward_value = " . $reward->reward_bonus_value . ", 
                                            reward_qualified_reward_bonus = '" . $reward->reward_bonus . "' 
                                            reward_qualified_date = '" . $this->yesterday . "'";
                                $this->CI->db->query($sql_insert_reward_qualified);
                            
                        }
                    }
                }
            }
        }
    }

}

?>
