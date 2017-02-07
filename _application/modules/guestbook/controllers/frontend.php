<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of frontend
 *
 * @author Yusuf Rahmanto
 */
class frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index(){
        $params['table'] = "site_guestbook_configuration";
        $params['where'] = "guestbook_configuration_is_show = '1'";
        $params['sortname'] = "guestbook_configuration_order_by";
        $params['sortorder'] = "ASC";
        $data['query'] = $this->function_lib->get_query_data($params)->result();
        
        template('frontend', 'guestbook/frontend_guestbook_view', $data);
    }
    
    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');
        $this->form_validation->set_rules('title', '<b>Judul</b>', 'required');

        if ($this->form_validation->run() == TRUE) {
            $gallery_title = $this->input->post('title');
            $gallery_description = $this->input->post('description');

            $data = array();
            $data['gallery_title'] = $gallery_title;
            $data['gallery_description'] = $gallery_description;
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
}

?>
