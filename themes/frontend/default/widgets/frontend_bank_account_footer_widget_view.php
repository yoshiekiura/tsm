<?php
if(!empty($query)){
    foreach ($query as $row){
        echo '<li>
                <a href="#"><img src="'. base_url().'media/'._dir_bank.'144/55/'.$row->bank_logo.'"></a>
                <span>'.$row->bank_account_no.'</span>
                <span>An '.$row->bank_account_name.'</span>
            </li>';
    }
}
?>