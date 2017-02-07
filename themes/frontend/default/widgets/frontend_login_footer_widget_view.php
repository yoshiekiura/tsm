<div class="span4">
    <div class="widget_login_top">
        <h4 class="titles" id="login_widget"><span><b>Member Area</b></span></h4>
        <div class="well well-small" style="margin-bottom:10px;">
            <?php
            if (isset($this->arr_flashdata['login_widget_message'])) {
                echo $this->arr_flashdata['login_widget_message'];
            } else {
                echo '<div class="alert alert-info">Bagi anda yang telah bergabung sebagai Member, dapat mengakses akun anda melalui form dibawah ini</div>';
            }
            ?>
            <div id="login-form"> 
                <div class="rounded-frame">
                    <span>
                        <form class="formTable" action="" method="post">
                            <?php echo form_hidden('uri_string', uri_string()); ?>
                            <!--<label for="loginUsername">Username</label>-->
                            <div> 
                                <input placeholder="Username..." class="qwerty ui-keyboard-input ui-widget-content ui-corner-all" type="text" name="username" id="loginUsername" autocomplete="off" aria-haspopup="true" role="textbox">
                                <img id="icoUsername" class="tooltip" title="Klik untuk membuka Virtual Keyboard" src="<?php echo $themes_url; ?>/images/keyboard.png">
                            </div>
                                
                            <!--<label for="loginPassword">Password</label>-->
                            <div> 
                                <input placeholder="Password..." class="qwerty ui-keyboard-input ui-widget-content ui-corner-all" type="password" name="password" id="loginPassword" autocomplete="off" aria-haspopup="true" role="textbox">
                                <img id="icoPassword" class="tooltip" title="Klik untuk membuka Virtual Keyboard" src="<?php echo $themes_url; ?>/images/keyboard.png">									
                            </div>
                            
                            <!--<label for="captchaResponse">Kode Unik</label>-->
                            <div> 
                                <input placeholder="Kode Unik..." type="text" name="kode_unik" id="captchaResponse">
                                <img id="captcha_image" src="<?php echo site_url('voffice/login/captcha/widget'); ?>" align="left" style="border:0; margin-top:10px;">
                                <a id="captcha_reload" tabindex="-1" title="Ganti Kode Unik" style="border-style:none; top:8px;">
                                    <img src="<?php echo $themes_url; ?>/images/refresh.png" alt="Ganti Kode Unik" border="0" align="bottom" style="margin-left:30px; cursor:pointer;">
                                </a>
                            </div>
                            <script>
                                $(function(){
                                    $("#captcha_reload").click(function(){
                                        var url = '<?php echo site_url('voffice/login/captcha/widget'); ?>';
                                        $("#captcha_image").attr('src', url + '?' + Math.random());
                                    });
                                });
                            </script>
                            
                            <center>
                                <input type="submit" name="login_v_office" value="Login" class="roundButtonSmall" style="margin-top:10px;">
                            </center>
                        </form>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>