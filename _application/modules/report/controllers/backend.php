<?php

/*
 * Backend Report Controller
 *
 * @author	Agus Heriyanto
 * @editor  Fahrur Rifai
 * @copyright	Copyright (c) 2017, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('report/backend_report_model');
        $this->load->helper('form');
        $this->today = date('Y-m-d');
        $this->day = date('d');
        $this->month = date('m');
        $this->year = date('Y');
    }

    /* REWARD REPORT */
    function reward() {
        $data['arr_breadcrumbs'] = array(
            'Laporan' => '#',
            'Laporan Data Reward' => 'backend/report/reward',
        );
        $data['service_url'] = base_url('backend/report/get_reward_log_data');
        template('backend', 'report/backend_report_reward_view', $data);
    }

    function get_reward_log_data() {
        include_once(dirname(__FILE__) . "/backend_service_reward.php");
        $this->backend_service = new Backend_service_reward();
        $this->backend_service->get_reward_log_data_service();
    }

    function export_reward_data() {
        include_once(dirname(__FILE__) . "/backend_service_reward.php");
        $this->backend_service = new Backend_service_reward();
        $this->backend_service->export_data();
    }
    /* END REWARD REPORT */

    function financial($period='global') {
        include_once(dirname(__FILE__) . "/backend_service_financial.php");
        $this->backend_service = new Backend_service_financial();
        $this->backend_service->financial_report($period);
    }

    function index() {
        $this->show();
    }

    function member() {
        $data['arr_breadcrumbs'] = array(
            'Laporan' => '#',
            'Laporan Data Member' => 'backend/report/member',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();
        $data['serial_type_grid_options'] = $this->mlm_function->get_serial_type_grid_options();
        $data['serial_type_count'] = $this->mlm_function->get_count_serial_type();
        
        template('backend', 'report/backend_report_member_view', $data);
    }

    function get_member_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "view_member";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //detail
            $detail = '<a href="' . base_url() . 'backend/report/member_detail/' . $row->network_id . '"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Data Detail" title="Lihat Data Detail" /></a>';
            
            $entry = array('id' => $row->network_id,
                'cell' => array(
                    'network_id' => $row->network_id,
                    'network_code' => $row->network_code,
                    'network_position' => $row->network_position,
                    'network_position_text' => $row->network_position_text,
                    'network_total_downline_left' => $this->function_lib->set_number_format($row->network_total_downline_left),
                    'network_total_downline_right' => $this->function_lib->set_number_format($row->network_total_downline_right),
                    'member_name' => stripslashes($row->member_name),
                    'member_nickname' => $row->member_nickname,
                    'member_phone' => $row->member_phone,
                    'member_mobilephone' => $row->member_mobilephone,
                    'member_join_datetime' => convert_datetime($row->member_join_datetime, 'id'),
                    'member_last_login' => convert_datetime($row->member_last_login, 'id'),
                    'member_city_name' => $row->member_city_name,
                    'member_province_name' => $row->member_province_name,
                    'member_region_name' => $row->member_region_name,
                    'member_country_name' => $row->member_country_name,
                    'member_bank_name' => $row->member_bank_name,
                    'member_bank_city' => $row->member_bank_city,
                    'member_bank_branch' => $row->member_bank_branch,
                    'member_bank_account_name' => stripslashes($row->member_bank_account_name),
                    'member_bank_account_no' => $row->member_bank_account_no,
                    'member_serial_id' => $row->member_serial_id,
                    'member_serial_pin' => $row->member_serial_pin,
                    'member_serial_type_label' => $row->member_serial_type_label,
                    'sponsor_network_code' => $row->sponsor_network_code,
                    'sponsor_member_name' => $row->sponsor_member_name,
                    'sponsor_member_nickname' => $row->sponsor_member_nickname,
                    'upline_network_code' => $row->upline_network_code,
                    'upline_member_name' => $row->upline_member_name,
                    'upline_member_nickname' => $row->upline_member_nickname,
                    'member_is_active' => $is_active,
                    'detail' => $detail,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function member_detail() {
        $this->load->model('member/backend_member_model');
        $detail_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Laporan' => '#',
            'Laporan Data Member' => 'backend/report/member',
            'Detail Data Member' => 'backend/report/member_detail/' . $detail_id,
        );
        
        $data['query'] = $this->backend_member_model->get_detail($detail_id);

        template('backend', 'report/backend_report_member_detail_view', $data);
    }
    
    function serial() {
        $data['arr_breadcrumbs'] = array(
            'Laporan' => '#',
            'Laporan Data Serial' => 'backend/report/serial',
        );
        
        $data['serial_type_grid_options'] = $this->mlm_function->get_serial_type_grid_options();
        $data['serial_type_count'] = $this->mlm_function->get_count_serial_type();
        
        template('backend', 'report/backend_report_serial_view', $data);
    }

    function get_serial_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "view_serial";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_active
            if ($row->serial_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'tick.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'tick-red.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //is_sold
            if ($row->serial_is_sold == '1') {
                $stat = 'Terjual';
                $image_stat = 'tick.png';
            } else {
                $stat = 'Belum Terjual';
                $image_stat = 'tick-red.png';
            }
            $is_sold = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //is_used
            if ($row->serial_is_used == '1') {
                $stat = 'Terpakai';
                $image_stat = 'tick.png';
            } else {
                $stat = 'Belum Terpakai';
                $image_stat = 'tick-red.png';
            }
            $is_used = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->serial_id,
                'cell' => array(
                    'serial_id' => $row->serial_id,
                    'serial_pin' => $row->serial_pin,
                    'serial_network_code' => $row->serial_network_code,
                    'serial_type_label' => $row->serial_type_label,
                    'serial_is_sold' => $is_sold,
                    'serial_is_active' => $is_active,
                    'serial_is_used' => $is_used,
                    'serial_create_datetime' => convert_datetime($row->serial_create_datetime, 'id'),
                    'create_administrator_id' => $row->create_administrator_id, 
                    'create_administrator_username' => $row->create_administrator_username, 
                    'create_administrator_name' => $row->create_administrator_name, 
                    'serial_activation_datetime' => convert_datetime($row->serial_activation_datetime, 'id'),
                    'activation_administrator_id' => $row->activation_administrator_id, 
                    'activation_administrator_username' => $row->activation_administrator_username, 
                    'activation_administrator_name' => $row->activation_administrator_name, 
                    'serial_buyer_datetime' => convert_datetime($row->serial_buyer_datetime, 'id'),
                    'buyer_network_code' => $row->buyer_network_code,
                    'buyer_member_name' => stripslashes($row->buyer_member_name),
                    'buyer_member_nickname' => $row->buyer_member_nickname,
                    'buyer_member_phone' => $row->buyer_member_phone,
                    'buyer_member_mobilephone' => $row->buyer_member_mobilephone,
                    'serial_user_datetime' => convert_datetime($row->serial_user_datetime, 'id'),
                    'user_network_code' => $row->user_network_code,
                    'user_member_name' => stripslashes($row->user_member_name),
                    'user_member_nickname' => $row->user_member_nickname,
                    'user_member_phone' => $row->user_member_phone,
                    'user_member_mobilephone' => $row->user_member_mobilephone,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function member_activation(){
        $data['arr_breadcrumbs'] = array(
            'Laporan' => '#',
            'Laporan Aktivasi Member' => 'backend/report/member_activation',
        );
        
        template('backend', 'report/backend_report_member_activation_view', $data);
    }
    
    function get_member_activation_data(){
        $params = isset($_POST) ? $_POST : array();
        $params['select'] = "
            serial_user_serial_id,
            DATE(serial_user_datetime) AS serial_user_date,
            COUNT(*) AS serial_user_count
        ";
        $params['table'] = "sys_serial_user";
        $params['group_by_detail'] = "serial_user_date";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            $entry = array('id' => $row->serial_user_serial_id,
                'cell' => array(
                    'serial_user_date' => convert_date($row->serial_user_date, 'id'),
                    'serial_user_count' => $this->function_lib->set_number_format($row->serial_user_count),   
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function bonus_log() {
        $data['arr_breadcrumbs'] = array(
            'Laporan' => '#',
            'Laporan History Bonus' => 'backend/report/bonus_log',
        );
        
        $data['arr_active_bonus'] = $this->mlm_function->get_arr_active_bonus();
        template('backend', 'report/backend_report_bonus_log_view', $data);
    }
    
    function get_bonus_log_data() {
        $arr_active_bonus = $this->mlm_function->get_arr_active_bonus();
        $params = isset($_POST) ? $_POST : array();
        $query = $this->backend_report_model->get_query_bonus_log_data($params);
        $total = $this->backend_report_model->get_query_bonus_log_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        
        foreach ($query->result() as $row) {

            $entry = array('id' => $row->bonus_log_id,
                'cell' => array(
                    'bonus_log_id' => $row->bonus_log_id,
                    'bonus_log_date' => convert_date($row->bonus_log_date, 'id'),
                ),
            );
            
            if(is_array($arr_active_bonus)) {
                foreach($arr_active_bonus as $bonus_item) {
                    $field_in = 'bonus_log_' . $bonus_item['name'] . '_in';
                    $field_out = 'bonus_log_' . $bonus_item['name'] . '_out';
                    $field_saldo = 'bonus_log_' . $bonus_item['name'] . '_saldo';
                    
                    $entry['cell'][$field_in] = $this->function_lib->set_number_format($row->$field_in);
                    $entry['cell'][$field_out] = $this->function_lib->set_number_format($row->$field_out);
                    $entry['cell'][$field_saldo] = $this->function_lib->set_number_format($row->$field_saldo);
                }
            }
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function bonus_transfer_log() {
        $data['arr_breadcrumbs'] = array(
            'Laporan' => '#',
            'Laporan History Transfer Bonus' => 'backend/report/bonus_transfer_log',
        );
        
        template('backend', 'report/backend_report_bonus_transfer_log_view', $data);
    }
    
    function get_bonus_transfer_log_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "view_bonus_transfer";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        
        foreach ($query->result() as $row) {
            
            //detail
            $detail = '<a target="_blank" href="' . base_url() . 'backend/report/bonus_transfer_log_excel/' . strtotime($row->bonus_transfer_datetime) . '"><img src="' . base_url() . _dir_icon . 'page_excel.png" border="0" alt="Download Detail" title="Download Detail" /></a>';

            $entry = array('id' => $row->bonus_transfer_id,
                'cell' => array(
                    'bonus_transfer_category' => $row->bonus_transfer_category,
                    'bonus_transfer_category_text' => $row->bonus_transfer_category_text,
                    'bonus_transfer_type' => $row->bonus_transfer_type,
                    'bonus_transfer_type_text' => $row->bonus_transfer_type_text,
                    'bonus_transfer_datetime' => convert_datetime($row->bonus_transfer_datetime, 'id'),
                    'total_bonus_transfer_total_bonus' => $this->function_lib->set_number_format($row->total_bonus_transfer_total_bonus),
                    'total_bonus_transfer_adm_charge' => $this->function_lib->set_number_format($row->total_bonus_transfer_adm_charge),
                    'total_bonus_transfer_nett' => $this->function_lib->set_number_format($row->total_bonus_transfer_nett),
                    'count_bonus_transfer' => $this->function_lib->set_number_format($row->count_bonus_transfer),
                    'count_bonus_transfer_pending' => $this->function_lib->set_number_format($row->count_bonus_transfer_pending),
                    'count_bonus_transfer_failed' => $this->function_lib->set_number_format($row->count_bonus_transfer_failed),
                    'count_bonus_transfer_success' => $this->function_lib->set_number_format($row->count_bonus_transfer_success),
                    'detail' => $detail
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function bonus_transfer_log_excel($strtotime = '') {
        if($strtotime != '') {
            $this->load->model('bonus_transfer/backend_bonus_transfer_model');
            $datetime = date("Y-m-d H:i:s", $strtotime);
            $title = 'Transfer Bonus Periode ' . convert_datetime($datetime, 'id');
            $filename = url_title($title) . '-' . date("YmdHis");
            $unprotected_password = '1q2w3e4r5t';
            
            $this->CI->load->library('Excel');
            $arr_bonus = $this->mlm_function->get_arr_transfer_bonus_active($datetime);
            
            $arr_style_title = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'EEEEEE')
                ),
                'alignment' => array(
                    'wrap' => true,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );
            
            $arr_style_content = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'wrap' => true,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );
            
            $arr_style['pending'] = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FBF9CD')
                ),
            );
            
            $arr_style['success'] = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'B3F6CB')
                ),
            );
            
            $arr_style['failed'] = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FBCDCD')
                ),
            );
            
            $first_column = $cell_column = 'A';
            $first_row = $cell_row = 1;
            $excel = new PHPExcel();
            $excel->getProperties()->setTitle($title)->setSubject($title);
            $excel->getActiveSheet()->setTitle(substr($title, 0, 31));
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getDefaultStyle()->getFont()->setName('Calibri');
            $excel->getDefaultStyle()->getFont()->setSize(10);
            $excel->getActiveSheet()->getProtection()->setPassword($unprotected_password);
            $excel->getActiveSheet()->getProtection()->setSheet(true);

            //title
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setSize(13);
            $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, strtoupper($title));
            $cell_row++;
            $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, 'Tanggal Export : ' . convert_datetime(date("Y-m-d H:i:s"), 'id'));
            $cell_row++;
            $cell_row++;
            
            $arr_row_title[] = array('label' => 'Kode Transfer', 'width' => 20, 'visible' => true);
            $arr_row_title[] = array('label' => 'Status', 'width' => 13, 'visible' => true);
            $arr_row_title[] = array('label' => 'Keterangan', 'width' => 40, 'visible' => true);
            $arr_row_title[] = array('label' => 'Kode Member', 'width' => 20, 'visible' => true);
            $arr_row_title[] = array('label' => 'Nama Member', 'width' => 30, 'visible' => true);
            $arr_row_title[] = array('label' => 'No. Handphone', 'width' => 20, 'visible' => false);
            $arr_row_title[] = array('label' => 'Bank', 'width' => 20, 'visible' => true);
            $arr_row_title[] = array('label' => 'Kota Bank', 'width' => 20, 'visible' => false);
            $arr_row_title[] = array('label' => 'Cabang', 'width' => 20, 'visible' => false);
            $arr_row_title[] = array('label' => 'Nama Nasabah', 'width' => 30, 'visible' => true);
            $arr_row_title[] = array('label' => 'No. Rekening', 'width' => 20, 'visible' => true);
            if(is_array($arr_bonus)) {
                foreach ($arr_bonus as $bonus_item) {
                    $bonus_label = $this->mlm_function->get_bonus_label($bonus_item);
                    $bonus_label_width = 1.5 * strlen($bonus_label) + 0.6;
                    $arr_row_title[] = array('label' => $bonus_label, 'width' => $bonus_label_width, 'visible' => false);
                }
            }
            $arr_row_title[] = array('label' => 'Total Bonus', 'width' => 20, 'visible' => false);
            $arr_row_title[] = array('label' => 'Potongan Adm', 'width' => 20, 'visible' => false);
            $arr_row_title[] = array('label' => 'Total Transfer', 'width' => 20, 'visible' => true);
            
            $cell_column = $first_column;
            if(is_array($arr_row_title)) {
                $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(20);
                foreach($arr_row_title as $row_title_id => $row_title_data) {
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_title);
                    $excel->getActiveSheet()->getColumnDimension($cell_column)->setWidth($row_title_data['width'])->setVisible($row_title_data['visible']);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row_title_data['label']), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                }
            }
            $cell_row++;
            
            $query = $this->backend_bonus_transfer_model->get_list_bonus_transfer_by_datetime($datetime);
            if($query->num_rows() > 0) {
                $grandtotal_total_bonus = 0;
                $grandtotal_adm_charge = 0;
                $grandtotal_nett = 0;
                
                if(is_array($arr_bonus)) {
                    foreach ($arr_bonus as $bonus_item) {
                        $grandtotal[$bonus_item] = 0;
                    }
                }
                
                foreach ($query->result() as $row) {
                    $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(17);
                    $cell_column = $first_column;
                    $grandtotal_total_bonus += $row->bonus_transfer_total_bonus;
                    $grandtotal_adm_charge += $row->bonus_transfer_adm_charge;
                    $grandtotal_nett += $row->bonus_transfer_nett;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('center');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row->bonus_transfer_code), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('center');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style[$row->bonus_transfer_status]);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row->bonus_transfer_status_label), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $row->bonus_transfer_note, PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('center');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row->network_code), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper(stripslashes($row->member_name)), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row->bonus_transfer_mobilephone), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row->bonus_transfer_bank_name), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row->bonus_transfer_bank_city), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row->bonus_transfer_bank_branch), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper(stripslashes($row->bonus_transfer_bank_account_name)), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row->bonus_transfer_bank_account_no), PHPExcel_Cell_DataType::TYPE_STRING);
                    $cell_column++;
                    
                    if(is_array($arr_bonus)) {
                        foreach($arr_bonus as $bonus_item) {
                            $field = 'bonus_transfer_detail_' . $bonus_item;
                            $grandtotal[$bonus_item] += $row->$field;
                            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('right');
                            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                            $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $row->$field, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode('#,##0');
                            $cell_column++;
                        }
                    }
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('right');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $row->bonus_transfer_total_bonus, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode('#,##0');
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('right');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $row->bonus_transfer_adm_charge, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode('#,##0');
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('right');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $row->bonus_transfer_nett, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode('#,##0');
                    $cell_column++;
                    
                    $cell_row++;
                }
                $cell_column = $first_column;
                
                //grand total
                $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(20);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('right');
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, 'GRAND TOTAL', PHPExcel_Cell_DataType::TYPE_STRING);
                $merge_grandtotal_start = $cell_column . $cell_row;
                $cell_column++;
                $cell_column++;
                $cell_column++;
                $cell_column++;
                $cell_column++;
                $cell_column++;
                $cell_column++;
                $cell_column++;
                $cell_column++;
                $cell_column++;
                $cell_column++;
                $merge_grandtotal_end = $cell_column . $cell_row;
                $excel->setActiveSheetIndex(0)->mergeCells($merge_grandtotal_start . ':' . $merge_grandtotal_end);
                $excel->getActiveSheet()->getStyle($merge_grandtotal_start . ':' . $merge_grandtotal_end)->applyFromArray($arr_style_title);
                
                if(is_array($arr_bonus)) {
                    foreach($arr_bonus as $bonus_item) {
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('right');
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_title);
                        $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $grandtotal[$bonus_item], PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode('#,##0');
                        $cell_column++;
                    }
                }
                
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('right');
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_title);
                $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $grandtotal_total_bonus, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode('#,##0');
                $cell_column++;
                
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('right');
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_title);
                $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $grandtotal_adm_charge, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode('#,##0');
                $cell_column++;
                
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('right');
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_title);
                $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $grandtotal_nett, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode('#,##0');
                $cell_column++;
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $write->save('php://output');
            exit;
        }
    }

}
