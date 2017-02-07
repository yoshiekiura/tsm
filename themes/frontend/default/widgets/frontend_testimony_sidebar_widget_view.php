<?php
if(!empty($query)){
    foreach ($query as $row_testi){
        
        echo '<li>
                <blockquote>'.$row_testi->testimony_content.'
                    <p style="text-align:right;margin-right:20px;">- '.$row_testi->testimony_name.'</p>	
                </blockquote>
            </li>';
    }
}
?>