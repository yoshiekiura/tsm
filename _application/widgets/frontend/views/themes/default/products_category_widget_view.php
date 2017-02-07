<?php
$arr_products_category = array();
$generate_data = '';
if (!empty($rs_products_category)) {
    foreach ($rs_products_category as $row_products_category) {
        $arr_products_category[$row_products_category->products_category_par_id][$row_products_category->products_category_order_by] = $row_products_category;
    }
}

// cari root category
if (array_key_exists('0', $arr_products_category)) {

    // urutkan root category berdasarkan products_category_order_by
    ksort($arr_products_category[0]);

    // ekstrak root category
    $i = 1;
    $x = 1;
    foreach ($arr_products_category[0] as $root_category_sort => $root_category_value) {

        // cari subcategory 1
        if (array_key_exists($root_category_value->products_category_id, $arr_products_category)) {
            
            if ($root_category_value->products_category_image != '' && file_exists(_dir_products_category . $root_category_value->products_category_image)) {
                $products_category_image = '<img src="' . base_url() . _dir_products_category . $root_category_value->products_category_image . '" alt="" />';
            } else {
                $products_category_image = '';
            }
            
            switch ($i) {
                case 1:
                    $gallery_block = 'galleries-left';
                    break;
                
                case 2:
                    $gallery_block = 'galleries-middle-left';
                    break;
                
                case 3:
                    $gallery_block = 'galleries-middle-right';
                    break;
                
                case 4:
                    $gallery_block = 'galleries-right';
                    break;
                
                default:
                    $gallery_block = '';
                    break;
            }
            
            if($i == 1) {
                $generate_data .= '<div class="galleries">';
            }
            
            $generate_data .= '<div class="' . $gallery_block . '">';
            $generate_data .= '<div class="galleries-image">' . $products_category_image . '</div>';
            $generate_data .= '<h2>' . $root_category_value->products_category_title . '</h2>';
            $generate_data .= '<div id="dw-scroll-area-' . $i . '" class="dw-scroll-area">';
            $generate_data .= '<ul id="dw-scroll-content-' . $i . '" class="dw-scroll-content">';

            // urutkan subcategory 1 berdasarkan products_category_order_by
            ksort($arr_products_category[$root_category_value->products_category_id]);

            // ekstrak subcategory 1 yang par_id adalah products_category_id dari root category
            foreach ($arr_products_category[$root_category_value->products_category_id] as $sub_category_1_sort => $sub_category_1_value) {
                $generate_data .= '<li><a href="' . base_url() . 'collections/view/' . $sub_category_1_value->products_category_id . '-' . url_title($sub_category_1_value->products_category_title) . '" title="' . $sub_category_1_value->products_category_title . '">' . $sub_category_1_value->products_category_title . '</a></li>';
            }
            
            $generate_data .= '</ul>';
            $generate_data .= '</div>';
            $generate_data .= '<div id="dw-scroll-links-' . $i . '" class="dw-scroll-links"></div>';
            $generate_data .= '</div>';
            
            if($i == 4) {
                $generate_data .= '<div class="clear"></div>';
                $generate_data .= '</div>';
                $generate_data .= '<div class="hr"></div>';
            }
            
            if($i >= 4) {
                $i = 1;
            } else {
                $i++;
            }
            $x++;
        }
    }
    if((($x - 1) % 4) != 0) {
        $generate_data .= '<div class="clear"></div>';
        $generate_data .= '</div>';
    }
}

echo $generate_data;
?>