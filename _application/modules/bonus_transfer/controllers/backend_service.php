<?php

/*
 * Backend Service Bonus Transfer Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('bonus_transfer/backend_bonus_transfer_model');
        $this->load->helper('form');
        $this->config->load('transfer');
        $this->config->load('bonus');
    }
    
    function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "view_bonus_transfer";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        
        foreach ($query->result() as $row) {
            
            //detail
            $detail = '<a target="_blank" href="' . base_url() . 'backend_service/bonus_transfer/generate_excel/' . strtotime($row->bonus_transfer_datetime) . '"><img src="' . base_url() . _dir_icon . 'page_excel.png" border="0" alt="Download Detail" title="Download Detail" /></a>';
            $pending = '<a target="_blank" href="' . base_url() . 'backend_service/bonus_transfer/pending_generate_excel/' . strtotime($row->bonus_transfer_datetime) . '"><img src="' . base_url() . _dir_icon . 'page_excel.png" border="0" alt="Download Detail" title="Download Detail Pending" /></a>';

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
                    'detail' => $detail,
                    'pending' => $pending
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function act_add($category = '') {
        
        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';
        $date = date("Y-m-d");
        $datetime = date("Y-m-d H:i:s");
        $administrator_id = $this->session->userdata('administrator_id');
        $is_error = false;

        //submit
        if ($this->input->post('submit') != FALSE) {
            $arr_all_transfer_config = $this->config->item('transfer');
            $arr_transfer_config = $arr_all_transfer_config[$category];
            $arr_bonus = $arr_transfer_config['arr_bonus'];
            
            if(isset($_POST)) {
                foreach($_POST as $id => $value) {
                    $params[$id] = $value;
                }
            }
            
            $query = $this->backend_bonus_transfer_model->get_query_preview_data($category, $params);
            if($query->num_rows() > 0) {
                
                $this->db->trans_begin();

                // report summary bonus (pending)
                $data_report = array();
                if(is_array($arr_bonus)) {
                    foreach($arr_bonus as $bonus_item) {
                        $data_report[$bonus_item] = 0;
                    }
                }
                
                foreach($query->result() as $row) {
                    $bonus_transfer_code = $this->mlm_function->generate_bonus_transfer_code($date);
                    
                    $data = array();
                    $data['bonus_transfer_network_id'] = $row->network_id;
                    $data['bonus_transfer_category'] = $category;
                    $data['bonus_transfer_type'] = 'cash';
                    $data['bonus_transfer_code'] = $bonus_transfer_code;
                    $data['bonus_transfer_total_bonus'] = $row->bonus_total;
                    $data['bonus_transfer_adm_charge_percent'] = $row->adm_charge_percent;
                    $data['bonus_transfer_adm_charge'] = $row->adm_charge;
                    $data['bonus_transfer_nett'] = $row->nett;
                    $data['bonus_transfer_bank_id'] = $row->member_bank_id;
                    $data['bonus_transfer_bank_name'] = $row->member_bank_name;
                    $data['bonus_transfer_bank_account_name'] = $row->member_bank_account_name;
                    $data['bonus_transfer_bank_account_no'] = $row->member_bank_account_no;
                    $data['bonus_transfer_mobilephone'] = $row->member_mobilephone;
                    $data['bonus_transfer_status'] = 'pending';
                    $data['bonus_transfer_datetime'] = $datetime;
                    $bonus_transfer_id = $this->function_lib->insert_data('sys_bonus_transfer', $data);
                    
                    //cari data saldo per bonus log
                    $query_saldo = $this->backend_bonus_transfer_model->get_query_preview_detail_data($category, $row->network_id, $params);
                    if($query_saldo->num_rows() > 0) {
                        foreach($query_saldo->result() as $row_saldo) {
                            $data = array();
                            $data['bonus_transfer_detail_bonus_transfer_id'] = $bonus_transfer_id;
                            $data['bonus_transfer_detail_bonus_log_id'] = $row_saldo->bonus_log_id;
                            if(is_array($arr_bonus)) {
                                foreach($arr_bonus as $bonus_item) {
                                    $field = 'bonus_' . $bonus_item;
                                    $field_transfer = 'bonus_transfer_detail_' . $bonus_item;
                                    $data[$field_transfer] = $row_saldo->$field;

                                    // report summary bonus (pending)
                                    $data_report[$bonus_item] = $data_report[$bonus_item] + $row_saldo->$field;
                                }
                            }
                            $this->function_lib->insert_data('sys_bonus_transfer_detail', $data);
                            // update flag bonus log
                            $data = array();
                            $data['bonus_'.$category.'_is_transfered'] = 1;
                            $this->function_lib->update_data('sys_bonus_log', 'bonus_log_id', $row_saldo->bonus_log_id, $data);
                        }
                    }
                    
                    $data = array();
                    $data['bonus_transfer_status_bonus_transfer_id'] = $bonus_transfer_id;
                    $data['bonus_transfer_status_administrator_id'] = $administrator_id;
                    $data['bonus_transfer_status_status'] = 'pending';
                    $data['bonus_transfer_status_datetime'] = $datetime;
                    $this->function_lib->insert_data('sys_bonus_transfer_status', $data);

                    if(is_array($arr_bonus)) {
                        $data_summary_bonus = array();
                        $total_bonus_transfer = 0;
                        foreach ($arr_bonus as $bonus_item) {
                            $bonus_item_saldo = 'bonus_'.$bonus_item;
                            $data_summary_bonus['bonus_'.$bonus_item.'_paid'] = 'bonus_'.$bonus_item.'_paid + '.$row->$bonus_item_saldo;
                            $data_summary_bonus['bonus_'.$bonus_item.'_saldo'] = 'bonus_'.$bonus_item.'_saldo - '.$row->$bonus_item_saldo;
                            $total_bonus_transfer += $row->$bonus_item_saldo;
                        }
                        $data_summary_bonus['bonus_'.$category.'_saldo'] = 'bonus_'.$category.'_saldo - '. $total_bonus_transfer;
                        $data_summary_bonus['bonus_total_saldo'] = 'bonus_total_saldo - '. $total_bonus_transfer;
                        $this->backend_bonus_transfer_model->update_bonus_saldo($data_summary_bonus, $row->network_id);
                    }
                }
                
                //simpan jenis bonus pada transfer ini
                if(is_array($arr_bonus)) {
                    $str_bonus = '';
                    foreach($arr_bonus as $bonus_item) {
                        $str_bonus .= $bonus_item . '#';
                    }
                    $str_bonus = rtrim($str_bonus, '#');

                    $data = array();
                    $data['bonus_transfer_active_datetime'] = $datetime;
                    $data['bonus_transfer_active_str_bonus'] = $str_bonus;
                    $this->function_lib->insert_data('sys_bonus_transfer_active', $data);
                }

                // report summary bonus (pending)
                $this->backend_bonus_transfer_model->update_report_summary_bonus_pending($arr_bonus, $data_report, "+");

                if ($this->db->trans_status() === FALSE || $is_error) {
                    $this->db->trans_rollback();
                    $arr_output['message'] = 'Data gagal disimpan.';
                    $arr_output['message_class'] = 'response_error';
                } else {
                    $this->db->trans_commit();
                    $arr_output['message'] = 'Data berhasil disimpan. Silakan download <a href="' . base_url() . 'backend_service/bonus_transfer/generate_excel/' . strtotime($datetime) . '">File Excel</a>.';
                    $arr_output['message_class'] = 'response_confirmation alert alert-success';
                }
            } else {
                $arr_output['message'] = 'Tidak ada data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }
        
        echo json_encode($arr_output);
    }

    function get_preview_data($category = '') {
        $arr_all_transfer_config = $this->config->item('transfer');
        $arr_transfer_config = $arr_all_transfer_config[$category];
        $arr_bonus = $arr_transfer_config['arr_bonus'];
        
        $params = isset($_POST) ? $_POST : array();
        $query = $this->backend_bonus_transfer_model->get_query_preview_data($category, $params);
        $total = $this->backend_bonus_transfer_model->get_query_preview_data($category, $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        
        foreach ($query->result() as $row) {
            
            $entry = array('id' => $row->network_id,
                'cell' => array(
                    'network_id' => $row->network_id,
                    'network_code' => $row->network_code,
                    'member_name' => stripslashes($row->member_name),
                    'member_nickname' => $row->member_nickname,
                    'member_phone' => $row->member_phone,
                    'member_mobilephone' => $row->member_mobilephone,
                    'member_join_datetime' => convert_datetime($row->member_join_datetime, 'id'),
                    'member_bank_name' => $row->member_bank_name,
                    'member_bank_city' => $row->member_bank_city,
                    'member_bank_branch' => $row->member_bank_branch,
                    'member_bank_account_name' => stripslashes($row->member_bank_account_name),
                    'member_bank_account_no' => $row->member_bank_account_no,
                    'bonus_total' => $this->function_lib->set_number_format($row->bonus_total),
                    'adm_charge' => $this->function_lib->set_number_format($row->adm_charge),
                    'nett' => $this->function_lib->set_number_format($row->nett),
                ),
            );
            
            if(is_array($arr_bonus)) {
                foreach($arr_bonus as $bonus_item) {
                    $field = 'bonus_' . $bonus_item;
                    $entry['cell'][$field] = $this->function_lib->set_number_format($row->$field);
                }
            }
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function act_approve() {
        $this->load->library('form_validation');
        $this->load->library('upload');

        if (isset($_FILES['file']['size']) && $_FILES['file']['size'] > 0) {
            $datetime = date("Y-m-d H:i:s");
            $administrator_id = $this->session->userdata('administrator_id');
            
            if ($this->upload->fileUpload('file', _dir_import, 'xls|xlsx')) {
                $upload = $this->upload->data();
                $filename = url_title($upload['raw_name']) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $filename);
                
                //php excel start here
                $this->load->library('Excel');
                $inputFileType = PHPExcel_IOFactory::identify($upload['file_path'] . $filename);
                if($inputFileType != 'CSV') {
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objReader->setReadDataOnly(true);

                    $objPHPExcel = $objReader->load($upload['file_path'] . $filename);
                    $objWorksheet = $objPHPExcel->getActiveSheet();
                    $highestRow = $objWorksheet->getHighestRow();
                    $highestColumn = $objWorksheet->getHighestColumn();
                    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                    
                    $count_data = 0;
                    $count_data_success = 0;
                    $count_data_failed = 0;
                    $count_data_unupdated = 0;
                    $count_success_status = 0;
                    for($cell_row = 5; $cell_row <= ($highestRow - 1); ++$cell_row) {
                        $data = array();
                        $bonus_transfer_code = $objWorksheet->getCellByColumnAndRow(0, $cell_row)->getValue();
                        $bonus_transfer_status_label = $objWorksheet->getCellByColumnAndRow(1, $cell_row)->getValue();
                        $bonus_transfer_note = $objWorksheet->getCellByColumnAndRow(2, $cell_row)->getValue();
                        $query = $this->function_lib->get_detail_data('sys_bonus_transfer', 'bonus_transfer_code', $bonus_transfer_code);
                        
                        if($query->num_rows() > 0) {
                            $row = $query->row();
                            
                            switch($bonus_transfer_status_label) {
                                case "GAGAL":
                                    $bonus_transfer_status = 'failed';
                                    break;

                                case "SUKSES":
                                    $bonus_transfer_status = 'success';
                                    break;

                                default:
                                    $bonus_transfer_status = 'pending';
                                    break;
                            }
                            
                            if($bonus_transfer_status != $row->bonus_transfer_status) {
                                $data = array();
                                $data['bonus_transfer_status'] = $bonus_transfer_status;
                                $data['bonus_transfer_note'] = $bonus_transfer_note;
                                $this->function_lib->update_data('sys_bonus_transfer', 'bonus_transfer_id', $row->bonus_transfer_id, $data);

                                $data = array();
                                $data['bonus_transfer_status_bonus_transfer_id'] = $row->bonus_transfer_id;
                                $data['bonus_transfer_status_administrator_id'] = $administrator_id;
                                $data['bonus_transfer_status_status'] = $bonus_transfer_status;
                                $data['bonus_transfer_status_datetime'] = $datetime;
                                $this->function_lib->insert_data('sys_bonus_transfer_status', $data);
                                
                                // restore bonus and flag
                                $arr_all_transfer_config = $this->config->item('transfer');
                                $arr_transfer_config = $arr_all_transfer_config[$row->bonus_transfer_category];
                                $arr_bonus = $arr_transfer_config['arr_bonus'];

                                if ($bonus_transfer_status == 'failed') {
                                    // update flag bonus log
                                    $query = $this->backend_bonus_transfer_model->get_transfer_detail_data($row->bonus_transfer_id);
                                    if ($query->num_rows() > 0) {
                                        foreach ($query->result() as $value) {
                                            $data = array();
                                            $data['bonus_'.$row->bonus_transfer_category.'_is_transfered'] = 0;
                                            $this->function_lib->update_data('sys_bonus_log', 'bonus_log_id', $value->bonus_transfer_detail_bonus_log_id, $data);
                                        }

                                    }
                                    
                                    // restore saldo sys_bonus
                                    $query2 = $this->backend_bonus_transfer_model->get_sum_bonus_detail($row->bonus_transfer_category, $row->bonus_transfer_id);
                                    if ($query2->num_rows() > 0) {
                                        $result_row = $query2->row();
                                        $update_summary_bonus = array();
                                        $total_bonus_transfer = 0;
                                        foreach ($arr_bonus as $bonus_item) {
                                            $bonus_item_saldo = 'bonus_'.$bonus_item;
                                            $update_summary_bonus['bonus_'.$bonus_item.'_paid'] = 'bonus_'.$bonus_item.'_paid - '.$result_row->$bonus_item_saldo;
                                            $update_summary_bonus['bonus_'.$bonus_item.'_saldo'] = 'bonus_'.$bonus_item.'_saldo + '.$result_row->$bonus_item_saldo;
                                            $total_bonus_transfer += $result_row->$bonus_item_saldo;
                                        }
                                        $update_summary_bonus['bonus_'.$row->bonus_transfer_category.'_saldo'] = 'bonus_'.$row->bonus_transfer_category.'_saldo + '. $total_bonus_transfer;
                                        $update_summary_bonus['bonus_total_saldo'] = 'bonus_total_saldo + '. $total_bonus_transfer;
                                    }
                                    $this->backend_bonus_transfer_model->update_bonus_saldo($update_summary_bonus, $row->bonus_transfer_network_id);
                                
                                } elseif ($bonus_transfer_status == 'success') {
                                    $count_success_status++;
                                }

                                /* begin report summary bonus (pending) */
                                if ($bonus_transfer_status == 'failed' OR $bonus_transfer_status == 'success') {
                                    $data_report = array();
                                    if(is_array($arr_bonus)) {
                                        foreach($arr_bonus as $bonus_item) {
                                            $data_report[$bonus_item] = 0;
                                        }
                                    }

                                    $query = $this->backend_bonus_transfer_model->get_transfer_detail_data($row->bonus_transfer_id);
                                    if ($query->num_rows() > 0) {
                                        foreach ($query->result() as $value) {
                                            foreach($arr_bonus as $bonus_item) {
                                                $bonus_value = $this->function_lib->get_one('sys_bonus_transfer_detail', 'bonus_transfer_detail_' . $bonus_item, array('bonus_transfer_detail_bonus_log_id'=>$value->bonus_transfer_detail_bonus_log_id));
                                                $data_report[$bonus_item] = $data_report[$bonus_item] + $bonus_value;
                                            }
                                        }
                                    }
                                    
                                    // report summary bonus (pending)
                                    $this->backend_bonus_transfer_model->update_report_summary_bonus_pending($arr_bonus, $data_report, "-");
                                }
                                /* end report summary bonus (pending) */

                                $count_data_success++;
                            } else {
                                $count_data_unupdated++;
                            }
                        } else {
                            $count_data_failed++;
                        }
                        $count_data++;
                    }
                    //php excel end here

                    if ($count_success_status > 0) {
                        /* UPDATE THE REPORT SUMMARY BONUS */
                        $arr_all_bonus = $this->mlm_function->get_arr_active_bonus();
                        $this->backend_bonus_transfer_model->update_report_summary_bonus($arr_all_bonus);
                    }

                    //hapus file upload
                    if ($filename != '' && file_exists(_dir_import . $filename)) {
                        @unlink(_dir_import . $filename);
                    }

                    $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success"><strong>Total upload ' . $this->function_lib->set_number_format($count_data, true) . ' data, dengan rincian sebagai berikut:</strong><ul><li>' . $this->function_lib->set_number_format($count_data_success, true) . ' data berhasil diproses.</li><li>' . $this->function_lib->set_number_format($count_data_failed, true) . ' data gagal diproses.</li><li>' . $this->function_lib->set_number_format($count_data_unupdated, true) . ' data tidak ada perubahan data.</li></ul></div>');
                    redirect($this->input->post('uri_string'));
                } else {
                    $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Data gagal diproses. Format File Excel yang anda upload tidak valid.</div>');
                    redirect($this->input->post('uri_string'));
                }
            } else {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Data gagal diproses.</div>');
                redirect($this->input->post('uri_string'));
            }
        } else {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">File harus anda sertakan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function export_preview_data($category = '') {
        $arr_all_transfer_config = $this->config->item('transfer');
        $arr_transfer_config = $arr_all_transfer_config[$category];
        
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        unset($params['rp']);
        unset($params['page']);
        
        $data = array();
        $data['title'] = 'Preview Rekapitulasi Bonus ' . $arr_transfer_config['title'];
        $data['params'] = $params;
        $data['query'] = $this->backend_bonus_transfer_model->get_query_preview_data($category, $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function export_transfer_list() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        $params['table'] = "view_bonus_transfer";
        
        unset($params['rp']);
        unset($params['page']);
        
        $data = array();
        $data['title'] = 'Log Transfer Bonus';
        $data['params'] = $params;
        $data['query'] = $this->function_lib->get_query_data($params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    
    function generate_excel($strtotime = '') {
        if($strtotime != '') {
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
                    if($row->bonus_transfer_status == 'pending') {
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                        $cell_validation = $excel->getActiveSheet()->getCell($cell_column . $cell_row)->getDataValidation();
                        $cell_validation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                        $cell_validation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
                        $cell_validation->setAllowBlank(false);
                        $cell_validation->setShowInputMessage(true);
                        $cell_validation->setShowErrorMessage(true);
                        $cell_validation->setShowDropDown(true);
                        $cell_validation->setErrorTitle('Isian salah');
                        $cell_validation->setError('Isian tidak ada dalam pilihan.');
                        $cell_validation->setPromptTitle('Pilih Status');
                        $cell_validation->setPrompt('Silakan pilih status berdasarkan pilihan yang disediakan.');
                        $cell_validation->setFormula1('"PENDING,SUKSES,GAGAL"');
                    }
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $row->bonus_transfer_note, PHPExcel_Cell_DataType::TYPE_STRING);
                    if($row->bonus_transfer_status == 'pending') {
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }
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
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper(stripslashes($row->bonus_transfer_bank_name)), PHPExcel_Cell_DataType::TYPE_STRING);
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
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, strtoupper($row->bonus_transfer_bank_account_name), PHPExcel_Cell_DataType::TYPE_STRING);
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
                $merge_grandtotal_end = $cell_column . $cell_row;
                $excel->setActiveSheetIndex(0)->mergeCells($merge_grandtotal_start . ':' . $merge_grandtotal_end);
                $excel->getActiveSheet()->getStyle($merge_grandtotal_start . ':' . $merge_grandtotal_end)->applyFromArray($arr_style_title);
                $cell_column++;
                
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
    
    
    
    function pending_generate_excel($strtotime = '') {
        if($strtotime != '') {
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
            
            $query = $this->backend_bonus_transfer_model->get_list_bonus_transfer_pending_by_datetime($datetime);
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
                    if($row->bonus_transfer_status == 'pending') {
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                        $cell_validation = $excel->getActiveSheet()->getCell($cell_column . $cell_row)->getDataValidation();
                        $cell_validation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                        $cell_validation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
                        $cell_validation->setAllowBlank(false);
                        $cell_validation->setShowInputMessage(true);
                        $cell_validation->setShowErrorMessage(true);
                        $cell_validation->setShowDropDown(true);
                        $cell_validation->setErrorTitle('Isian salah');
                        $cell_validation->setError('Isian tidak ada dalam pilihan.');
                        $cell_validation->setPromptTitle('Pilih Status');
                        $cell_validation->setPrompt('Silakan pilih status berdasarkan pilihan yang disediakan.');
                        $cell_validation->setFormula1('"PENDING,SUKSES,GAGAL"');
                    }
                    $cell_column++;
                    
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal('left');
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $row->bonus_transfer_note, PHPExcel_Cell_DataType::TYPE_STRING);
                    if($row->bonus_transfer_status == 'pending') {
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    }
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
                $merge_grandtotal_end = $cell_column . $cell_row;
                $excel->setActiveSheetIndex(0)->mergeCells($merge_grandtotal_start . ':' . $merge_grandtotal_end);
                $excel->getActiveSheet()->getStyle($merge_grandtotal_start . ':' . $merge_grandtotal_end)->applyFromArray($arr_style_title);
                $cell_column++;
                
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
