<?php

/*
 * Cron Member Api
 *
 * @author	Yonkz Tamvan
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Members extends MY_Controller {

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
        //$this->load->model('cron_common_model');
    }

    public function members_api($month = '', $year = '') {


        $apikey = 'k0pr7684LJoN011';
        $cek_apikey = $_GET['apikey'];
        // $cek_apikey = 'k0pr7684LJoN011';

        $this_month = date('m');
        $this_year = date('Y');



        if ($apikey == $cek_apikey) {
            $valid_apikey = TRUE;
        } else {
            $valid_apikey = FALSE;
        }

        if ($valid_apikey == TRUE) {

            if (empty($_GET)) {



                $temp_summary = array();

                $temp_summary['total_member'] = number_format(function_lib::get_one("count(*)", "sys_network", "network_id != 0"));

                $summary[] = $temp_summary;


                $data = array(
                    "status" => 200,
                    "data" => array(
                        "summary" => $summary
                    ),
                );
            } else {

//                $month = $_GET['month'];
//                $year = $_GET['year'];

                $data = array();
                $temp = array();
                $no = 1;


                $temp_summary = array();

                $temp_summary['total_peringkat_star_leader'] = $this->db->query("SELECT COUNT(*) as total
                                 FROM log_grade WHERE log_grade_profit_sharing_grade_id = 1 ")->row()->total;
                
                $temp_summary['total_peringkat_team_leader'] = $this->db->query("SELECT COUNT(*) as total
                                 FROM log_grade WHERE log_grade_profit_sharing_grade_id = 2 ")->row()->total;
                
                $temp_summary['total_peringkat_supervisor'] = $this->db->query("SELECT COUNT(*) as total
                                 FROM log_grade WHERE log_grade_profit_sharing_grade_id = 3 ")->row()->total;

                 $temp_summary['total_peringkat_manager'] = $this->db->query("SELECT COUNT(*) as total
                                 FROM log_grade WHERE log_grade_profit_sharing_grade_id = 4 ")->row()->total;
                
                 $temp_summary['total_peringkat_general_manager'] = $this->db->query("SELECT COUNT(*) as total
                                 FROM log_grade WHERE log_grade_profit_sharing_grade_id = 5 ")->row()->total;
                 
                 $temp_summary['total_peringkat_busines_director'] = $this->db->query("SELECT COUNT(*) as total
                                 FROM log_grade WHERE log_grade_profit_sharing_grade_id = 6 ")->row()->total;



                $temp_summary['total_member'] = number_format($this->CI->function_lib->get_one("sys_network", "count(*)", "network_id != 0"));
                $last_join = $this->CI->db->query("SELECT COUNT(*) as last_join FROM sys_member WHERE MONTH(member_join_datetime) = '" . $this_month . "' AND YEAR(member_join_datetime) = '" . $this_year . "' ");
                if ($last_join->num_rows() > 0) {
                    $row = $last_join->row();
                    $temp_summary['last_join'] = $row->last_join . " Member (" . convert_month($this_month, 'text', '', 'ina') . " " . $this_year . ")";
                }

                $sql_total_serial = $this->CI->db->query("SELECT COUNT(*) as total_join FROM sys_serial GROUP BY serial_create_datetime ORDER BY serial_create_datetime DESC LIMIT 1");


                if ($sql_total_serial->num_rows() > 0) {
                    $row = $sql_total_serial->row();
                    $last_total_create_serial = $row->total_join;
                }
                $sql_date_create_serial = $this->CI->db->query("SELECT serial_create_datetime FROM sys_serial GROUP BY serial_create_datetime ORDER BY serial_create_datetime DESC LIMIT 1");
                if ($sql_date_create_serial->num_rows() > 0) {
                    $row = $sql_date_create_serial->row();
                    $last_date_create_serial = $row->serial_create_datetime;
                }

//
                $temp_summary['last_created_serial'] = $last_total_create_serial . " Member (" . convert_datetime($last_date_create_serial, 'text', '') . ")";


                $summary[] = $temp_summary;


                //MemberJoin
                $temp_member = array();
                $sql = "SELECT COUNT(*) AS TOTAL, LEFT(member_join_datetime, 7), MONTH(member_join_datetime) AS MONTH, YEAR(member_join_datetime) AS YEAR FROM sys_member GROUP BY LEFT(member_join_datetime, 7) DESC LIMIT 3 ";
                $query = $this->CI->db->query($sql);

                if ($query->num_rows() > 0) {
                    foreach ($query->result() as $row) {
                        $temp_member['year'] = $row->YEAR;
                        $temp_member['month'] = $row->MONTH;
                        $temp_member['total'] = number_format($row->TOTAL);

                        $data_month[] = $temp_member;
                    }
                }


                $data = array(
                    "status" => 200,
                    "data" => array(
                        "summary" => $summary,
                        "Registrasi" => $data_month
                    ),
                );
            }
        } else {
            $data['status'] = False;
            $data['message'] = 'Tidak diketahui';
        }

        echo json_encode($data);
    }

}

?>
