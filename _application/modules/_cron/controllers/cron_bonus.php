<?php

/*
 * Cron Bonus Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Cron_bonus extends MY_Controller {

    function __construct() {
        parent::__construct();
        set_time_limit(0);

        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 0, date("Y")));

        //set harian
        $this->yesterday = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

        //set mingguan
        $this->weekly_start_day = 0; // 0 = minggu - sabtu
        //set bulanan
        $this->monthly_start_day = 1; // tanggal yang memungkinkan: 1 s/d 28

        $this->load->model('cron_common_model');
    }

    public function run_daily_bonus_cron() {
        $arr_bonus = $this->mlm_function->get_arr_active_bonus('daily');
        $start_date = $end_date = $this->yesterday;
        $bonus_log_name = '(';
        foreach ($arr_bonus as $arr_bonus_item) {
            $bonus_library = 'bonus_' . $arr_bonus_item['name'];
            $this->load->library('mlm/binary/' . $bonus_library);
            $this->$bonus_library->set_start_date($start_date);
            $this->$bonus_library->set_end_date($end_date);
            $this->$bonus_library->set_log_date($end_date);
            $this->$bonus_library->set_bonus_value($arr_bonus_item['value']);
            if (is_array($arr_bonus_item['value'])) {
                $this->$bonus_library->set_max_level(max(array_keys($arr_bonus_item['value'])));
            }
            $this->$bonus_library->execute();

            $bonus_log_name .= 'bonus_log_'.$arr_bonus_item['name'] . ' + ';
            sleep(1);
        }

        /* UPDATE bonus [daily] saldo */
        $str_bonus_log_select = rtrim($bonus_log_name, ' + '). ') as daily_bonus';
        $this->cron_common_model->update_bonus_saldo_periode('daily', $start_date, $end_date, $str_bonus_log_select);

        /* REPORT SUMMARY BONUS */
        $this->cron_common_model->update_report_summary_bonus($arr_bonus);

        $data = array();
        $data['cron_log_name'] = 'daily_bonus';
        $data['cron_log_date'] = $end_date;
        $data['cron_log_run_datetime'] = $this->datetime;
        $this->cron_common_model->insert_log($data);
    }

    public function run_weekly_bonus_cron() {
        $arr_bonus = $this->mlm_function->get_arr_active_bonus('weekly');
        //jika hari ini adalah awal perhitungan, maka hitung bonus minggu kemarin
        if (date("w") == $this->weekly_start_day) {
            list($start_date, $end_date) = $this->function_lib->get_week_date_range($this->yesterday, $this->weekly_start_day);
            $bonus_log_name = '(';
            foreach ($arr_bonus as $arr_bonus_item) {
                $bonus_library = 'bonus_' . $arr_bonus_item['name'];
                $this->load->library('mlm/binary/' . $bonus_library);
                $this->$bonus_library->set_start_date($start_date);
                $this->$bonus_library->set_end_date($end_date);
                $this->$bonus_library->set_log_date($end_date);
                $this->$bonus_library->set_bonus_value($arr_bonus_item['value']);
                if (is_array($arr_bonus_item['value'])) {
                    $this->$bonus_library->set_max_level(max(array_keys($arr_bonus_item['value'])));
                }
                $this->$bonus_library->execute();
                
                $bonus_log_name .= 'bonus_log_'.$arr_bonus_item['name'] . ' + ';
                sleep(1);
            }

            /* UPDATE bonus [weekly] saldo */
            $bonus_log_name = rtrim($bonus_log_name, ' + ');
            if (empty($bonus_log_name) OR $bonus_log_name == '(') {
                $str_bonus_log_select = '(0) as weekly_bonus';
            } else {
                $str_bonus_log_select = rtrim($bonus_log_name, ' + '). ') as weekly_bonus';
            }
            $this->cron_common_model->update_bonus_saldo_periode('weekly', $start_date, $end_date, $str_bonus_log_select);

            /* REPORT SUMMARY BONUS */
            $this->cron_common_model->update_report_summary_bonus($arr_bonus);

            $data = array();
            $data['cron_log_name'] = 'weekly_bonus';
            $data['cron_log_date'] = $end_date;
            $data['cron_log_run_datetime'] = $this->datetime;
            $this->cron_common_model->insert_log($data);
        }
    }

    public function run_monthly_bonus_cron() {
        $arr_bonus = $this->mlm_function->get_arr_active_bonus('monthly');
        //jika hari ini adalah awal perhitungan, maka hitung bonus bulan kemarin
        if (date("d") == $this->monthly_start_day) {
            $start_date = date("Y-m-d", mktime(0, 0, 0, date("m") - 1, $this->monthly_start_day, date("Y")));
            $end_date = date("Y-m-d", mktime(0, 0, 0, date("m"), $this->monthly_start_day - 1, date("Y")));
            foreach ($arr_bonus as $arr_bonus_item) {
                $bonus_library = 'bonus_' . $arr_bonus_item['name'];
                $this->load->library('mlm/binary/' . $bonus_library);
                $this->$bonus_library->set_start_date($start_date);
                $this->$bonus_library->set_end_date($end_date);
                $this->$bonus_library->set_log_date($end_date);
                $this->$bonus_library->set_bonus_value($arr_bonus_item['value']);
                if (is_array($arr_bonus_item['value'])) {
                    $this->$bonus_library->set_max_level(max(array_keys($arr_bonus_item['value'])));
                }
                $this->$bonus_library->execute();
                sleep(1);
            }

            $data = array();
            $data['cron_log_name'] = 'monthly_bonus';
            $data['cron_log_date'] = $end_date;
            $data['cron_log_run_datetime'] = $this->datetime;
            $this->cron_common_model->insert_log($data);
        }
    }

}
