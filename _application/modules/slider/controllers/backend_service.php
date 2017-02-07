<?php

/*
 * Backend Slider Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('slider/backend_slider_model');
        $this->load->helper('form');
        
        $this->file_dir = _dir_slider;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';

        //set width & height berdasarkan slider block
//        $this->header_image_width = 1000;
//        $this->header_image_height = 200;
    }

    function act_show() {
        
        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';

        //delete
        if ($this->input->post('delete') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_deleted = $item_undeleted = 0;
                foreach ($arr_item as $id) {
                    
                    //hapus file gambar item
                    $filename = $this->function_lib->get_one('site_slider', 'slider_image', array('slider_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir . $filename)) {
                        @unlink($this->file_dir . $filename);
                    }
                    
                    //hapus data item
                    $this->function_lib->delete_data('site_slider', 'slider_id', $id);
                    
                    $item_deleted++;
                }
                $arr_output['message'] = $item_deleted . ' data berhasil dihapus. ' . $item_undeleted . ' data gagal dihapus.';
                $arr_output['message_class'] = ($item_undeleted > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        //publish
        if ($this->input->post('publish') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                foreach ($arr_item as $id) {
                    $data = array();
                    $data['slider_is_active'] = '1';
                    $this->function_lib->update_data('site_slider', 'slider_id', $id, $data);
                }
                $arr_output['message'] = 'Data berhasil disimpan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        //unpublish
        if ($this->input->post('unpublish') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                foreach ($arr_item as $id) {
                    $data = array();
                    $data['slider_is_active'] = '0';
                    $this->function_lib->update_data('site_slider', 'slider_id', $id, $data);
                }
                $arr_output['message'] = 'Data berhasil disimpan.';
                $arr_output['message_class'] = 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        //up
        if ($this->input->post('up') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_updated = $item_unupdated = 0;
                foreach ($arr_item as $id) {
                    if($this->backend_slider_model->update_order_by($id, 'up')) {
                        $item_updated++;
                    } else {
                        $item_unupdated++;
                    }
                }
                $arr_output['message'] = $item_updated . ' data berhasil disimpan. ' . $item_unupdated . ' data gagal disimpan.';
                $arr_output['message_class'] = ($item_unupdated > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        //down
        if ($this->input->post('down') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                krsort($arr_item);
                $item_updated = $item_unupdated = 0;
                foreach ($arr_item as $id) {
                    if($this->backend_slider_model->update_order_by($id, 'down')) {
                        $item_updated++;
                    } else {
                        $item_unupdated++;
                    }
                }
                $arr_output['message'] = $item_updated . ' data berhasil disimpan. ' . $item_unupdated . ' data gagal disimpan.';
                $arr_output['message_class'] = ($item_unupdated > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }
        
        echo json_encode($arr_output);
    }

    function get_data($block = 'header') {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_slider";
        $params['where'] = "slider_block = '" . $block . "'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->slider_image != '' && file_exists($this->file_dir . $row->slider_image)) {
                $image = $row->slider_image;
            } else {
                $image = '_default.jpg';
            }
            $image = '<img src="' . base_url() . $this->file_dir . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->slider_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/slider/edit/' . $row->slider_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->slider_id,
                'cell' => array(
                    'slider_id' => $row->slider_id,
                    'slider_title' => $row->slider_title,
                    'slider_image' => $image,
                    'slider_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_add() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            $this->session->set_flashdata('input_description', $this->input->post('description'));
            redirect($this->input->post('uri_string'));
        } else {
            $slider_title = $this->input->post('title');
            $slider_block = $this->input->post('block');
            $slider_order_by = $this->function_lib->get_max('site_slider', 'slider_order_by', array('slider_block' => $slider_block)) + 1;

            $data = array();
            $data['slider_title'] = $slider_title;
            $data['slider_block'] = $slider_block;
            $data['slider_order_by'] = $slider_order_by;
            $data['slider_is_active'] = 1;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

//                $size = getimagesize($upload['full_path']);
//                $width = $size[0];
//                $height = $size[1];
//
//                $slider_block_image_width = $slider_block . '_image_width';
//                $slider_block_image_height = $slider_block . '_image_height';
//                if(isset($this->$slider_block_image_width) && isset($this->$slider_block_image_height)) {
//                    if ($width != $this->$slider_block_image_width || $height != $this->$slider_block_image_height) {
//                        //$this->image_lib->resizeImage($upload['full_path'], $this->$slider_block_image_width, $this->$slider_block_image_height);
//                    }
//                }
                
                $image_filename = url_title($slider_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['slider_image'] = $image_filename;
            } else {
                $data['slider_image'] = '';
            }
            $this->function_lib->insert_data('site_slider', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_title', $this->input->post('title'));
            redirect($this->input->post('uri_string'));
        } else {
            $slider_id = $this->input->post('id');
            $slider_title = $this->input->post('title');
            $slider_block = $this->input->post('block');
            $slider_old_image = $this->input->post('old_image');

            $data = array();
            $data['slider_title'] = $slider_title;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

//                $size = getimagesize($upload['full_path']);
//                $width = $size[0];
//                $height = $size[1];
//
//                $slider_block_image_width = $slider_block . '_image_width';
//                $slider_block_image_height = $slider_block . '_image_height';
//                if(isset($this->$slider_block_image_width) && isset($this->$slider_block_image_height)) {
//                    if ($width != $this->$slider_block_image_width || $height != $this->$slider_block_image_height) {
//                        $this->image_lib->resizeImage($upload['full_path'], $this->$slider_block_image_width, $this->$slider_block_image_height);
//                    }
//                }
                
                $image_filename = url_title($slider_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($slider_old_image != '' && file_exists($this->file_dir . $slider_old_image)) {
                    @unlink($this->file_dir . $slider_old_image);
                }

                $data['slider_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_slider', 'slider_id', $slider_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
