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
        $this->load->model('frontend_testimony_model');
    }

    function index() {
         $data['arr_breadcrumbs'] = array(
            'Data Testimoni Member' => '#',
            'Testimoni Member' => '',
        );
        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 10;
        $config['base_url'] = site_url('testimony/index');
        $config['total_rows'] = $this->frontend_testimony_model->get_testimony_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Testimonial Member';
        $data['query'] = $this->frontend_testimony_model->get_testimony_list($offset, $limit);

        template('frontend', 'testimony/frontend_testimony_view', $data);
    }
}

?>
