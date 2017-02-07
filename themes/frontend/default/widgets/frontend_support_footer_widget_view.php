<ul class="list-5">
    <?php
    if(!empty($query)){
        foreach ($query as $row){
            echo '<li>
                    <a href="ymsgr:sendIM?'.$row->support_ym.'">
                        <img src="http://opi.yahoo.com/online?u='.$row->support_ym.'&amp;m=g&amp;t=1" alt="'.$row->support_ym.'">
                    </a>
                    <span>'.$row->support_name.'</span>
                </li>';
        }
    }
    ?>
</ul>	
<br>