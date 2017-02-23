<?php

/*
 * Backend Report Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service_reward extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('report/backend_report_model');
        $this->load->helper('form');
    }

    function index() {
        // do nothing
    }

    function get_reward_log_data_service() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->get_member_reward_data($params);
        $total = $this->get_member_reward_data($params, true);

        header("Content-type: application/json");
        // print_r(json_encode($query->result()));die();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $max = isset($_POST['rp']) ? $_POST['rp'] : 10;
        $num = (($page-1)*$max)+1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        $administrator = array('-'=>'-');
        foreach ($query->result() as $row) {
            
            //status
            if ($row->reward_qualified_status == 'approved') {
                $status = '<span class="btn btn-success" style="width:80px; padding:2px 5px !important; font-size:7pt; cursor:default;">' . strtoupper($row->reward_qualified_status) . '</span>';
            } else if($row->reward_qualified_status == 'rejected') {
                $status = '<span class="btn btn-danger" style="width:80px; padding:2px 5px !important; font-size:7pt; cursor:default;">' . strtoupper($row->reward_qualified_status) . '</span>';
            } else {
                $status = '<span class="btn btn-warning" style="width:80px; padding:2px 5px !important; font-size:7pt; cursor:default;">' . strtoupper($row->reward_qualified_status) . '</span>';
            }

            if ( ! isset($administrator[$row->administrator_id])) {
                $administrator[$row->administrator_id] = $row->administrator_name;
            }
            
            $entry = array('id' => $row->reward_qualified_id,
                'cell' => array(
                    'no' => $num++,
                    'network_code' => $row->network_code,
                    'member_name' => stripslashes($row->member_name),
                    'reward_cond_node_left' => $this->function_lib->set_number_format($row->reward_cond_node_left),
                    'reward_cond_node_right' => $this->function_lib->set_number_format($row->reward_cond_node_right),
                    'reward_qualified_condition_node_left' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_left),
                    'reward_qualified_condition_node_right' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_right),
                    'reward_qualified_reward_bonus' => $row->reward_qualified_reward_bonus,
                    'reward_qualified_status' => $status,
                    'reward_qualified_status_raw' => $row->reward_qualified_status,
                    'reward_qualified_date' => convert_date($row->reward_qualified_date, 'id'),
                    'claim_datetime' => date_converter($row->claim_datetime, 'd F Y H:i:s'),
                    'process_date' => (($row->process_date != '-') ? date_converter($row->process_date, 'd F Y H:i:s') : '-'),
                    'administrator_name' => $administrator[$row->administrator_id],
                ),
            );
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function get_member_reward_data($params, $count=false) {
        extract($this->function_lib->get_query_condition($params, $count));
                if ($count) {
                    $parent_select = "COUNT(*) AS row_count";
                } else {
                    $parent_select = "*";
                }
                $sql = "SELECT
                    $parent_select
                    FROM (
                        SELECT 
                            *,
                            IF(reward_qualified_status = 'pending', '-', status_datetime) as process_date,
                            IF(reward_qualified_status = 'pending', '-', status_administrator_id) as administrator_id,
                            IF(reward_qualified_status = 'pending', '-', status_administrator_name) as administrator_name
                            FROM (
                            SELECT 
                                sys_member.member_name, 
                                sys_network.network_code, 
                                sys_reward.*,
                                sys_reward_qualified.*,
                                (   
                                 SELECT reward_qualified_status_datetime FROM sys_reward_qualified_status
                                 WHERE reward_qualified_status_reward_qualified_id = reward_qualified_id
                                 ORDER BY reward_qualified_status_id ASC LIMIT 1
                                ) as claim_datetime,
                                (   
                                 SELECT reward_qualified_status_datetime FROM sys_reward_qualified_status
                                 WHERE reward_qualified_status_reward_qualified_id = reward_qualified_id
                                 ORDER BY reward_qualified_status_id DESC LIMIT 1
                                ) as status_datetime,
                                (   
                                 SELECT reward_qualified_status_administrator_id FROM sys_reward_qualified_status
                                 WHERE reward_qualified_status_reward_qualified_id = reward_qualified_id
                                 ORDER BY reward_qualified_status_id DESC LIMIT 1
                                ) as status_administrator_id,
                                (   
                                 SELECT reward_qualified_status_administrator_name FROM sys_reward_qualified_status
                                 WHERE reward_qualified_status_reward_qualified_id = reward_qualified_id
                                 ORDER BY reward_qualified_status_id DESC LIMIT 1
                                ) as status_administrator_name
                                FROM sys_reward_qualified
                                INNER JOIN sys_reward ON reward_qualified_reward_id = reward_id
                                INNER JOIN sys_network ON network_id = reward_qualified_network_id
                                INNER JOIN sys_member ON member_network_id = reward_qualified_network_id
                            ) as result
                    ) as results
                    $where 
                    $group_by 
                    $sort
                    $limit
                ";

                $query = $this->db->query($sql);
                
                if($count) {
                    $row = $query->row();
                    return $row->row_count;
                } else {
                    return $query;
                }

    }

    function export_data() {
        $params = isset($_POST) ? $_POST : array();
        
        $data = array();
        $data['title'] = 'Data Reward Member';
        $data['params'] = $params;
        $query = $this->get_member_reward_data($params);
        if ($query->num_rows() > 0) {
            $administrator = array('-'=>'-');
            $page=1;
            foreach ($query->result() as $row) {
                //status
                if ( ! isset($administrator[$row->administrator_id])) {
                    $administrator[$row->administrator_id] = $row->administrator_name;
                }
                
                $entry = array(
                    'no' => $page++,
                    'network_code' => $row->network_code,
                    'member_name' => $row->member_name,
                    'reward_cond_node_left' => $this->function_lib->set_number_format($row->reward_cond_node_left),
                    'reward_cond_node_right' => $this->function_lib->set_number_format($row->reward_cond_node_right),
                    'reward_qualified_condition_node_left' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_left),
                    'reward_qualified_condition_node_right' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_right),
                    'reward_qualified_reward_bonus' => $row->reward_qualified_reward_bonus,
                    'reward_qualified_status' => strtoupper($row->reward_qualified_status),
                    'reward_qualified_status_raw' => $row->reward_qualified_status,
                    'reward_qualified_date' => convert_date($row->reward_qualified_date, 'id'),
                    'claim_datetime' => date_converter($row->claim_datetime, 'd F Y H:i:s'),
                    'process_date' => (($row->process_date != '-') ? date_converter($row->process_date, 'd F Y H:i:s') : '-'),
                    'administrator_name' => $administrator[$row->administrator_id]
                );
                
                $data['query'][] = (object) $entry;
            } 
        } else {
            $data['query'] = array();
        }
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->export_excel_data($data);
    }

    function export_excel_data($data = false) {
        if ($data) {
            $this->CI->load->library('Excel');

            // Initiate cache
            $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
            $cacheSettings = array('memoryCacheSize' => '32MB');
            PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

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

            extract($data);
            
            $filename = url_title($title) . '-' . date("YmdHis");
            $arr_column_name = json_decode($column['name']);
            $arr_column_show = json_decode($column['show']);
            $arr_column_align = json_decode($column['align']);
            $arr_column_title = json_decode($column['title']);

            $first_column = $cell_column = 'A';
            $cell_row = $first_row = 1;
            $excel = new PHPExcel();
            $excel->getProperties()->setTitle($title)->setSubject($title);
            $excel->getActiveSheet()->setTitle(substr($title, 0, 31));
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getDefaultStyle()->getFont()->setName('Calibri');
            $excel->getDefaultStyle()->getFont()->setSize(10);

            //title
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setSize(13);
            $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, strtoupper($title));
            $cell_row++;
            $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, 'Tanggal Export : ' . convert_datetime(date("Y-m-d H:i:s"), 'id'));
            $cell_row++;
            $cell_row++;

            if (is_array($arr_column_title)) {
                $cell_column = $first_column;
                $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(20);
                foreach ($arr_column_title as $id => $value) {
                    if ($arr_column_show[$id] == true) {
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_title);
                        $excel->getActiveSheet()->getColumnDimension($cell_column)->setWidth(ceil(1.5 * strlen($value) + 0.6));

                        $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, strtoupper($value));
                        $cell_column++;
                    }
                }
                $cell_row++;
            }

            foreach ($query as $row) {
                $cell_column = $first_column;
                $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(17);
                foreach ($arr_column_name as $id => $value) {
                    if ($arr_column_show[$id] == true) {
                        if (!isset($row->$value)) {
                            $data = '';
                        } else {
                            $data = $row->$value;
                        }
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal($arr_column_align[$id]);
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                        $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                        $cell_column++;
                    }
                }
                $cell_row++;
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