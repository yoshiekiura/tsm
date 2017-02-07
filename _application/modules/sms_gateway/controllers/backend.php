<?php

/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of admin
 *
 * @author Yusuf Rahmanto
 */

class backend extends Backend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('backend_sms_gateway_model');
        $this->load->helper('form');
    }

    public function index()
    {
        $this->sms_list();
    }
    
    public function sms_list()
    {
        $data['arr_breadcrumbs'] = array(
            'SMS Gateway' => 'backend/sms_gateway',
            'Daftar SMS' => 'backend/sms_gateway/sms_list',
        );
        
        $where = '';
        
        if($this->input->post('search')) {
            $uri1 = $this->input->post('sms_type')?$this->input->post('sms_type'):0;
            $uri2 = $this->input->post('search_value')?$this->input->post('search_value'):0;
            $uri3 = $this->input->post('search_option')?$this->input->post('search_option'):0;
            redirect('backend/sms_gateway/sms_list/'.$uri1.'/'.$uri2.'/'.$uri3);
        }
        
        if($this->input->post('form_single')) {
            redirect("backend/sms_gateway/single_sms");
        }elseif($this->input->post('form_broadcast')) {
            redirect("backend/sms_gateway/broadcast");
        }
        
        if($this->input->post('delete')) {
            if(is_array($this->input->post('item'))) {
                foreach($this->input->post('item') as $x => $value) {
                    $this->backend_sms_gateway_model->delete_sms($value);
                }
            }
            else $data['error'] = 'Data belum dipilih';
        }
        
        if($this->uri->segment(4)){
            $where .= "sms_gateway_type='".$this->uri->segment(4)."' ";
        }
        if($this->uri->segment(5)){
            if($this->uri->segment(4)) $where .= ' AND ';
            $where .= $this->uri->segment(6)." LIKE '%".$this->uri->segment(5)."%'";
        }
                
        $this->load->library('pagination');
        $show = 30;
        $config['base_url'] = base_url() . "backend/sms_gateway/sms_list/" . $this->uri->segment(4,0) . "/" . $this->uri->segment(5,0) . "/" . $this->uri->segment(6,0);
        $config['total_rows'] = $this->backend_sms_gateway_model->count_sms($where);
        $config['uri_segment'] = 7;
        $config['per_page'] = $show;
        $this->pagination->initialize($config);
        $data['sms_list'] = $this->backend_sms_gateway_model->get_sms($where, $show, $this->uri->segment(7,0));
        $data['paging'] = $this->pagination->create_links();
        
        template('backend', 'sms_gateway/admin_sms_list', $data);
    }
    
    public function single_sms()
    {
        $data['arr_breadcrumbs'] = array(
            'SMS Gateway' => 'backend/sms_gateway',
            'Kirim SMS' => 'backend/sms_gateway/single_sms',
        );
        
        if($this->input->post('save'))
        {
            $berhasil = $gagal = 0;
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('sms_gateway_mobilephone', 'No HP','required');
            $this->form_validation->set_rules('sms_gateway_content', 'Isi pesan','required');
            if($this->form_validation->run() == TRUE)
            {
                $data_telepon = $this->input->post('sms_gateway_mobilephone');
                $data_network = $this->input->post('network_mid');
                
                $arr_telepon = explode(',', $data_telepon);
                $arr_network = explode(',', $data_network);
                
                for($c=0;$c<count($arr_telepon);$c++){
                    $telepon = trim($arr_telepon[$c]);
                    $network_mid = trim($arr_network[$c]);
                        
                    if($this->input->post('networn_mid')){
                        $get_network_id = $this->backend_sms_gateway_model->get_member_id_by_code($network_mid);
                    }
                    else {
                        $get_network_id = $this->backend_sms_gateway_model->get_member_id_by_phone($telepon);
                    }
                    $network_id = (empty($get_network_id))?0:$get_network_id;

                    $feedback = $this->backend_sms_gateway_model->send_sms($this->input->post('sms_gateway_content'), $telepon, $network_id);
                    
                    if($feedback) $berhasil++;
                    else $gagal++;
                }
                
                if($gagal>0) $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">'.$berhasil.' pesan berhasil dikirim, '.$gagal.' gagal.</div>');
                else $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">'.$berhasil.' pesan berhasil dikirim.</div>');
                redirect(get_class().'/sms_gateway/'.__FUNCTION__);
            }
        }
        
        template('backend', 'sms_gateway/admin_sms_single', $data);
    }
    
    public function broadcast()
    {
        $data['arr_breadcrumbs'] = array(
            'SMS Gateway' => 'backend/sms_gateway',
            'Kirim Broadcast' => 'backend/sms_gateway/broadcast',
        );
        
        $x=0;
        
        if($this->input->post('save'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('sms_gateway_content', 'Isi pesan','required');
            if($this->form_validation->run() == TRUE)
            {
                $member = $this->backend_sms_gateway_model->get_member_all();
                foreach ($member as $row){
                    $network_id = $row->member_network_id;
                    $telepon = $row->member_mobilephone;
                    $feedback = $this->backend_sms_gateway_model->send_sms($this->input->post('sms_gateway_content'), $telepon, $network_id, 'broadcast');
                    
                    if($feedback) $x++;
                    if($x % 50 == 0) sleep(2);
                }
                $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">'.$x.' Pesan berhasil dikirim.</div>');
                redirect(get_class().'/sms_gateway/'.__FUNCTION__);
            }
        }
        
        template('backend', 'sms_gateway/admin_sms_broadcast', $data);
    }

    public function cek_hp()
    {
        $str_member_hp = '';
        $code = $this->input->post('code');
        $arr_code = explode(',', $code);
        for($c=0;$c<count($arr_code);$c++){
            $network_id = $this->backend_sms_gateway_model->get_member_id_by_code(trim($arr_code[$c]));
            $member_hp = $this->backend_sms_gateway_model->get_phone_by_member_id($network_id);
            $member_hp = (!empty($member_hp))? $member_hp : 'TidakDitemukan';
            $str_member_hp = ($c==0)? $member_hp : $str_member_hp.', '.$member_hp;
        }
        
        echo json_encode($str_member_hp);
    }
}

?>
