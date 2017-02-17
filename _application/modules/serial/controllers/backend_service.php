<?php

/*
 * Backend Service Serial Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('serial/backend_serial_model');
        $this->load->helper('form');
    }

    function act_show() {
        
        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';
        $administrator_id = $this->session->userdata('administrator_id');
        $datetime = date("Y-m-d H:i:s");

        //publish
        if ($this->input->post('publish') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_updated = $item_unupdated = 0;
                foreach ($arr_item as $id) {
                    $check_active = $this->backend_serial_model->check_active($id);
                    if($check_active == true) {
                        $data = array();
                        $data['serial_is_active'] = '1';
                        $this->function_lib->update_data('sys_serial', 'serial_id', $id, $data);

                        $data = array();
                        $data['serial_activation_serial_id'] = $id;
                        $data['serial_activation_administrator_id'] = $administrator_id;
                        $data['serial_activation_datetime'] = $datetime;
                        $this->function_lib->insert_data('sys_serial_activation', $data);

                        $item_updated++;
                    } else {
                        $item_unupdated++;
                    }
                }
                $arr_output['message'] = $item_updated . ' serial berhasil diaktifkan. ' . $item_unupdated . ' serial gagal diaktifkan.';
                $arr_output['message_class'] = ($item_unupdated > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        //unpublish
        if ($this->input->post('unpublish') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_updated = $item_unupdated = 0;
                foreach ($arr_item as $id) {
                    $check_used = $this->backend_serial_model->check_used($id);
                    if($check_used == true) {
                        $data = array();
                        $data['serial_is_active'] = '0';
                        $this->function_lib->update_data('sys_serial', 'serial_id', $id, $data);

                        $this->function_lib->delete_data('sys_serial_activation', 'serial_activation_serial_id', $id);
                    } else {
                        $item_unupdated++;
                    }
                }
                $arr_output['message'] = $item_updated . ' serial berhasil dinonaktifkan. ' . $item_unupdated . ' serial gagal dinonaktifkan.';
                $arr_output['message_class'] = ($item_unupdated > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }
        
        echo json_encode($arr_output);
    }

    function get_data($action = '') {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "view_serial";
        if($action == 'buy') {
            $params['where_detail'] = "serial_is_sold = '0' AND serial_is_used = '0'";
        }
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
                $image_stat = 'minus-small.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //is_sold
            if ($row->serial_is_sold == '1') {
                $stat = 'Terjual';
                $image_stat = 'tick.png';
            } else {
                $stat = 'Belum Terjual';
                $image_stat = 'minus-small.png';
            }
            $is_sold = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //is_used
            if ($row->serial_is_used == '1') {
                $stat = 'Terpakai';
                $image_stat = 'tick.png';
            } else {
                $stat = 'Belum Terpakai';
                $image_stat = 'minus-small.png';
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
                    'buyer_member_name' => $row->buyer_member_name,
                    'buyer_member_nickname' => $row->buyer_member_nickname,
                    'buyer_member_phone' => $row->buyer_member_phone,
                    'buyer_member_mobilephone' => $row->buyer_member_mobilephone,
                    'serial_user_datetime' => convert_datetime($row->serial_user_datetime, 'id'),
                    'user_network_code' => $row->user_network_code,
                    'user_member_name' => $row->user_member_name,
                    'user_member_nickname' => $row->user_member_nickname,
                    'user_member_phone' => $row->user_member_phone,
                    'user_member_mobilephone' => $row->user_member_mobilephone,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function act_add() {
        // restrict non superuser group
        if ($this->session->userdata('administrator_group_type') != 'superuser') {
            redirect('backend/serial/show');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('count', '<b>Jumlah</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            redirect($this->input->post('uri_string'));
        } else {
            $serial_type_id = $this->input->post('serial_type_id');
            $count = $this->input->post('count');
            $administrator_id = $this->session->userdata('administrator_id');
            $datetime = date('Y-m-d H:i:s');
            
            $query = $this->backend_serial_model->get_last_serial();
            if($query->num_rows() > 0) {
                $row = $query->row();
                $last_serial_id = $row->serial_id;
                $last_serial_member_code = $row->serial_network_code;
            } else {
                $last_serial_id = '';
                $last_serial_member_code = '';
            }

            /* Left Trim ID from ID100000001 to 100000001 */
            $last_serial_id = ltrim($last_serial_id, 'ID');
            
            $serial_network_code = '';
            for($i = 1; $i <= $count; $i++) {
                $serial_id_num = number_format(++$last_serial_id, 0, '', '');
                $serial_id = 'ID'.$serial_id_num;
                if($this->sys_configuration['auto_network_code'] == 0) {
                    /* Left Trim ID from ID100000001 to 100000001 */
                    $last_serial_member_code = ltrim($last_serial_member_code, 'ID');
                    $serial_network_code = 'ID' . (++$last_serial_member_code);
                    $last_serial_member_code = $last_serial_member_code;
                }
                $serial_pin = $this->function_lib->generate_number(6);
                
                $data = array();
                $data['serial_id'] = $serial_id;
                $data['serial_pin'] = $serial_pin;
                $data['serial_network_code'] = $serial_network_code;
                $data['serial_serial_type_id'] = $serial_type_id;
                $data['serial_create_administrator_id'] = $administrator_id;
                $data['serial_create_datetime'] = $datetime;
                $data['serial_is_sold'] = 0;
                $data['serial_is_active'] = 0;
                $data['serial_is_used'] = 0;
                $this->function_lib->insert_data('sys_serial', $data);
            }
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan. Silakan <a href="' . base_url() . 'backend_service/serial/export_generate/' . strtotime($datetime) . '" target="_blank">klik disini</a> untuk download excel.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function export_generate($unix_datetime) {
        $this->load->library('Excel');

        $title = 'Generate Serial';
        $filename = url_title($title) . '-' . date("YmdHis");
        $creator = 'Esoftdream.Net';

        $first_column = $cell_column = 'A';
        $first_row = $cell_row = 1;
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator($creator)->setLastModifiedBy($creator)->setTitle($title)->setSubject($title);
        $excel->getActiveSheet()->setTitle($title);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getDefaultStyle()->getFont()->setName('Arial');
        $excel->getDefaultStyle()->getFont()->setSize(9);

        //title
        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setSize(12);
        $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, strtoupper($title));
        $cell_row++;
        $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, 'Tanggal Generate : ' . convert_datetime(date("Y-m-d H:i:s", $unix_datetime), 'id'));
        $cell_row++;
        $cell_row++;
        
        $arr_column_title = array(
            'Tipe',
            'No. Serial',
            'P I N',
        );
        if($this->sys_configuration['auto_network_code'] == 0) {
            array_push($arr_column_title, 'Kode Member');
        }

        if (is_array($arr_column_title)) {
            $cell_column = $first_column;
            foreach ($arr_column_title as $id => $value) {
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setSize(9);
                $excel->getActiveSheet()->getColumnDimension($cell_column)->setWidth(1.3 * strlen($value) + 0.584);

                $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, strtoupper($value));
                $cell_column++;
            }
            $cell_row++;
        }

        $query = $this->backend_serial_model->get_list_serial_by_unix_datetime($unix_datetime);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $cell_column = $first_column;
                foreach ($row as $id => $value) {
                    if (!isset($value)) {
                        $data = '';
                    } else {
                        $data = $value;
                    }
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                    $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getNumberFormat()->setFormatCode('@');
                    $excel->getActiveSheet()->getCell($cell_column . $cell_row)->setValueExplicit($data, PHPExcel_Cell_DataType::TYPE_STRING);
                    
                    $cell_column++;
                }
                $cell_row++;
            }
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $write->save('php://output');
        exit;
    }
    
    function get_member() {
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
            
            $entry = array('id' => $row->network_id,
                'cell' => array(
                    'network_code' => $row->network_code,
                    'member_name' => $row->member_name,
                    'member_nickname' => $row->member_nickname,
                    'member_phone' => $row->member_phone,
                    'member_mobilephone' => $row->member_mobilephone,
                    'member_city_name' => $row->member_city_name,
                    'member_province_name' => $row->member_province_name,
                    'member_region_name' => $row->member_region_name,
                    'member_country_name' => $row->member_country_name,
                    'member_is_active' => $is_active,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function act_buy() {
        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';

        //save
        if ($this->input->post('save') != FALSE) {
            $network_id = json_decode($_POST['network_id']);
            $arr_item = json_decode($_POST['arr_item']);
            
            if (is_array($arr_item)) {
                $administrator_id = $this->session->userdata('administrator_id');
                $date = date("Y-m-d");
                $datetime = date("Y-m-d H:i:s");
                foreach ($arr_item as $id) {
                    $data = array();
                    $data['serial_is_sold'] = '1';
                    $this->function_lib->update_data('sys_serial', 'serial_id', $id, $data);
                    
                    //hapus data lama jika ada
                    $this->function_lib->delete_data('sys_serial_buyer', 'serial_buyer_serial_id', $id);
                    
                    $serial_price_value = $this->backend_serial_model->get_serial_type_price($id, $date);
                    
                    $data = array();
                    $data['serial_buyer_serial_id'] = $id;
                    $data['serial_buyer_network_id'] = $network_id;
                    $data['serial_buyer_price_value'] = $serial_price_value;
                    $data['serial_buyer_administrator_id'] = $administrator_id;
                    $data['serial_buyer_datetime'] = $datetime;
                    $this->function_lib->insert_data('sys_serial_buyer', $data);
                }
                $arr_output['message'] = 'Data berhasil disimpan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }
        
        echo json_encode($arr_output);
    }

    function export_data() {
        $params = array();
        if(isset($_POST)) {
            foreach($_POST as $id => $value) {
                $params[$id] = $value;
            }
        }
        $params['params']['table'] = "view_serial";
        
        if($params['params']['total_data'] <= 1000) {
            unset($params['params']['rp']);
            unset($params['params']['page']);
        }
        
        $data = array();
        $data['title'] = 'Data Serial';
        $data['params'] = $params;
        $data['query'] = $this->function_lib->get_query_data($params['params']);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function get_price_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->backend_serial_model->get_query_serial_price_data($params);
        $total = $this->backend_serial_model->get_query_serial_price_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {
            
            //edit
            $edit = '<a href="' . base_url() . 'backend/serial/price_edit/' . $row->serial_type_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->serial_type_id,
                'cell' => array(
                    'serial_type_id' => $row->serial_type_id,
                    'serial_type_name' => $row->serial_type_name,
                    'serial_type_label' => $row->serial_type_label,
                    'serial_type_node' => $row->serial_type_node,
                    'serial_type_price' => $this->function_lib->set_number_format($row->serial_type_price),
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function act_price_edit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('price', '<b>Harga</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_price', $this->input->post('price'));
            redirect($this->input->post('uri_string'));
        } else {
            $serial_type_id = $this->input->post('id');
            $price = $this->input->post('price');

            $data = array();
            $data['serial_type_price_log_serial_type_id'] = $serial_type_id;
            $data['serial_type_price_log_administrator_id'] = $this->session->userdata('administrator_id');
            $data['serial_type_price_log_value'] = $price;
            $data['serial_type_price_log_datetime'] = date("Y-m-d H:i:s");
            $this->function_lib->insert_data('sys_serial_type_price_log', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
