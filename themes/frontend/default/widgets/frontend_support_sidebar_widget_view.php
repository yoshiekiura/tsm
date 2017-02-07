<?php
if(!empty($query)){
    foreach ($query as $row){
        echo '<div class="well well-small">
                <a href="ymsgr:sendIM?'.$row->support_ym.'">
                    <img class="support" src="http://opi.yahoo.com/online?u='.$row->support_ym.'&amp;m=g&amp;t=14" alt="'.$row->support_ym.'"></a>
                <span><small>'.$row->support_name.'</small></span>
                <span><small>'.$row->support_phone.'</small></span>
            </div>';
    }
}
?>
