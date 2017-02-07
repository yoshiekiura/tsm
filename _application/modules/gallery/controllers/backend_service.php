<?php

/*
 * Backend Service Gallery Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('gallery/backend_gallery_model');
        $this->load->helper('form');

        $this->file_dir = _dir_gallery;
        $this->file_dir_item = _dir_gallery_item;
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
                    $query_item = $this->backend_gallery_model->get_list_item($id);
                    if($query_item->num_rows() > 0) {
                        foreach($query_item->result() as $row_item) {
                            $item_filename = $row_item->gallery_item_image;
                            if ($item_filename != '' && file_exists($this->file_dir_item . $item_filename)) {
                                @unlink($this->file_dir_item . $item_filename);
                            }
                        }
                    }
                    
                    //hapus data item
                    $this->function_lib->delete_data('site_gallery_item', 'gallery_item_gallery_id', $id);
                    
                    //hapus file gambar
                    $filename = $this->function_lib->get_one('site_gallery', 'gallery_image', array('gallery_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir . $filename)) {
                        @unlink($this->file_dir . $filename);
                    }
                    
                    //hapus data
                    $this->function_lib->delete_data('site_gallery', 'gallery_id', $id);
                    
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
                    $data['gallery_is_active'] = '1';
                    $this->function_lib->update_data('site_gallery', 'gallery_id', $id, $data);
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
                    $data['gallery_is_active'] = '0';
                    $this->function_lib->update_data('site_gallery', 'gallery_id', $id, $data);
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
            site_gallery.*, 
            COUNT(gallery_item_id) AS gallery_item_count 
        ";
        $params['table'] = "site_gallery";
        $params['join'] = "LEFT JOIN site_gallery_item ON gallery_item_gallery_id = gallery_id";
        $params['group_by_detail'] = "gallery_id";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->gallery_image != '' && file_exists($this->file_dir . $row->gallery_image)) {
                $image = $row->gallery_image;
            } else {
                $image = '_default.jpg';
            }
            $image = '<img src="' . base_url() . $this->file_dir . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->gallery_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/gallery/edit/' . $row->gallery_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            //detail item
            $detail_item = '<a href="' . base_url() . 'backend/gallery/item_show/' . $row->gallery_id . '"><img src="' . base_url() . _dir_icon . 'images.png" border="0" alt="Galeri Item" title="Galeri Item" /></a>';

            $entry = array('id' => $row->gallery_id,
                'cell' => array(
                    'gallery_id' => $row->gallery_id,
                    'gallery_title' => $row->gallery_title,
                    'gallery_description' => nl2br($row->gallery_description),
                    'gallery_image' => $image,
                    'gallery_item_count' => $this->function_lib->set_number_format($row->gallery_item_count),
                    'gallery_is_active' => $is_active,
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
            $gallery_title = $this->input->post('title');
            $gallery_description = $this->input->post('description');
            $date = date('Y-m-d');
            
            $data = array();
            $data['gallery_title'] = $gallery_title;
            $data['gallery_description'] = $gallery_description;
            $data['gallery_date'] = $date;
            $data['gallery_is_active'] = 1;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($gallery_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['gallery_image'] = $image_filename;
            } else {
                $data['gallery_image'] = '';
            }
            $this->function_lib->insert_data('site_gallery', $data);
            
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
            $gallery_id = $this->input->post('id');
            $gallery_title = $this->input->post('title');
            $gallery_description = $this->input->post('description');
            $gallery_old_image = $this->input->post('old_image');

            $data = array();
            $data['gallery_title'] = $gallery_title;
            $data['gallery_description'] = $gallery_description;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($gallery_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($gallery_old_image != '' && file_exists($this->file_dir . $gallery_old_image)) {
                    @unlink($this->file_dir . $gallery_old_image);
                }

                $data['gallery_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_gallery', 'gallery_id', $gallery_id, $data);
            
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
                    $filename = $this->function_lib->get_one('site_gallery_item', 'gallery_item_image', array('gallery_item_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir_item . $filename)) {
                        @unlink($this->file_dir_item . $filename);
                    }
                    
                    //hapus data item
                    $this->function_lib->delete_data('site_gallery_item', 'gallery_item_id', $id);
                    
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
                    $data['gallery_item_is_active'] = '1';
                    $this->function_lib->update_data('site_gallery_item', 'gallery_item_id', $id, $data);
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
                    $data['gallery_item_is_active'] = '0';
                    $this->function_lib->update_data('site_gallery_item', 'gallery_item_id', $id, $data);
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
                    if($this->backend_gallery_model->update_item_order_by($id, 'up')) {
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
                    if($this->backend_gallery_model->update_item_order_by($id, 'down')) {
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

    function get_item_data($gallery_id = 0) {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_gallery_item";
        $params['where'] = "gallery_item_gallery_id = '" . $gallery_id . "'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->gallery_item_image != '' && file_exists($this->file_dir_item . $row->gallery_item_image)) {
                $image = $row->gallery_item_image;
            } else {
                $image = '_default.jpg';
            }
            $image = '<img src="' . base_url() . $this->file_dir_item . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->gallery_item_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/gallery/item_edit/' . $row->gallery_item_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->gallery_item_id,
                'cell' => array(
                    'gallery_item_id' => $row->gallery_item_id,
                    'gallery_item_title' => $row->gallery_item_title,
                    'gallery_item_description' => nl2br($row->gallery_item_description),
                    'gallery_item_image' => $image,
                    'gallery_item_is_active' => $is_active,
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
            $gallery_id = $this->input->post('gallery_id');
            $gallery_item_title = $this->input->post('title');
            $gallery_item_description = $this->input->post('description');
            $gallery_item_order_by = $this->function_lib->get_max('site_gallery_item', 'gallery_item_order_by', array('gallery_item_gallery_id' => $gallery_id)) + 1;

            $data = array();
            $data['gallery_item_gallery_id'] = $gallery_id;
            $data['gallery_item_title'] = $gallery_item_title;
            $data['gallery_item_description'] = $gallery_item_description;
            $data['gallery_item_order_by'] = $gallery_item_order_by;
            $data['gallery_item_is_active'] = 1;

            if ($this->upload->fileUpload('image', $this->file_dir_item, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($gallery_item_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['gallery_item_image'] = $image_filename;
            } else {
                $data['gallery_item_image'] = '';
            }
            $this->function_lib->insert_data('site_gallery_item', $data);
            
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
            $gallery_item_id = $this->input->post('id');
            $gallery_item_title = $this->input->post('title');
            $gallery_item_description = $this->input->post('description');
            $gallery_item_old_image = $this->input->post('old_image');

            $data = array();
            $data['gallery_item_title'] = $gallery_item_title;
            $data['gallery_item_description'] = $gallery_item_description;

            if ($this->upload->fileUpload('image', $this->file_dir_item, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($gallery_item_title) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($gallery_item_old_image != '' && file_exists($this->file_dir_item . $gallery_item_old_image)) {
                    @unlink($this->file_dir_item . $gallery_item_old_image);
                }

                $data['gallery_item_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_gallery_item', 'gallery_item_id', $gallery_item_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

}
