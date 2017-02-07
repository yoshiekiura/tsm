<?php

/*
 * Cron Common Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Cron_common extends MY_Controller {

    function __construct() {
        parent::__construct();

        // console: php /path/to/index.php controller_name method_name ["params"]
        // cronjob: /usr/local/bin/php -f /path/to/index.php controller_name method_name ["params"]
        // this controller can only be called from the command line
        //if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');

        //$this->output->enable_profiler(true);
        set_time_limit(0);
        $this->load->model('_cron/cron_common_model');
        
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 0, date("Y")));
        $this->yesterday = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

        $this->reward_datetime = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d") - 1, date("Y")));
        
        $this->network_code_start = 'ESD-1230001';
        $this->stock_network_code_limit = 1000;
        $this->insert_network_code_count = 2000;
    }
    
    public function run_generate_stock_code_cron() {
        $num_stock_code = $this->cron_common_model->get_num_stock_network_code();
        
        if($num_stock_code <= $this->stock_network_code_limit) {
            $last_stock_code = $this->cron_common_model->get_last_stock_network_code();
            
            if($last_stock_code == false) {
                $last_code = $this->cron_common_model->get_last_network_code();
                
                if($last_code == false) {
                    $new_code = $this->network_code_start;
                    $code_len = strlen($new_code);
                } else {
                    $last_code = substr($last_code, 0, strlen($this->network_code_start));
                    $code_len = strlen($last_code);
                    $new_code = ++$last_code;
                }
            } else {
                $code_len = strlen($last_stock_code);
                $new_code = ++$last_stock_code;
            }
            $new_code = str_pad($new_code, $code_len, '0', STR_PAD_LEFT);
            
            for($i = 1; $i <= $this->insert_network_code_count; $i++) {
                $data = array();
                $data['stock_network_code_value'] = $new_code;
                $this->cron_common_model->insert_network_code($data);
                $new_code = ++$new_code;
                $new_code = str_pad($new_code, $code_len, '0', STR_PAD_LEFT);
            }
        }
        
        $data = array();
        $data['cron_log_name'] = 'generate_stock_code';
        $data['cron_log_date'] = $this->date;
        $data['cron_log_run_datetime'] = $this->datetime;
        $this->cron_common_model->insert_log($data);
    }



    function cron_reward() {
        $arr_date = explode('-', $this->yesterday);
        $reward_year = $arr_date[0];

        $arr_reward = $this->cron_common_model->get_active_reward();

        if($arr_reward->num_rows() > 0){
            foreach ($arr_reward->result() as $row) {
                $arr_member_qualified = $this->cron_common_model->get_member_qualified_reward($row->syarat_kiri, $row->syarat_kanan, $reward_year);

                if($arr_member_qualified->num_rows() > 0) {                    
                    foreach ($arr_member_qualified->result() as $row_member) {
                        $data =array();
                        $data_reward_status =array();
                        //Check masing2 member Apakah sudah pernah qualified reward yang ada
                        $is_get_reward = $this->function_lib->get_one('sys_reward_qualified','reward_qualified_id',array('reward_qualified_network_id' => $row_member->network_id, 'reward_qualified_reward_id' => $row->reward_id));

                        if($is_get_reward == ''){
                            $data['reward_qualified_network_id'] = $row_member->network_id;
                            $data['reward_qualified_reward_id'] = $row->reward_id;
                            $data['reward_qualified_condition_node_left'] = $row_member->left_node;
                            $data['reward_qualified_condition_node_right'] = $row_member->right_node;
                            $data['reward_qualified_reward_value'] = $row->reward_bonus_value;
                            $data['reward_qualified_reward_bonus'] = $row->reward_bonus;
                            $data['reward_qualified_date'] = $this->yesterday;

                            $reward_qualified_id = $this->function_lib->insert_data('sys_reward_qualified', $data);

                            $data_reward_status['reward_qualified_status_reward_qualified_id'] = $reward_qualified_id;
                            $data_reward_status['reward_qualified_status_reward_value'] = $row->reward_bonus_value;
                            $data_reward_status['reward_qualified_status_reward_bonus'] = $row->reward_bonus;
                            $data_reward_status['reward_qualified_status_administrator_id'] = 0;
                            $data_reward_status['reward_qualified_status_datetime'] = $this->reward_datetime;

                            $this->function_lib->insert_data('sys_reward_qualified_status', $data_reward_status);
                        }
                        
                    }
                }
            }
        }

        $data = array();
        $data['cron_log_name'] = 'cron reward';
        $data['cron_log_date'] = $this->date;
        $data['cron_log_run_datetime'] = $thiscl->datetime;
        $this->cron_common_model->insert_log($data);
    }
    
}

?>
