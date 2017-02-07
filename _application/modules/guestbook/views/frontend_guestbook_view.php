<div class="span8">
    <div class="titles">
        <div class="row-fluid">
            <h2><?php echo isset($page_title)?$page_title:'&nbsp;';?></h2>
        </div>
    </div>
    <div class="row-fluid">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#peringkat" data-toggle="tab"><b style="font-size: 13px; color: #096b8e;"><img src="images/icon_shop.png">&nbsp;&nbsp;&nbsp; Contact Milagros</b></a></li>
        </ul>
    </div>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="peringkat">
            
            <h4 style="color: #096b8e;">Milagros Office</h4>
            <div class="row-fluid">
                <div class="span3"><img src="<?php $themes_url?>/images/logo.png"></div>
                <div class="span9">
                    <span style="font-size: 12px; line-height: normal; color: #352667; font-family: arial;">
                        <b>Jl. Pandang Raya Ruko Saphire III No.15, Makassar, Sulawesi Selatan - Indonesia </b><br>
                        Telp. (0411) 434847 fax. (0411) 4664086 <br>
                        Buka Setiap hari kerja Pkl.09.00 sd 19.00 WITA <br>
                        Minggu Pkl 13.00 sd 19.00 WITA <br>	
                    </span>
                </div>
            </div>
            <br><br>

            <div class="well well-small">
                <br>
                <form id="contact-form" class="contact-form">
                    <div class="success-message">Contact form submitted.</div>
                    <?php
                    $x=1;
                    if(!empty($query)){
                        foreach ($query as $row){
                            echo '<div class="coll-'.$x.'">
                                    <label class="'.substr($row->guestbook_configuration_name, 0, -8).'">
                                        <input type="text" >
                                        <span class="empty-message">*This field is required.</span>
                                        <span class="error-message">*This is not a valid name.</span>
                                        <span class="_placeholder" style="left: 0px; top: 0px; width: 217px; height: 41px;">Name:</span></label>
                                </div>';
                            $x++;
                        }
                    }
                    ?>
                    <div class="coll-1">
                        <label class="name">
                            <input type="text" data-constraints="@Required @JustLetters" id="regula-generated-423351">
                            <span class="empty-message">*This field is required.</span>
                            <span class="error-message">*This is not a valid name.</span>
                            <span class="_placeholder" style="left: 0px; top: 0px; width: 217px; height: 41px;">Name:</span></label>
                    </div>
                    <div class="coll-2">
                        <label class="email">
                            <input type="text" data-constraints="@Required @Email" id="regula-generated-427591">
                            <span class="empty-message">*This field is required.</span>
                            <span class="error-message">*This is not a valid email.</span>
                            <span class="_placeholder" style="left: 0px; top: 0px; width: 217px; height: 41px;">Email:</span></label>
                    </div>
                    <div class="coll-3">
                        <label class="phone">
                            <input type="text" data-constraints="@JustNumbers" id="regula-generated-721532">
                            <span class="empty-message">*This field is required.</span>
                            <span class="error-message">*This is not a valid phone.</span>
                            <span class="_placeholder" style="left: 0px; top: 0px; width: 217px; height: 41px;">Phone:</span></label>
                    </div>
                    <label class="message">
                        <textarea data-constraints="@Required @Length(min=20,max=999999)" id="regula-generated-526310"></textarea>
                        <span class="empty-message">*This field is required.</span>
                        <span class="error-message">*The message is too short.</span>
                        <span class="_placeholder" style="left: 0px; top: 0px; width: 744px; height: 181px;">Message:</span></label>
                    <div class="btns">
                        <a href="#" data-type="submit" class="btn btn-link1">submit</a>
                    </div>  
                </form>
            </div>
            <div class="clearfix"></div>								
        </div>
    </div>

</div>