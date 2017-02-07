<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of frontend
 *
 * @author Yusuf Rahmanto
 */
class frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('frontend_gallery_model');
    }

    public function index() {
         $data['arr_breadcrumbs'] = array(
            'Gallery' => '#',
            'Data Gallery' => '',
        );
        
         $this->load->library('pagination');

        
        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 18;
        $config['base_url'] = site_url('gallery/index');
        $config['total_rows'] = $this->frontend_gallery_model->get_gallery(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Galeri Foto';
        $data['query'] = $this->frontend_gallery_model->get_gallery($offset, $limit)->result();
        //$data['category'] = $this->frontend_gallery_model->get_gallery_category()->result();

        template('frontend', 'gallery/frontend_gallery_list_view', $data);
    }
    
    public function detail_gallery(){
        $data['arr_breadcrumbs'] = array(
            'Gallery' => '#',
            'Gallery Detail' => '',
        );
        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(4, 0);
        $limit = 9;
        $config['base_url'] = site_url('gallery/detail_gallery/'.$this->uri->segment(3));
        $config['total_rows'] = $this->frontend_gallery_model->get_gallery_detail_list($this->uri->segment(3), 0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Detail Gallery Foto';
        $data['gallery'] = $this->frontend_gallery_model->get_gallery_date($this->uri->segment(3));
        $data['query'] = $this->frontend_gallery_model->get_gallery_detail_list($this->uri->segment(3), $offset, $limit)->result();

        template('frontend', 'gallery/frontend_gallery_item_list_view', $data);
    }
    
    public function category() {
        $this->load->library('pagination');

        //pagination
        $cat = (int) $this->uri->segment(3, 0);
        $offset = (int) $this->uri->segment(4, 0);
        $limit = 9;
        $config['base_url'] = site_url('gallery/index');
        $config['total_rows'] = $this->frontend_gallery_model->get_gallery_by_category($cat, 0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Galeri Foto';
        $data['query'] = $this->frontend_gallery_model->get_gallery_by_category($cat, $offset, $limit)->result();
        $data['category'] = $this->frontend_gallery_model->get_gallery_category()->result();

        template('frontend', 'gallery/frontend_gallery_category_view', $data);
    }
}

?>
