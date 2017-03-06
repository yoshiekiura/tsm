<?php
/**
 * Backend Rekap
 *
 * @author Fahrur Rifai <mfahrurrifai@gmail.com>
 * @copyright	Copyright (c) 2017, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

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

        $this->load->model('rekap_model');
    }

    public function rekap_daily_bonus($date=FALSE) {
    	if ($date === FALSE OR $this->sys_configuration['rekap_bonus_active'] == 0) {
    		$this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Anda tidak diotorisasi untuk halaman tersebut.</div>');
    		redirect('backend/dashboard/show');
    	} else {
	        $arr_bonus = $this->mlm_function->get_arr_active_bonus('daily');
	        $start_date = $end_date = $date;
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
	        $this->rekap_model->update_bonus_saldo_periode('daily', $start_date, $end_date, $str_bonus_log_select);

	        /* REPORT SUMMARY BONUS */
	        $this->rekap_model->update_report_summary_bonus($arr_bonus);

	        $data = array();
	        $data['cron_log_name'] = 'daily_bonus';
	        $data['cron_log_date'] = $end_date;
	        $data['cron_log_run_datetime'] = $this->datetime;
	        $this->rekap_model->insert_log($data);
    	}
    }

    public function rekap_all_bonus() {
    	// get first member register
    	$this->db->group_by('DATE(member_join_datetime)');
    	$this->db->order_by('member_join_datetime', 'ASC');
    	$this->db->select('DATE(member_join_datetime) as join_date');
    	$q = $this->db->get('sys_member');
    	if ($q->num_rows() > 0) {
    		foreach ($q->result() as $row) {
    			// if register date is NOT today, then do it
    			if ($row->join_date != $this->date) {
    				// rekap daily
	    			$this->rekap_daily_bonus($row->join_date);
    			}
    		}
    	}
    }

    
}