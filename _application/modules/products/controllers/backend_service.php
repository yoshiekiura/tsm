<?php

/*
 * Backend Service Page Marketing Plan Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('products/backend_products_model');
        $this->load->helper('form');

        
        $this->file_dir = _dir_products;
        $this->file_dir_item = _dir_products_item;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 600;
        $this->image_height = 1000;
    }


function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['select'] = "
            site_product.*, 
            COUNT(product_item_id) AS product_item_count 
        ";
        $params['table'] = "site_product";
         $params['join'] = "LEFT JOIN site_product_item ON product_item_product_id = product_id";
        $params['group_by_detail'] = "product_id";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);
        
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->product_image != '' && file_exists($this->file_dir . $row->product_image)) {
                $image = $row->product_image;
            } else {
                $image = 'no-image.jpg';
            }
            $image = '<img src="' . base_url() . $this->file_dir . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->product_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/products/edit/' . $row->product_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            //detail item
            $detail_item = '<a href="' . base_url() . 'backend/products/item_show/' . $row->product_id . '"><img src="' . base_url() . _dir_icon . 'images.png" border="0" alt="Galeri Item" title="Galeri Item" /></a>';

            $entry = array('id' => $row->product_id,
                'cell' => array(
                    'product_id' => $row->product_id,
                    'product_name' => $row->product_name,
                    'product_description' => nl2br($row->product_description),
                    'product_price_member' => $this->function_lib->set_number_format($row->product_price_member),
                    'product_price_non' => $this->function_lib->set_number_format($row->product_price_non),
                    'product_image' => $image,
                    'product_item_count' => $this->function_lib->set_number_format($row->product_item_count),
                    'product_is_active' => $is_active,
                    'detail_item' => $detail_item,
                    'edit' => $edit
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
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
                    
                    // //hapus file gambar item
                     $query_item = $this->backend_products_model->get_list_item($id);
                     if($query_item->num_rows() > 0) {
                         foreach($query_item->result() as $row_item) {
                             $item_filename = $row_item->product_item_image;
                             if ($item_filename != '' && file_exists($this->file_dir_item . $item_filename)) {
                                 @unlink($this->file_dir_item . $item_filename);
                             }
                         }
                     }
                    
                    // //hapus data item
                     $this->function_lib->delete_data('site_product_item', 'product_item_product_id', $id);
                    
                    //hapus file gambar
                    $filename = $this->function_lib->get_one('site_product', 'product_image', array('product_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir . $filename)) {
                        @unlink($this->file_dir . $filename);
                    }
                    
                    //hapus data
                    $this->function_lib->delete_data('site_product', 'product_id', $id);
                    
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
                    $data['product_is_active'] = '1';
                    $this->function_lib->update_data('site_product', 'product_id', $id, $data);
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
                    $data['product_is_active'] = '0';
                    $this->function_lib->update_data('site_product', 'product_id', $id, $data);
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

    function act_add() {
        $inputdate = date("Y-m-d H:i:s");
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('name', '<b>Nama Produk</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            $this->session->set_flashdata('input_description', $this->input->post('description'));
            $this->session->set_flashdata('input_member_price', $this->input->post('member_price'));
            $this->session->set_flashdata('input_nonmember_price', $this->input->post('nonmember_price'));
            redirect($this->input->post('uri_string'));
        } else {
            $products_name = $this->input->post('name');
            $products_description = $this->input->post('description');
            $products_member_price = $this->input->post('member_price');
            $products_nonmember_price = $this->input->post('nonmember_price');

            $data = array();
            $data['product_name'] = $products_name;
            $data['product_description'] = $products_description;
            $data['product_price_member'] = $products_member_price;
            $data['product_price_non'] = $products_nonmember_price;
            $data['product_create_datetime'] = date('Y-m-d H:i:s');

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($products_name) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['product_image'] = $image_filename;
            } else {
                $data['product_image'] = '';
            }
            $data['product_create_datetime'] = $inputdate;
            $this->function_lib->insert_data('site_product', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }

     function act_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('name', '<b>Nama Produk</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_name', $this->input->post('name'));
            $this->session->set_flashdata('input_description', $this->input->post('description'));
            $this->session->set_flashdata('input_member_price', $this->input->post('member_price'));
            $this->session->set_flashdata('input_nonmember_price', $this->input->post('nonmember_price'));
            redirect($this->input->post('uri_string'));
        } else {
            $products_id = $this->input->post('id');
            $products_old_image = $this->input->post('old_image');

            $products_name = $this->input->post('name');
            $products_description = $this->input->post('description');
            $products_member_price = $this->input->post('member_price');
            $products_nonmember_price = $this->input->post('nonmember_price');

            $data = array();
            $data['product_name'] = $products_name;
            $data['product_description'] = $products_description;
            $data['product_price_member'] = $products_member_price;
            $data['product_price_non'] = $products_nonmember_price;

            if ($this->upload->fileUpload('image', $this->file_dir, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }
                 

                $image_filename = url_title($products_name) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                //delete old file
                if ($products_old_image != '' && file_exists($this->file_dir . $products_old_image)) {
                    @unlink($this->file_dir . $products_old_image);
                }
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

               

                $data['product_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_product', 'product_id', $products_id, $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function get_item_data($products_id = 0) {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_product_item";
        $params['where'] = "product_item_product_id = '" . $products_id . "'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //image
            if ($row->product_item_image != '' && file_exists($this->file_dir_item . $row->product_item_image)) {
                $image = $row->product_item_image;
            } else {
                $image = 'no-image.jpg';
            }
            $image = '<img src="' . base_url() . $this->file_dir_item . $image . '" border="0" width="110" align="absmiddle" alt="' . $image . '" />';

            //is_active
            if ($row->product_item_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';

            //edit
            $edit = '<a href="' . base_url() . 'backend/products/item_edit/' . $row->product_item_id . '"><img src="' . base_url() . _dir_icon . 'save_labled_edit.png" border="0" alt="Edit" title="Edit" /></a>';

            $entry = array('id' => $row->product_item_id,
                'cell' => array(
                    'product_item_id' => $row->product_item_id,
                    'product_item_name' => $row->product_item_name,
                    'product_item_price' => $this->function_lib->set_number_format($row->product_item_price),
                    'product_item_image' => $image,
                    'product_item_bpom' => $row->product_item_bpom,
                    'product_item_ingredient' => $row->product_item_ingredient,
                    'product_item_benefit' => $row->product_item_benefit,
                    'product_item_how_to_use' => $row->product_item_how_to_use,
                    'product_item_image' => $image,
                    'product_item_is_active' => $is_active,
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
        $this->form_validation->set_rules('subproduct_name', '<b>Nama Item Produk</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_subproduct_name', $this->input->post('subproduct_name'));
            $this->session->set_flashdata('input_subproduct_composition', $this->input->post('subproduct_composition'));
            $this->session->set_flashdata('input_subproduct_benefit', $this->input->post('subproduct_benefit'));
            $this->session->set_flashdata('input_subproduct_usage', $this->input->post('subproduct_usage'));
            $this->session->set_flashdata('input_subproduct_price', $this->input->post('subproduct_price'));
            $this->session->set_flashdata('input_subproduct_bppom', $this->input->post('subproduct_bppom'));
            redirect($this->input->post('uri_string'));
        } else {
            $products_id = $this->input->post('product_id');
            
            $products_item_order_by = $this->function_lib->get_max('site_product_item', 'product_item_order_by', array('product_item_product_id' => $products_id)) + 1;

            $data = array();
            $data['product_item_product_id'] = $products_id;
            $data['product_item_name'] = $this->input->post('subproduct_name');
            $data['product_item_price'] = $this->input->post('subproduct_price');
            $data['product_item_order_by'] = $products_item_order_by;
            $data['product_item_bpom'] = $this->input->post('subproduct_bpom');
            $data['product_item_ingredient'] = $this->input->post('subproduct_composition');
            $data['product_item_benefit'] = $this->input->post('subproduct_benefit');
            $data['product_item_how_to_use'] = $this->input->post('subproduct_usage');
            $data['product_item_create_datetime'] = date('Y-m-d H:i:s');
            
            if ($this->upload->fileUpload('subproduct_image', $this->file_dir_item, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($this->input->post('subproduct_name')) .  strtolower($upload['file_ext']);
                
                if($image_filename != '' && file_exists($this->file_dir_item . $image_filename)) {
                    unlink($this->file_dir_item . $image_filename);
                }
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                $data['product_item_image'] = $image_filename;
            } else {
                $data['product_item_image'] = '';
            }
            $this->function_lib->insert_data('site_product_item', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function act_item_edit() {
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('subproduct_name', '<b>Nama Produk Item</b>', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_subproduct_name', $this->input->post('subproduct_name'));
            $this->session->set_flashdata('input_subproduct_composition', $this->input->post('subproduct_composition'));
            $this->session->set_flashdata('input_subproduct_benefit', $this->input->post('subproduct_benefit'));
            $this->session->set_flashdata('input_subproduct_usage', $this->input->post('subproduct_usage'));
            $this->session->set_flashdata('input_subproduct_price', $this->input->post('subproduct_price'));
            $this->session->set_flashdata('input_subproduct_bppom', $this->input->post('subproduct_bppom'));
            redirect($this->input->post('uri_string'));
        } else {
            $products_item_id = $this->input->post('id');
            $products_old_image = $this->input->post('old_image');

            $data['product_item_name'] = $this->input->post('subproduct_name');
            $data['product_item_price'] = $this->input->post('subproduct_price');
            $data['product_item_bpom'] = $this->input->post('subproduct_bpom');
            $data['product_item_ingredient'] = $this->input->post('subproduct_composition');
            $data['product_item_benefit'] = $this->input->post('subproduct_benefit');
            $data['product_item_how_to_use'] = $this->input->post('subproduct_usage');
            
            if ($this->upload->fileUpload('subproduct_image', $this->file_dir_item, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                }
                if ($products_old_image != '' && file_exists($this->file_dir_item . $products_old_image)) {
                    @unlink($this->file_dir_item . $products_old_image);
                }
                $image_filename = url_title($this->input->post('subproduct_name')) . strtolower($upload['file_ext']);
                
                rename($upload['full_path'], $upload['file_path'] . $image_filename);
                
                
                $data['product_item_image'] = $image_filename;
            }
            $this->function_lib->update_data('site_product_item', 'product_item_id', $products_item_id, $data);
            
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
                    //hapus file gambar
                    $filename = $this->function_lib->get_one('site_product_item', 'product_item_image', array('product_item_id' => $id));
                    if ($filename != '' && file_exists($this->file_dir_item . $filename)) {
                        @unlink($this->file_dir_item . $filename);
                    }
                    
                    //hapus data
                    $this->function_lib->delete_data('site_product_item', 'product_item_id', $id);
                    
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
                    $data['product_item_is_active'] = '1';
                    $this->function_lib->update_data('site_product_item', 'product_item_id', $id, $data);
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
                    $data['product_item_is_active'] = '0';
                    $this->function_lib->update_data('site_product_item', 'product_item_id', $id, $data);
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
                    if($this->backend_products_model->update_item_order_by($id, 'up')) {
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
                    if($this->backend_products_model->update_item_order_by($id, 'down')) {
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

    
}
