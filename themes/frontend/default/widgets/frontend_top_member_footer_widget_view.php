<div class="widget span4">
    <h4><strong style="color: #000!important;">Member</strong><br> Baru</h4>
    <hr>
    <marquee behavior="scroll" direction="up" scrollamount="1" scrolldelay="50" height="220" width="100%">
        <table id="table-list1" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <?php
                if(!empty($new_member)){
                    foreach ($new_member as $row_new){
                        $mem_image = !empty($row_new->member_detail_image)?$row_new->member_detail_image:'_default.png';
                        echo '<tr>
                                <td class="pic"><img src="'. base_url()._dir_member.$mem_image.'"></td>
                                <td class="addr">
                                    <p><strong><span>'.$row_new->network_code.'</span> <br>'.$row_new->member_name.'</strong><br />
                                        '.$this->function_lib->get_city_name($row_new->member_city_id).'</p>
                                </td>
                            </tr>';
                    }
                }
                ?>
            </tbody>
        </table>                                
    </marquee>						
</div>	

<div class="widget span4">
    <h4><strong style="color: #000!important;">Top</strong> <br>Income</h4>
    <hr>
    <marquee behavior="scroll" direction="up" scrollamount="1" scrolldelay="50" height="220" width="100%">
        <table id="table-list1" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <?php
                if(!empty($top_income)){
                    foreach ($top_income as $row_income){
                        $mem_image = !empty($row_income->member_detail_image)?$row_income->member_detail_image:'_default.png';
                        echo '<tr>
                                <td class="pic"><img src="'. base_url()._dir_member.$mem_image.'"></td>
                                <td class="addr">
                                    <p><strong><span>'.$row_income->network_code.'</span> <br>'.$row_income->member_name.'</strong><br />
                                        '.$this->function_lib->get_city_name($row_income->member_city_id).'</p>
                                </td>
                            </tr>';
                    }
                }
                ?>
            </tbody>
        </table>                                
    </marquee>	
</div>	

<div class="widget span4">
    <h4><strong style="color: #000!important;">Top</strong><br> Sponsor</h4>
    <hr>
    <marquee behavior="scroll" direction="up" scrollamount="1" scrolldelay="50" height="220" width="100%">
        <table id="table-list1" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <?php
                if(!empty($top_sponsor)){
                    foreach ($top_sponsor as $row_sponsor){
                        $mem_image = !empty($row_sponsor->member_detail_image)?$row_sponsor->member_detail_image:'_default.png';
                        echo '<tr>
                                <td class="pic"><img src="'. base_url()._dir_member.$mem_image.'" width="64"></td>
                                <td class="addr">
                                    <p><strong><span>'.$row_sponsor->network_code.'</span> <br>'.$row_sponsor->member_name.'</strong><br />
                                        '.$this->function_lib->get_city_name($row_sponsor->member_city_id).'</p>
                                </td>
                            </tr>';
                    }
                }
                ?>
            </tbody>
        </table>                                
    </marquee>							
</div>