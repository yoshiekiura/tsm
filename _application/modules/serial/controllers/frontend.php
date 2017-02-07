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

        $this->load->model('frontend_serial_model');
        $this->load->helper('form');
    }

    function index() {
        $ajax = "<script type=\"text/javascript\">";
        $ajax .= "var site = \"".base_url()."\";";
        $ajax .= "$(function(){
                    $(\"#button\").bind('click',function(){
                        var serial= $('#serial').val();
                        if(serial !== \"\")
                        {
                            $('#result').fadeIn('slow',function(){
                                $('#result').html('loading');
                            });
                            $.ajax({
                                    type: \"POST\",
                                    data: \"serial=\"+serial,
                                    url:  \"".base_url()."serial/cek\",
                                    success: function(response){
                                    $('#result').html(response);
                                        },
                                    dataType:\"html\"
                                    });
                            return false;
                        }
                        else $('#result').html(\"\");
                    });
                    });";
        $ajax .="</script>";
        $data['extra_head_content'] = $ajax;
        
        $data['page_title'] = 'Kartu';
        
        template('frontend', 'serial/frontend_cek_serial_view', $data);
    }
    
    public function cek()
    {
        $data = array();
        $serial_id = $this->input->post('serial');
        $serial = $this->function_lib->get_detail_data('view_serial','serial_id',$serial_id)->row_array();
        if(empty($serial)) {
            $data['teks'] = "Kartu {$serial_id} tidak ada dalam database kami";
        }
        else{
            if($serial['serial_is_used'] == '1') {
                $data['teks'] = "Kartu {$serial_id} sudah dipakai <br />Kartu dipakai Oleh <b>{$serial['user_network_code']}</b>({$serial['user_member_name']}) ";
            }
            elseif($serial['serial_is_active'] == '0' && $serial['buyer_network_id'] !== '0') {
                $data_member = $this->function_lib->get_detail_data('view_member','network_id',$serial['buyer_network_id'])->row_array();
                $data['teks'] = "Kartu {$serial_id} Belum diaktifkan <br />Kartu dibeli Oleh <b>{$serial['buyer_network_code']}</b>({$serial['buyer_member_name']}) <br />HP: {$serial['buyer_member_mobilephone']} <br />{$data_member['member_city_name']},{$data_member['member_province_name']}";
            }
            elseif($serial['serial_is_active'] == '1' && $serial['serial_is_used'] == '0') {
                    $data['teks'] = "Kartu {$serial_id} aktif dan belum digunakan";
            }
            else {
                $data['teks'] = "Kartu {$serial_id} "." belum diaktifkan";
            }
        }
        $this->load->view('view_cek_kartu',$data);
    }
}

?>
