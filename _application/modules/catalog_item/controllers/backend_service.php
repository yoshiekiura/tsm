<?php

/*
 * Backend Service Catalog Item Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('catalog_item/backend_catalog_item_model');
        $this->load->helper('form');

        $this->file_dir = _dir_catalog_item;
        $this->file_dir_item = _dir_catalog_item_detail;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 600;
        $this->image_height = 1000;
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
                    $query_item = $this->backend_catalog_item_model->get_list_item($id);
                    if($query_item->num_rows() > 0) {
                        foreach($query_item->result() as $row_item) {
                            $item_filename = $row_item->catalog_item_image;
                            if ($item_filename != '' && file_exists($this->file_dir_item . $item_filename)) {
                                @unlink($this->file_dir_item . $item_filename);
                            }
                        }
                    }
                    
                    //hapus data item
                    $this->function_lib->delete_data('site_catalog_item_detail', 'catalog_item_detail_item_id', $id);
                    
                    //hapus file gambar
                    $filename = $this->function_lib->get_one('site_catalog_item', 'catalog_item_detail_image', array('catalog_item_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir . $filename)) {
                        @unlink($this->file_dir . $filename);
                    }
                    
                    //hapus data
                    $this->function_lib->delete_data('site_catalog_item', 'catalog_item_id', $id);
                    
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
                    $data['catalog_item_is_active'] = '1';
                    $this->function_lib->update_data('site_catalog_item', 'catalog_item_id', $id, $data);
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
                    $data['catalog_item_is_active'] = '0';
                    $this->function_lib->update_data('site_catalog_item', 'catalog_item_id', $id, $data);
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

    function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['select'] = "
            site_catalog_item.*, 
            COUNT(catalog_item_detail_id) AS catalog_item_detail_count 
        ";
        $params['table'] = "site_catalog_item";
        $params['join'] = "LEFT JOIN site_catalog_item_detail ON catalog_item_detail_item_id = catalog_item_id";
        $params['group_by_detail'] = "catalog_item_id";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->catalog_item_image != '' && file_exists($this->file_dir . $row->catalog_item_image)) {
                $image = $row->catalog_item_image;
            } else {
                $image = '_default.jpg';
            }
            $image = '<img src="' . base_url() . $this->file_dir . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->catalog_item_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/catalog_item/edit/' . $row->catalog_item_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            //detail item
            $detail_item = '<a href="' . base_url() . 'backend/catalog_item/item_show/' . $row->catalog_item_id . '"><img src="' . base_url() . _dir_icon . 'images.png" border="0" alt="Galeri Item" title="Catalog Item" /></a>';

            $entry = array('id' => $row->catalog_item_id,
                'cell' => array(
                    'catalog_item_id' => $row->catalog_item_id,
                    'catalog_item_title' => $row->catalog_item_title,
                    'catalog_item_description' => nl2br($row->catalog_item_description),
                    'catalog_item_image' => $image,
                    'catalog_item_detail_count' => $this->function_lib->set_number_format($row->catalog_item_detail_count),
                    'catalog_item_is_active' => $is_active,
                    'detail_item' => $detail_item,
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
            $catalog_item_title = $this->input->post('title');
            $catalog_item_description = $this->input->post('description');
            $date = date('Y-m-d');
            
            $data = array();
            $data['catalog_item_title'] = $catalog_item_title;
            $data['catalog_item_description'] = $catalog_item_description;
            $data['catalog_item_date'] = $date;
            $data['catalog_item_is_active'] = 1;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($catalog_item_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['catalog_item_image'] = $image_filename;
            } else {
                $data['catalog_item_image'] = '';
            }
            $this->function_lib->insert_data('site_catalog_item', $data);
            
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
            $this->session->set_flashdata('input_description', $this->input->post('description'));
            redirect($this->input->post('uri_string'));
        } else {
            $catalog_item_id = $this->input->post('id');
            $catalog_item_title = $this->input->post('title');
            $catalog_item_description = $this->input->post('description');
            $catalog_item_old_image = $this->input->post('old_image');

            $data = array();
            $data['catalog_item_title'] = $catalog_item_title;
            $data['catalog_item_description'] = $catalog_item_description;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($catalog_item_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($catalog_item_old_image != '' && file_exists($this->file_dir . $catalog_item_old_image)) {
                    @unlink($this->file_dir . $catalog_item_old_image);
                }

                $data['catalog_item_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_catalog_item', 'catalog_item_id', $catalog_item_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function act_item_show() {
        
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
                    $filename = $this->function_lib->get_one('site_catalog_item_detail', 'catalog_item_detail_image', array('catalog_item_detail_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir_item . $filename)) {
                        @unlink($this->file_dir_item . $filename);
                    }
                    
                    //hapus data item
                    $this->function_lib->delete_data('site_catalog_item_detail', 'catalog_item_detail_id', $id);
                    
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
                    $data['catalog_item_detail_is_active'] = '1';
                    $this->function_lib->update_data('site_catalog_item_detail', 'catalog_item_detail_id', $id, $data);
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
                    $data['catalog_item_detail_is_active'] = '0';
                    $this->function_lib->update_data('site_catalog_item_detail', 'catalog_item_detail_id', $id, $data);
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
                    if($this->backend_catalog_item_model->update_item_order_by($id, 'up')) {
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
                    if($this->backend_catalog_item_model->update_item_order_by($id, 'down')) {
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

    function get_item_data($catalog_item_id = 0) {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_catalog_item_detail";
        $params['where'] = "catalog_item_detail_item_id = '" . $catalog_item_id . "'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->catalog_item_detail_image != '' && file_exists($this->file_dir_item . $row->catalog_item_detail_image)) {
                $image = $row->catalog_item_detail_image;
            } else {
                $image = '_default.jpg';
            }
            $image = '<img src="' . base_url() . $this->file_dir_item . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->catalog_item_detail_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/catalog_item/item_edit/' . $row->catalog_item_detail_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->catalog_item_detail_id,
                'cell' => array(
                    'catalog_item_detail_id' => $row->catalog_item_detail_id,
                    'catalog_item_detail_title' => $row->catalog_item_detail_title,
                    'catalog_item_detail_description' => nl2br($row->catalog_item_detail_description),
                    'catalog_item_detail_image' => $image,
                    'catalog_item_detail_is_active' => $is_active,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_item_add() {
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
            $catalog_item_id = $this->input->post('catalog_item_id');
            $catalog_item_detail_title = $this->input->post('title');
            $catalog_item_detail_description = $this->input->post('description');
            $catalog_item_detail_order_by = $this->function_lib->get_max('site_catalog_item_detail', 'catalog_item_detail_order_by', array('catalog_item_detail_item_id' => $catalog_item_id)) + 1;

            $data = array();
            $data['catalog_item_detail_item_id'] = $catalog_item_id;
            $data['catalog_item_detail_title'] = $catalog_item_detail_title;
            $data['catalog_item_detail_description'] = $catalog_item_detail_description;
            $data['catalog_item_detail_order_by'] = $catalog_item_detail_order_by;
            $data['catalog_item_detail_is_active'] = 1;

            if ($this->upload->fileUpload('image', $this->file_dir_item, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($catalog_item_detail_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['catalog_item_detail_image'] = $image_filename;
            } else {
                $data['catalog_item_detail_image'] = '';
            }
            $this->function_lib->insert_data('site_catalog_item_detail', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

    function act_item_edit() {
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
            $catalog_item_detail_id = $this->input->post('id');
            $catalog_item_detail_title = $this->input->post('title');
            $catalog_item_detail_description = $this->input->post('description');
            $catalog_item_detail_old_image = $this->input->post('old_image');

            $data = array();
            $data['catalog_item_detail_title'] = $catalog_item_detail_title;
            $data['catalog_item_detail_description'] = $catalog_item_detail_description;

            if ($this->upload->fileUpload('image', $this->file_dir_item, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($catalog_item_detail_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($catalog_item_detail_old_image != '' && file_exists($this->file_dir_item . $catalog_item_detail_old_image)) {
                    @unlink($this->file_dir_item . $catalog_item_detail_old_image);
                }

                $data['catalog_item_detail_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_catalog_item_detail', 'catalog_item_detail_id', $catalog_item_detail_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
