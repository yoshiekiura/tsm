<?php
/*
 * Backend Service Reward Controller
 * 
 * @edited by Fahrur Rifai
 * 
 */

class Backend_service extends Backend_Service_Controller {

    // put your code here
    function __construct() {
        parent::__construct();

        $this->load->model('reward/backend_reward_model');
        $this->load->helper('form');

        $this->file_dir = _dir_reward;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 600;
        $this->image_height = 1000;
        // $this->load->library(array('sms_lib'));

        $this->datetime = date('Y-m-d H:i:s');
    }

    function act_add() {

        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('bonus_reward_item', '<b>Item Reward</b>', 'required');
        $this->form_validation->set_rules('condition_left', '<b>Syarat Kaki Kiri</b>', 'required');
        $this->form_validation->set_rules('condition_right', '<b>Syarat Kaki Kanan</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_condition_left', $this->input->post('condition_left'));
            $this->session->set_flashdata('input_condition_right', $this->input->post('condition_right'));
            $this->session->set_flashdata('input_bonus_reward_item', $this->input->post('bonus_reward_item'));
            $this->session->set_flashdata('input_bonus_reward_value', $this->input->post('bonus_reward_value'));
            $this->session->set_flashdata('input_bonus_reward_note', $this->input->post('bonus_reward_note'));
            redirect($this->input->post('uri_string'));
        } else {
            $left_node_condition = $this->input->post('condition_left');
            $right_node_condition = $this->input->post('condition_right');

            $data = array();
            $data['reward_cond_node_left'] = $left_node_condition;
            $data['reward_cond_node_right'] = $right_node_condition;
            $data['reward_bonus'] = $this->input->post('bonus_reward_item');
            $data['reward_bonus_value'] = $this->input->post('bonus_reward_value');
            $data['reward_note'] = $this->input->post('bonus_reward_note');
            $data['reward_is_active'] = '1';

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }
                $image_filename = url_title($bonus_reward) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['reward_image'] = $image_filename;
            } else {
                $data['reward_image'] = '';
            }
            $this->function_lib->insert_data('sys_reward', $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('bonus_reward_item', '<b>Item Reward</b>', 'required');
        $this->form_validation->set_rules('condition_left', '<b>Syarat Kaki Kiri</b>', 'required');
        $this->form_validation->set_rules('condition_right', '<b>Syarat Kaki Kanan</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_condition_left', $this->input->post('condition_left'));
            $this->session->set_flashdata('input_condition_right', $this->input->post('condition_right'));
            $this->session->set_flashdata('input_bonus_reward_item', $this->input->post('bonus_reward_item'));
            $this->session->set_flashdata('input_bonus_reward_value', $this->input->post('bonus_reward_value'));
            $this->session->set_flashdata('input_bonus_reward_note', $this->input->post('bonus_reward_note'));
            redirect($this->input->post('uri_string'));
        } else {
            $reward_id = $this->input->post('id');
            $left_node_condition = $this->input->post('condition_left');
            $right_node_condition = $this->input->post('condition_right');
            $bonus_reward_item = $this->input->post('bonus_reward_item');
            $bonus_reward = $this->input->post('bonus_reward_value');
            $reward_old_image = $this->input->post('old_image');

            $data = array();
            $data['reward_cond_node_left'] = $left_node_condition;
            $data['reward_cond_node_right'] = $right_node_condition;
            $data['reward_bonus'] = $bonus_reward_item;
            $data['reward_bonus_value'] = $bonus_reward;
            $data['reward_note'] = $this->input->post('bonus_reward_note');
            $data['reward_is_active'] = '1';
            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($bonus_reward) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($reward_old_image != '' && file_exists($this->file_dir . $reward_old_image)) {
                    @unlink($this->file_dir . $reward_old_image);
                }

                $data['reward_image'] = $image_filename;
            }
            $this->function_lib->update_data('sys_reward', 'reward_id', $reward_id, $data);

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_show() {
        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';

        // delete
        if ($this->input->post('delete') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_deleted = $item_undeleted = 0;
                foreach ($arr_item as $id) {
                    // hapus file gambar
                    $filename = $this->function_lib->get_one('sys_reward', 'reward_image', array('reward_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir . $filename)) {
                        @unlink($this->file_dir . $filename);
                    }
                    // hapus data
                    $this->function_lib->delete_data('sys_reward', 'reward_id', $id);
                    
                    $item_deleted++;
                }
                $arr_output['message'] = $item_deleted . ' data berhasil dihapus. ' . $item_undeleted . ' data gagal dihapus.';
                $arr_output['message_class'] = ($item_undeleted > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        // publish
        if ($this->input->post('publish') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                foreach ($arr_item as $id) {
                    $data = array();
                    $data['reward_is_active'] = '1';
                    $this->function_lib->update_data('sys_reward', 'reward_id', $id, $data);
                }
                $arr_output['message'] = 'Data berhasil disimpan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        // unpublish
        if ($this->input->post('unpublish') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                foreach ($arr_item as $id) {
                    $data = array();
                    $data['reward_is_active'] = '0';
                    $this->function_lib->update_data('sys_reward', 'reward_id', $id, $data);
                }
                $arr_output['message'] = 'Data berhasil disimpan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        // approve
        if ($this->input->post('approve') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $reward_success_approve = $reward_failed_approve = 0;
                foreach ($arr_item as $id) {

                    $data = array();
                    $data['reward_qualified_status'] = 'approved';
                    $this->function_lib->update_data('sys_reward_qualified', 'reward_qualified_id', $id, $data);

                    $data = array();
                    $data['reward_qualified_status_reward_qualified_id'] = $id;
                    $data['reward_qualified_status_administrator_id'] = $this->session->userdata('administrator_id');
                    $data['reward_qualified_status_administrator_name'] = $this->session->userdata('administrator_name');
                    $data['reward_qualified_status_datetime'] = $this->datetime;
                    $data['reward_qualified_status_status'] = 'approved';
                    $this->function_lib->insert_data('sys_reward_qualified_status', $data);

                    $reward_success_approve++;
                }
                $arr_output['message'] = $reward_success_approve . ' reward berhasil di proses. ' . $reward_failed_approve . ' reward gagal di prosees';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        // reject
        if ($this->input->post('reject') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $reward_success_reject = $reward_failed_reject = 0;
                foreach ($arr_item as $id) {

                    // update reward qualified
                    $data = array();
                    $data['reward_qualified_status'] = 'rejected';
                    $this->function_lib->update_data('sys_reward_qualified', 'reward_qualified_id', $id, $data);

                    // update reward qualified status
                    $data = array();
                    $data['reward_qualified_status_reward_qualified_id'] = $id;
                    $data['reward_qualified_status_administrator_id'] = $this->session->userdata('administrator_id');
                    $data['reward_qualified_status_administrator_name'] = $this->session->userdata('administrator_name');
                    $data['reward_qualified_status_datetime'] = $this->datetime;
                    $data['reward_qualified_status_status'] = 'rejected';
                    $this->function_lib->insert_data('sys_reward_qualified_status', $data);

                    // update sys network
                    $reward_id = $this->function_lib->get_one('sys_reward_qualified', 'reward_qualified_reward_id', array('reward_qualified_id'=>$id));
                    $query = $this->function_lib->get_detail_data('sys_reward', array('reward_id'=>$reward_id), NULL);
                    $data_reward = $query->row_array();
                    $reward_cond_node_left = $data_reward['reward_cond_node_left'];
                    $reward_cond_node_right = $data_reward['reward_cond_node_right'];
                    $network_id = $this->function_lib->get_one('sys_reward_qualified', 'reward_qualified_network_id', array('reward_qualified_id'=>$id));

                    $data = array();
                    $this->db->set('network_total_reward_node_left', 'network_total_reward_node_left+'.$reward_cond_node_left, FALSE);
                    $this->db->set('network_total_reward_node_right', 'network_total_reward_node_right+'.$reward_cond_node_right, FALSE);
                    $this->db->where('network_id', $network_id);
                    $this->db->update('sys_network');

                    $reward_success_reject++;
                }
                $arr_output['message'] = $reward_success_reject . ' reward berhasil di proses. ' . $reward_failed_reject . ' reward gagal di prosees';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }
        echo json_encode($arr_output);
    }

    function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "sys_reward";

        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->reward_image != '' && file_exists($this->file_dir . $row->reward_image)) {
                $image = $row->reward_image;
            } else {
                $image = '_default.jpg';
            }
            $image = '<img src="' . base_url() . $this->file_dir . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->reward_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/reward/edit/' . $row->reward_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->reward_id,
                'cell' => array(
                    'reward_id' => $row->reward_id,
                    'reward_cond_node_left' => $this->function_lib->set_number_format($row->reward_cond_node_left),
                    'reward_cond_node_right' => $this->function_lib->set_number_format($row->reward_cond_node_right),
                    'reward_bonus' => $row->reward_bonus,
                    'reward_bonus_value' => $this->function_lib->set_number_format($row->reward_bonus_value),
                    'reward_image' => $image,
                    'reward_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function export_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['where_detail'] = "reward_qualified_status = 'pending' ";
        
        $data = array();
        $data['title'] = 'Data Approval Claim Reward Member';
        $data['params'] = $params;
        $data['query'] = $this->backend_reward_model->get_data_member_reward($params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->export_excel_data($data);
    }

    function get_log_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->backend_reward_model->get_member_reward_data($params);
        $total = $this->backend_reward_model->get_member_reward_data($params, true);

        header("Content-type: application/json");
        // print_r(json_encode($query->result()));die();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
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
                    'no' => $page++,
                    'network_code' => $row->network_code,
                    'member_name' => $row->member_name,
                    'reward_cond_node_left' => $this->function_lib->set_number_format($row->reward_cond_node_left),
                    'reward_cond_node_right' => $this->function_lib->set_number_format($row->reward_cond_node_right),
                    'reward_qualified_condition_node_left' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_left),
                    'reward_qualified_condition_node_right' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_right),
                    'reward_qualified_reward_bonus' => $row->reward_qualified_reward_bonus,
                    'reward_qualified_status' => $status,
                    'reward_qualified_date' => convert_date($row->reward_qualified_date, 'id'),
                    'claim_datetime' => date_converter($row->claim_datetime, 'd F Y H:i:s'),
                    'process_date' => (($row->process_date == '-') ? date_converter($row->process_date, 'd F Y H:i:s') : '-'),
                    'administrator_name' => $administrator[$row->administrator_id],
                ),
            );
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function get_data_member() {
        $params = isset($_POST) ? $_POST : array();
        $params['where_detail'] = "member_is_active != '0' AND reward_qualified_status = 'pending' ";
        $params['join'] = "
                INNER JOIN sys_network ON reward_qualified_network_id = network_id
                INNER JOIN sys_member ON reward_qualified_network_id = member_network_id
        ";
        $params['table'] = 'sys_reward_qualified';
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());

        foreach ($query->result() as $row) {

            $entry = array('id' => $row->reward_qualified_id,
                'cell' => array(
                    'reward_qualified_id' => $row->reward_qualified_id,
                    'network_code' => $row->network_code,
                    'member_name' => $row->member_name,
                    'reward_qualified_reward_bonus' => $row->reward_qualified_reward_bonus,
                    'member_mobilephone' => $row->member_mobilephone,
                    'reward_qualified_date' => convert_date($row->reward_qualified_date, 'id'),
                    'reward_qualified_reward_value' => $this->function_lib->set_number_format($row->reward_qualified_reward_value),
                ),
            );

            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
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
