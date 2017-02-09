<?php
/**
 * Description of backend
 *Backend Products Controller
 * 
 * @author Hanan Kusuma
 * @editor Fahrur Rifai
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Backend extends Backend_Controller{
    //put your code here
    
    function __construct() {
        parent::__construct();

        $this->load->model('products/backend_products_model');
        $this->load->helper('tinymce');
        $this->load->helper('form');

        $this->file_dir = _dir_products;
        $this->file_dir_item = _dir_products_item;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 600;
        $this->image_height = 1000;
    }
    
    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Products' => 'backend/products/show',
        );
        
        template('backend', 'products/backend_products_list_view', $data);
    }
    
    function add() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Produk' => 'backend/products/show',
            'Tambah Produk' => 'backend/products/add',
        );
        
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/products/act_add';
        
        template('backend', 'products/backend_products_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Produk' => 'backend/products/show',
            'Ubah Produk' => 'backend/products/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_product', 'product_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/products/act_edit';

        template('backend', 'products/backend_products_edit_view', $data);
    }

  
    function item_show($products_id = 0) {
        $products_name = $this->function_lib->get_one('site_product', 'product_name', array('product_id' => $products_id));
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Produk' => 'backend/products/show',
            'Produk Item &raquo; ' . $products_name => 'backend/products/item_show/' . $products_id,
        );
        
        $data['product_id'] = $products_id;
        $data['product_name'] = $products_name;
        if($products_id == 0 || $products_name == '') {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Data Galeri Item tidak ditemukan.</div>');
            redirect('backend/products/show');
        }
        
        template('backend', 'products/backend_products_item_list_view', $data);
    }

    

    function item_add($products_id = 0) {
        $products_name = $this->function_lib->get_one('site_product', 'product_name', array('product_id' => $products_id));
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Produk' => 'backend/products/show',
            'Produk Item &raquo; ' . $products_name => 'backend/products/item_show/' . $products_id,
            'Tambah Produk Item' => 'backend/products/item_add/' . $products_id,
        );
        
        $data['product_id'] = $products_id;
        $data['product_name'] = $products_name;
        if($products_id == 0 || $products_name == '') {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Data Galeri Item tidak ditemukan.</div>');
            redirect('backend/products/show');
        }
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/products/act_item_add';
        
        template('backend', 'products/backend_products_item_add_view', $data);
    }

    function item_edit() {
        $edit_id = $this->uri->segment(4);
        $products_id = $this->function_lib->get_one('site_product_item', 'product_item_product_id', (array('product_item_id' => $edit_id)));
        $products_name = $this->function_lib->get_one('site_product', 'product_name', array('product_id' => $products_id));
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Galeri' => 'backend/products/show',
            'Galeri Item &raquo; ' . $products_name => 'backend/products/item_show/' . $products_id,
            'Ubah Galeri Item' => 'backend/products/item_edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_product_item', 'product_item_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/products/act_item_edit';

        template('backend', 'products/backend_products_item_edit_view', $data);
    }

    
}

