<div class="row-fluid">
    <div class="span12" style="height: 350px;">
        <div class="titles">
            <h2><?php echo $widget_title;?></h2>
        </div>
        <div id="testimonial">
            <div class="row-fluid">
                <blockquote class="oval-thought">
                    <ul id="side-testimoni" class="newsticker">
                        <?php
                        if(!empty($query)){
                            foreach ($query as $row_testi){
                        ?>
                        <li style="display: none;">
                            <div class="testi-id">
                                <img src="<?php echo $themes_url; ?>/images/member.png" class="pic">
                                <p>
                                    <span><strong><?php echo $row_testi->testimony_name;?></strong></span>
                                    <span><?php echo $row_testi->testimony_date;?></span>
                                </p>												
                            </div>
                            <p class="quotes"> <?php echo $row_testi->testimony_content;?></p>
                        </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </blockquote>
            </div>
        </div>
    </div>						
</div>	