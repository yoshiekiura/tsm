<?php

/*
 * Function Libraries
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Function_lib {

    var $CI;

    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }
    
    function set_number_format($number, $is_int = true, $decimals = 2) {
        if(is_numeric($number) && floor($number) != $number && $is_int == false) {
            return number_format($number, $decimals, ',', '.');
        } else {
            return number_format($number, 0, ',', '.');
        }
    }
    
    function convert_number_to_string($value = 0) {
        $new_value = 0;

        if($value >= 1000000000) {
            $new_value = $this->set_number_format($value / 1000000000, false, 1) . ' M'; // milyar
        } elseif($value >= 1000000) {
            $new_value = $this->set_number_format($value / 1000000, false, 1) . ' juta'; // juta
        } elseif($value >= 10000) {
            $new_value = $this->set_number_format($value / 1000, false, 1) . ' ribu'; // ribu
        } else {
            $new_value = $this->set_number_format($value, false, 1);
        }

        return $new_value;
    }
    
    function generate_number($length) {
        $pin_str = "1234567809";
        for ($i = 0; $i < strlen($pin_str); $i++) {
            $pin_chars[$i] = $pin_str[$i];
        }
        // randomize the chars
        srand((float) microtime() * 1000000);
        shuffle($pin_chars);
        $pin = "";
        for ($i = 0; $i < 20; $i++) {
            $char_num = rand(1, count($pin_chars));
            $pin .= $pin_chars[$char_num - 1];
        }
        $pin = substr($pin, 0, $length);

        return $pin;
    }
    
    function generate_alpha_number($length) {
        $charset = 'ABCDEFGHKLMNPRSTUVWYZ23456789';
        $code = '';

        for ($i = 1, $cslen = strlen($charset); $i <= $length; ++$i) {
            $code .= $charset{rand(0, $cslen - 1)};
        }
        return $code;
    }

    function multidimensional_array_sort(&$array, $key, $sort = 'asc') {
        $sorter = array();
        $ret = array();
        reset($array);

        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }

        if ($sort == 'desc') {
            arsort($sorter);
        } else {
            asort($sorter);
        }

        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }

        return $ret;
    }

    function get_one($table_name = '', $fieldname = null, $where = null, $fieldsort = null, $sort = 'asc') {
        $this->CI->db->select($fieldname);
        if($where != null) {
            $this->CI->db->where($where);
        }
        if($fieldsort == null) {
            $fieldsort = $fieldname;
        }
        $this->CI->db->order_by($fieldsort, $sort);
        $this->CI->db->offset(0);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get($table_name);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result = $row->$fieldname;
        } else {
            $result = '';
        }
        return $result;
    }

    function get_max($table_name = '', $fieldname = null, $where = null) {
        $this->CI->db->select("IFNULL(MAX(" . $fieldname . "), 0) AS " . $fieldname, false);
        if($where != null) {
            if(is_array($where)) {
                $this->CI->db->where($where);
            } else {
                $this->CI->db->where($where, false);
            }
        }
        $query = $this->CI->db->get($table_name);
        $row = $query->row();
        return $row->$fieldname;
    }

    function get_min($table_name = '', $fieldname = null, $where = null) {
        $this->CI->db->select("IFNULL(MIN(" . $fieldname . "), 0) AS " . $fieldname, false);
        if($where != null) {
            if(is_array($where)) {
                $this->CI->db->where($where);
            } else {
                $this->CI->db->where($where, false);
            }
        }
        $query = $this->CI->db->get($table_name);
        $row = $query->row();
        return $row->$fieldname;
    }

    function get_detail_data($table_name, $fieldname, $value_id) {
        $this->CI->db->select('*');
        $this->CI->db->from($table_name);
        $this->CI->db->where($fieldname, $value_id);
        return $this->CI->db->get();
    }
    
    function last_id(){
        $query = $this->CI->db->query('SELECT LAST_INSERT_ID() AS last_insert_id');
        $row = $query->row();
        return $row->last_insert_id;
    }
    
    function insert_data($table_name, $data) {
        $this->CI->db->insert($table_name, $data);
        return $this->CI->db->insert_id();
    }
    
    function update_data($table_name, $fieldname, $value_id, $data) {
        $this->CI->db->where($fieldname, $value_id);
        $this->CI->db->update($table_name, $data);
    }

    function delete_data($table_name, $fieldname, $value_id) {
        $this->CI->db->where($fieldname, $value_id);
        $this->CI->db->delete($table_name);
    }
    
    function get_city_name($id) {
        return self::get_one('ref_city', 'city_name', array('city_id' => $id));
    }
    
    function get_province_name($id) {
        return self::get_one('ref_province', 'province_name', array('province_id' => $id));
    }
    
    function get_province_name_by_city_id($id) {
        $province_id = self::get_one('ref_city', 'city_province_id', array('city_id' => $id));
        
        return self::get_one('ref_province', 'province_name', array('province_id' => $province_id));
    }
    
    function get_region_name($id) {
        return self::get_one('ref_region', 'region_name', array('region_id' => $id));
    }
    
    function get_region_name_by_city_id($id) {
        $province_id = self::get_one('ref_city', 'city_province_id', array('city_id' => $id));
        $region_id = self::get_one('ref_province', 'province_region_id', array('province_id' => $province_id));
        
        return self::get_one('ref_region', 'region_name', array('region_id' => $region_id));
    }
    
    function get_country_name($id) {
        return self::get_one('ref_country', 'country_name', array('country_id' => $id));
    }
    
    function get_bank_name($id) {
        return self::get_one('ref_bank', 'bank_name', array('bank_id' => $id));
    }

    function get_menu($block = 'sidebar') {
        $sql = "SELECT * FROM site_menu WHERE menu_block = '" . $block . "' AND menu_is_active = '1' ORDER BY menu_par_id ASC, menu_order_by ASC";
        return $this->CI->db->query($sql);
    }

    function get_page_home_widget($location = 'frontend') {
        $sql = "
            SELECT widget_name 
            FROM site_page_home_widget 
            LEFT JOIN site_widget ON widget_id = page_home_widget_widget_id 
            WHERE page_home_widget_location = '" . $location . "' 
            ORDER BY page_home_widget_order_by ASC
        ";
        return $this->CI->db->query($sql);
    }

    function get_page_widget($page_id = '') {
        $sql = "
            SELECT widget_name 
            FROM site_page_widget 
            LEFT JOIN site_widget ON widget_id = page_widget_widget_id 
            WHERE page_widget_page_id = '" . $page_id . "' 
            ORDER BY page_widget_order_by ASC
        ";
        return $this->CI->db->query($sql);
    }

    function get_superuser_menu($menu_par_id = null) {
        $where_option = "";
        if($menu_par_id != null) {
            $where_option = " AND administrator_menu_par_id = '" . $menu_par_id . "'";
        }
        $sql = "
            SELECT * 
            FROM site_administrator_menu 
            WHERE administrator_menu_is_active = '1' 
            " . $where_option . "
            ORDER BY administrator_menu_order_by ASC
        ";
        return $this->CI->db->query($sql);
    }

    function get_administrator_menu($administrator_group_id = 0, $menu_par_id = null) {
        $where_option = "";
        if($menu_par_id != null) {
            $where_option = " AND administrator_menu_par_id = '" . $menu_par_id . "'";
        }
        $sql = "
            SELECT site_administrator_menu.*, 
            administrator_privilege_action 
            FROM site_administrator_menu 
            INNER JOIN site_administrator_privilege ON administrator_menu_id = administrator_privilege_administrator_menu_id 
            WHERE administrator_menu_is_active = '1' 
            AND administrator_privilege_administrator_group_id = '" . $administrator_group_id . "' 
            " . $where_option . "
            ORDER BY administrator_menu_order_by ASC
        ";
        return $this->CI->db->query($sql);
    }
    
    function get_list_bank() {
        $sql = "SELECT * FROM ref_bank WHERE bank_is_active = '1' ORDER BY bank_name ASC";
        return $this->CI->db->query($sql);
    }
    
    function get_list_country() {
        $sql = "SELECT * FROM ref_country WHERE country_is_active = '1' ORDER BY country_name ASC";
        return $this->CI->db->query($sql);
    }
    
    function get_list_region() {
        $sql = "SELECT * FROM ref_region WHERE region_is_active = '1' ORDER BY region_name ASC";
        return $this->CI->db->query($sql);
    }
    
    function get_list_province($region_id = '') {
        $where = "WHERE province_is_active = '1'";
        if($region_id != '') {
            $where .= " AND province_region_id = '" . $region_id . "'";
        }
        $sql = "SELECT * FROM ref_province " . $where . " ORDER BY province_id ASC";
        
        return $this->CI->db->query($sql);
    }
    
    function get_list_city($province_id = '') {
        $where = "WHERE city_is_active = '1'";
        if($province_id != '') {
            $where .= " AND city_province_id = '" . $province_id . "'";
        }
        $sql = "SELECT * FROM ref_city " . $where . " ORDER BY city_name ASC";
        
        return $this->CI->db->query($sql);
    }
    
    function get_city_province_options() {
        $options = array();
        $query_province = $this->get_list_province();
        if ($query_province->num_rows() > 0) {
            foreach ($query_province->result() as $row_province) {
                $query_city = $this->get_list_city($row_province->province_id);
                if ($query_city->num_rows() > 0) {
                    foreach ($query_city->result() as $row_city) {
                        $options[$row_province->province_name][$row_city->city_id] = $row_city->city_name;
                    }
                }
            }
        }
        return $options;
    }
    
    function get_city_options() {
        $options = array();
        $query = $this->get_list_city();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $options[$row->city_id] = $row->city_name;
            }
        }
        return $options;
    }
    
    function get_province_options() {
        $options = array();
        $query = $this->get_list_province();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $options[$row->province_id] = $row->province_name;
            }
        }
        return $options;
    }
    
    function get_region_options() {
        $options = array();
        $query = $this->get_list_region();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $options[$row->region_id] = $row->region_name;
            }
        }
        return $options;
    }
    
    function get_country_options() {
        $options = array();
        $options[null] = '=========== Pilih Negara ===========';
        $query = $this->get_list_country();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $options[$row->country_id] = $row->country_name;
            }
        }
        return $options;
    }
    
    function get_bank_options() {
        $options = array();
        $options[null] = 'N/A';
        $query = $this->get_list_bank();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $options[$row->bank_id] = $row->bank_name;
            }
        }
        return $options;
    }
    
    function get_identity_type_options() {
        $options = array();
        $options[null] = 'Jenis Identitas';
        $options['ktp'] = 'KTP';
        $options['sim'] = 'SIM';
        $options['paspor'] = 'Paspor';
        
        return $options;
    }
    
    function get_sex_options() {
        $options = array();
        $options['male'] = 'Pria';
        $options['female'] = 'Wanita';
        
        return $options;
    }
    
    function get_city_grid_options() {
        $grid_options = '';
        $query = $this->get_list_city();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $grid_options .= $row->city_id . ':' . $row->city_name . '|';
            }
            $grid_options = rtrim($grid_options, '|');
        }
        return $grid_options;
    }
    
    function get_province_grid_options() {
        $grid_options = '';
        $query = $this->get_list_province();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $grid_options .= $row->province_id . ':' . $row->province_name . '|';
            }
            $grid_options = rtrim($grid_options, '|');
        }
        return $grid_options;
    }
    
    function get_region_grid_options() {
        $grid_options = '';
        $query = $this->get_list_region();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $grid_options .= $row->region_id . ':' . $row->region_name . '|';
            }
            $grid_options = rtrim($grid_options, '|');
        }
        return $grid_options;
    }
    
    function get_country_grid_options() {
        $grid_options = '';
        $query = $this->get_list_country();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $grid_options .= $row->country_id . ':' . $row->country_name . '|';
            }
            $grid_options = rtrim($grid_options, '|');
        }
        return $grid_options;
    }
    
    function get_bank_grid_options() {
        $grid_options = '';
        $query = $this->get_list_bank();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $grid_options .= $row->bank_id . ':' . $row->bank_name . '|';
            }
            $grid_options = rtrim($grid_options, '|');
        }
        return $grid_options;
    }
    
    function get_site_configuration() {
        $sql = "SELECT configuration_name, configuration_value FROM site_configuration";
        $query = $this->CI->db->query($sql);
        
        $site_configuration = array();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $site_configuration[$row->configuration_name] = $row->configuration_value;
            }
        }
        return $site_configuration;
    }
    
    function get_sys_configuration() {
        $sql = "SELECT configuration_name, configuration_value FROM sys_configuration";
        $query = $this->CI->db->query($sql);
        
        $sys_configuration = array();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $sys_configuration[$row->configuration_name] = $row->configuration_value;
            }
        }
        return $sys_configuration;
    }
    
    function get_query_condition($params, $count = false) {
        $arr_condition = array();
        
        $arr_condition['parent_select'] = "*";
        if($count) {
            $arr_condition['parent_select'] = "COUNT(*) AS row_count";
        }
        
        $arr_condition['table'] = "";
        if(isset($params['table'])) {
            $arr_condition['table'] = $params['table'];
        }
        
        $arr_condition['select'] = "*";
        if(isset($params['select'])) {
            $arr_condition['select'] = $params['select'];
        }
        
        $arr_condition['join'] = "";
        if(isset($params['join'])) {
            $arr_condition['join'] = $params['join'];
        }
        
        $arr_condition['where_detail'] = " WHERE 1 ";
        if(isset ($params['where_detail'])) {
            $arr_condition['where_detail'] .= "AND " . $params['where_detail'];
        }
        
        $arr_condition['group_by_detail'] = "";
        if(isset ($params['group_by_detail'])) {
            $arr_condition['group_by_detail'] = "GROUP BY " . $params['group_by_detail'];
        }
        
        $arr_condition['where'] = " WHERE 1 ";
        if(isset($params['query']) && $params['query'] != false && $params['query'] != '') {
            $arr_condition['where'] .= "AND " . $params['qtype'] . " LIKE '%" . mysql_real_escape_string($params['query']) . "%' ";
        } elseif(isset($params['optionused']) && $params['optionused'] == 'true') {
            $arr_condition['where'] .= "AND " . $params['qtype'] . " = '" . $params['option'] . "' ";
        } elseif((isset($params['date_start']) && $params['date_start'] != false) && (isset($params['date_end'])) && $params['date_end'] != false) {
            $arr_condition['where'] .= "AND DATE(" . $params['qtype'] . ") BETWEEN '" . mysql_real_escape_string($params['date_start']) . "' AND '" . mysql_real_escape_string($params['date_end']) . "' ";
        } elseif((isset($params['num_start']) && $params['num_start'] != false) && (isset($params['num_end'])) && $params['num_end'] != false) {
            $arr_condition['where'] .= "AND " . $params['qtype'] . " BETWEEN '" . mysql_real_escape_string($params['num_start']) . "' AND '" . mysql_real_escape_string($params['num_end']) . "' ";
        }
        
        if(isset($params['where'])) {
            $arr_condition['where'] .= "AND " . $params['where'];
        }
        
        $arr_condition['group_by'] = "";
        if(isset ($params['group_by'])) {
            $arr_condition['group_by'] = "GROUP BY " . $params['group_by'];
        }
        
        $arr_condition['sort'] = "";
        if(isset($params['sortname']) && isset($params['sortorder']) && $count == false) {
            $arr_condition['sort'] = "ORDER BY " . $params['sortname'] . " " . $params['sortorder'];
        }
        
        $arr_condition['limit'] = "";
        if(isset($params['rp']) && $count == false) {
            $offset = (($params['page'] - 1) * $params['rp']);
            $arr_condition['limit'] = "LIMIT $offset, " . $params['rp'];
        }
        
        return $arr_condition;
    }
    
    function get_query_data($params, $count = false) {
        extract($this->get_query_condition($params, $count));
        $sql = "
            SELECT $parent_select  
            FROM 
            (
                SELECT $select 
                FROM $table 
                $join 
                $where_detail 
                $group_by_detail
            ) result 
            $where 
            $group_by 
            $sort
            $limit
        ";
        $query = $this->CI->db->query($sql);
        
        if($count) {
            $row = $query->row();
            return $row->row_count;
        } else {
            return $query;
        }
    }
    
    function export_excel_standard($data = false) {
        if($data) {
            $this->CI->load->library('Excel');
            
            // Initiate cache
            $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
            $cacheSettings = array('memoryCacheSize' => '32MB');
            PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
            
            $arr_style_title = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'EEEEEE')
                ),
                'alignment' => array(
                    'wrap' => true,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );
            
            $arr_style_content = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'wrap' => true,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );
            
            extract($data);
            $filename = url_title($title) . '-' . date("YmdHis");
            $arr_column_name = json_decode($column['name']);
            $arr_column_show = json_decode($column['show']);
            $arr_column_align = json_decode($column['align']);
            $arr_column_title = json_decode($column['title']);

            $first_column = $cell_column = 'A';
            $cell_row = $first_row = 1;
            $excel = new PHPExcel();
            $excel->getProperties()->setTitle($title)->setSubject($title);
            $excel->getActiveSheet()->setTitle(substr($title, 0, 31));
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getDefaultStyle()->getFont()->setName('Calibri');
            $excel->getDefaultStyle()->getFont()->setSize(10);

            //title
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setSize(13);
            $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, strtoupper($title));
            $cell_row++;
            $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, 'Tanggal Export : ' . convert_datetime(date("Y-m-d H:i:s"), 'id'));
            $cell_row++;
            $cell_row++;

            if(is_array($arr_column_title)) {
                $cell_column = $first_column;
                $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(20);
                foreach($arr_column_title as $id => $value) {
                    if($arr_column_show[$id] == true) {
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getFont()->setBold(true)->setSize(11);
                        $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_title);
                        $excel->getActiveSheet()->getColumnDimension($cell_column)->setWidth(ceil(1.5 * strlen($value) + 0.6));

                        $excel->setActiveSheetIndex(0)->setCellValue($cell_column . $cell_row, strtoupper($value));
                        $cell_column++;
                    }
                }
                $cell_row++;
            }

            if($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $cell_column = $first_column;
                    $excel->getActiveSheet()->getRowDimension($cell_row)->setRowHeight(17);
                    foreach($arr_column_name as $id => $value) {
                        if($arr_column_show[$id] == true) {
                            if(!isset($row->$value)) {
                                $data = '';
                            } else {
                                $data = stripslashes($row->$value);
                            }
                            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->getAlignment()->setHorizontal($arr_column_align[$id]);
                            $excel->getActiveSheet()->getStyle($cell_column . $cell_row)->applyFromArray($arr_style_content);
                            $excel->setActiveSheetIndex(0)->setCellValueExplicit($cell_column . $cell_row, $data, PHPExcel_Cell_DataType::TYPE_STRING);
                            $cell_column++;
                        }
                    }
                    $cell_row++;
                }
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $write->save('php://output');
            exit;
        }
    }
    
    function get_week_date_range($date, $weekly_start_day = 0) {
        $arr_days = array(
            0 => 'sunday',
            1 => 'monday',
            2 => 'tuesday',
            3 => 'wednesday',
            4 => 'thursday',
            5 => 'friday',
            6 => 'saturday'
        );
        $str_date = strtotime($date);
        $str_start_date = (date('w', $str_date) == $weekly_start_day) ? $str_date : strtotime('last ' . $arr_days[$weekly_start_day], $str_date);
        $start_date = date("Y-m-d", $str_start_date);
        $end_date = date("Y-m-d", mktime(0, 0, 0, date("n", strtotime($start_date)), date("j", strtotime($start_date)) + 6, date("Y", strtotime($start_date))));
        
        return array($start_date, $end_date);
    }
    
}