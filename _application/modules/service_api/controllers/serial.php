<?php

/*
 * Cron Serial Api
 *
 * @author	Yonkz Tamvan
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Serial extends MY_Controller {

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

    public function serialsapi($month = '06', $year = '2016') {
       

        $apikey = 'k0pr7684LJoN011';
        $cek_apikey = $_GET['apikey'];
        // $cek_apikey = 'k0pr7684LJoN011';


        if ($apikey == $cek_apikey) {
            $valid_apikey = TRUE;
        } else {
            $valid_apikey = FALSE;
        }

        if ($valid_apikey == TRUE) {

            if (empty($_GET)) {



                $data = array();
                $temp = array();
                $no = 1;

                
                $this->CI->function_lib->get_one("sys_serial_type", "serial_type_name", "serial_type_is_active  = 1");

                $temp['serial_create'] = $this->CI->function_lib->get_one("sys_serial", "COUNT(serial_id)", "MONTH(serial_create_datetime)='" . $month . "'");
                $temp['serial_is_activation'] = $this->CI->function_lib->get_one("sys_serial_activation", "COUNT(serial_activation_serial_id)", "MONTH(serial_activation_datetime)='" . $month . "' AND YEAR(serial_activation_datetime) = '" . $year . "'   ");
                $temp['serial_is_sold'] = $this->CI->function_lib->get_one("sys_serial_buyer", "COUNT(serial_buyer_serial_id)", "MONTH(serial_buyer_datetime)='" . $month . "' AND YEAR(serial_buyer_datetime) = '" . $year . "' ");
                $temp['serial_is_used'] = $this->CI->function_lib->get_one("sys_serial", "COUNT(serial_id)", "MONTH(serial_create_datetime)='" . $month . "' AND serial_is_used  = 1 ");

                $data_month[] = $temp;

                //summary
                $temp_summary = array();
                $temp_summary['type_serial'] = $this->CI->function_lib->get_one("sys_serial_type", "serial_type_name", "serial_type_is_active  = 1 ");
                $temp_summary['serial_create'] = $this->CI->function_lib->get_one("sys_serial", "COUNT(serial_id)");
                $temp_summary['serial_activation'] = $this->CI->function_lib->get_one("sys_serial_activation", "COUNT(serial_activation_serial_id)", "");
                $temp_summary['serial_sold'] = $this->CI->function_lib->get_one("sys_serial_buyer", "COUNT(serial_buyer_serial_id)", "");
                $temp_summary['serial_used'] = $this->CI->function_lib->get_one("sys_serial", "COUNT(serial_id)", "serial_is_used  = 1 ");
                $summary[] = $temp_summary;

                $month = convert_month($month, 'text', '', 'ina');
                $data = array(
                    "status" => 200,
                    "data" => array(
                        'year' => $year,
                        'month' => $month,
                        "selling" => $data_month,
                    ),
                    "summary" => $summary
                );

            } else {
                
                $month = $_GET['month'];
                $year = $_GET['year'];
                
                $data = array();
                $temp = array();
                $no = 1;


                $temp['type_serial'] = $this->CI->function_lib->get_one("sys_serial_type", "serial_type_name", "serial_type_is_active  = 1 ");

                $temp['serial_create'] = $this->CI->function_lib->get_one("sys_serial", "COUNT(serial_id)", "MONTH(serial_create_datetime)='" . $month . "'");
                $temp['serial_is_activation'] = $this->CI->function_lib->get_one("sys_serial_activation", "COUNT(serial_activation_serial_id)", "MONTH(serial_activation_datetime)='" . $month . "' AND YEAR(serial_activation_datetime) = '" . $year . "'   ");
                $temp['serial_is_sold'] = $this->CI->function_lib->get_one("sys_serial_buyer", "COUNT(serial_buyer_serial_id)", "MONTH(serial_buyer_datetime)='" . $month . "' AND YEAR(serial_buyer_datetime) = '" . $year . "' ");
                $temp['serial_is_used'] = $this->CI->function_lib->get_one("sys_serial", "COUNT(serial_id)", "MONTH(serial_create_datetime)='" . $month . "' AND serial_is_used  = 1 ");

                $data_month[] = $temp;

                //summary
                $temp_summary = array();
                $temp_summary['type_serial'] = $this->CI->function_lib->get_one("sys_serial_type", "serial_type_name", "serial_type_is_active  = 1 ");
                $temp_summary['serial_create'] = $this->CI->function_lib->get_one("sys_serial", "COUNT(serial_id)");
                $temp_summary['serial_activation'] = $this->CI->function_lib->get_one("sys_serial_activation", "COUNT(serial_activation_serial_id)", "");
                $temp_summary['serial_sold'] = $this->CI->function_lib->get_one("sys_serial_buyer", "COUNT(serial_buyer_serial_id)", "");
                $temp_summary['serial_used'] = $this->CI->function_lib->get_one("sys_serial", "COUNT(serial_id)", "serial_is_used  = 1 ");
                $summary[] = $temp_summary;

                $month = convert_month($month, 'text', '', 'ina');
                $data = array(
                    "status" => 200,
                    "data" => array(
                        'year' => $year,
                        'month' => $month,
                        "selling" => $data_month,
                    ),
                    "summary" => $summary
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
